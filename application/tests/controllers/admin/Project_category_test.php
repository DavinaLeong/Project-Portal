<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Project_category_test.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 07 Mar 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Project_category_test extends TestCase
{
    const DO_ECHO = TRUE;
    const PC_DESCRIPTION = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    const STATUS_PUBLISH = 'Publish';
    const STATUS_DRAFT = 'Draft';

    public function setUp()
    {
        $this->resetInstance();
        $CI =& get_instance();
        $CI->load->model('Migration_model');
        $CI->Migration_model->reset();

        $CI->load->model('Project_category_model');
        $CI->load->helper('datetime_format');
        $this->_truncate_table();

        $this->_login();
    }

    public function tearDown()
    {
        $this->_logout();
        $this->_truncate_table();
    }

    #Helper Functions
    private function _login($do_echo=FALSE)
    {
        $this->request('POST', 'admin/authenticate/login',
            array(
                'username' => 'admin',
                'password' => 'password'
            )
        );

        $this->request('GET', 'admin/authenticate/start');
        if($do_echo) echo "\*** logged in ***\n";
    }

    private function _logout($do_echo=FALSE)
    {
        $this->request('GET', 'admin/authenticate/logout');
        $this->request('GET', 'admin/authenticate/login');
        if($do_echo) echo "\n*** logged out ***\n";
    }

    public function _insert_record($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->model('Project_category_model');

        $project_category = array(
            'platform_id' => 1,
            'pc_name' => 'Project Category 1',
            'pc_icon' => 'fa-flag',
            'pc_description' => $this::PC_DESCRIPTION,
        );
        $project_category['platform_id'] = $CI->Project_category_model->insert($platform);

        if($do_echo)
        {
            echo "\n--- project categories inserted ---";
            echo "\n||| count: " . $CI->Platform_model->count_all();
            echo "\n||| pc_id: " . $project_category['pc_id'] . "\n";
        }

        return $project_category;
    }

    public function _insert_super_records($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->model('Platform_model');
        $platform = array(
            'platform_name' => 'Platform 1',
            'platform_icon' => 'fa-flag',
            'platform_description' => $this::PC_DESCRIPTION,
            'platform_status' => $this::STATUS_PUBLISH
        );
        $platform['platform_id'] = $CI->Platform_model->insert($platform);

        if($do_echo)
        {
            echo "\n--- inserted platform records";
            echo "\n||| platform count: " . $CI->Platform_model->count_all();
            echo "\n||| platform_id: " . $platform['platform_id'] . "\n";
        }
        return $platform;
    }

    private function _truncate_table($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->truncate(TABLE_PROJECT_CATEGORY);

        if($do_echo)
        {
            echo "\n--- truncated table: " . TABLE_PROJECT_CATEGORY;
            echo "\n||| count: " . $CI->Project_category_model->count_all() . "\n";
        }
    }

    private function _truncate_super_table($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->truncate(TABLE_PLATFORM);

        if($do_echo)
        {
            echo "\n--- truncated table: " . TABLE_PLATFORM;
            echo "\n||| count: " . $CI->Platform_model->count_all() . "\n";
        }
    }

    private function _platform_ids_str($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->model('Platform_model');
        return implode(',', $CI->Platform_model->get_by_status_ids());
    }
    #endregion

    #Test Functions
    public function test_index()
    {
        if($this::DO_ECHO) echo "\n+++ test_index +++\n";

        $output = $this->request('GET', 'admin/project_category/index');
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project_category/browse');
    }

    public function test_browse()
    {
        if($this::DO_ECHO) echo "\n+++ test_browse +++\n";

        $output = $this->request('GET', 'admin/project_category/browse');
        $this->assertResponseCode(200);
        $this->assertContains('Browse Project Categories', $output);
    }

    public function test_create()
    {
        if($this::DO_ECHO) echo "\n+++ test_create +++\n";

        $output = $this->request('GET', 'admin/project_category/create');
        $this->assertResponseCode(200);
        $this->assertContains('Create Project Category', $output);
        $this->_insert_super_records();

        $project_category = array(
            'platform_id' => 1,
            'pc_name' => 'Project Category 1',
            'pc_description' => $this::PC_DESCRIPTION,
            'pc_icon' => 'fa-flag'
        );
        $this->request('POST', 'admin/project_category/create', $project_category);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project_category/view/1');

        $this->_truncate_super_table();
    }

    public function test_create_validation()
    {
        if($this::DO_ECHO) echo "\n+++ test_create_validation +++\n";

        $CI =& get_instance();
        $CI->load->model('Platform_model');
        $platform = array(
            'platform_name' => 'Platform 1',
            'platform_icon' => 'fa-flag',
            'platform_description' => $this::PC_DESCRIPTION,
            'platform_status' => $this::STATUS_PUBLISH
        );
        $CI->Platform_model->insert($platform);

        $url = 'admin/project_category/create';
        $project_category = array(
            'platform_id' => 1,
            'pc_name' => 'Project Category 1',
            'pc_description' => $this::PC_DESCRIPTION,
            'pc_icon' => 'fa-flag'
        );

        #region Project ID
        $output = $this->request('POST', $url,
            array(
                'platform_id' => '',
                'pc_name' => $project_category['pc_name'],
                'pc_description' => $project_category['pc_description'],
                'pc_icon' => $project_category['pc_icon']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Platform field is required.', $output);

        $output = $this->request('POST', $url,
            array(
                'platform_id' => 2,
                'pc_name' => $project_category['pc_name'],
                'pc_description' => $project_category['pc_description'],
                'pc_icon' => $project_category['pc_icon']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Platform field must be one of: ' . $this->_platform_ids_str() . '.', $output);
        #endregion

        #region PC Name
        $output = $this->request('POST', $url,
            array(
                'platform_id' => $project_category['platform_id'],
                'pc_name' => '',
                'pc_description' => $project_category['pc_description'],
                'pc_icon' => $project_category['pc_icon']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Name field is required.', $output);
        #endregion

        #region PC Name
        $output = $this->request('POST', $url,
            array(
                'platform_id' => $project_category['platform_id'],
                'pc_name' => $project_category['pc_name'],
                'pc_description' => $project_category['pc_description'],
                'pc_icon' => ''
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Icon field is required.', $output);
        #endregion

        #region PC Description
        $output = $this->request('POST', $url,
            array(
                'platform_id' => $project_category['platform_id'],
                'pc_name' => $project_category['pc_name'],
                'pc_description' => '',
                'pc_icon' => $project_category['pc_icon']
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project_category/view/1');
        #endregion
    }
    #endregion

} //end Project_category_test class