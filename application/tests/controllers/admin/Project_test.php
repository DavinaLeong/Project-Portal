<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Project_test.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 09 Mar 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Project_test extends TestCase
{
    const DO_ECHO = TRUE;

    const STATUS_PUBLISH = 'Publish';
    const STATUS_DRAFT = 'Draft';

    const DESCRIPTION = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    public function setUp()
    {
        $this->resetInstance();
        $CI =& get_instance();
        $CI->load->model('Migration_model');

        $this->_truncate_table();
        $this->_truncate_super_tables();
        $this->_login();
    }

    public function tearDown()
    {
        $this->_logout();
        $this->_truncate_table();
        $this->_truncate_super_tables();
    }

    #region Helper Functions
    private function _login($do_echo=FALSE)
    {
        $this->request('POST', 'admin/authenticate/login',
            array(
                'username' => 'admin',
                'password' => 'password'
            )
        );
        $this->request('GET', 'admin/authenticate/start');
        if($do_echo) echo "\n--- logged in ---\n";
    }

    private function _logout($do_echo=FALSE)
    {
        $this->request('GET', 'admin/authenticate/logout');
        $this->request('GET', 'admin/authenticate/login');
    }

    private function _insert_super_records()
    {
        $CI =& get_instance();

        #region Platform
        $CI->load->model('Platform_model');
        $platform = array(
            'platform_name' => 'Platform 1',
            'platform_icon' => 'fa-flag',
            'platform_description' => $this::DESCRIPTION,
            'platform_status' => $this::STATUS_PUBLISH
        );
        $platform['platform_id'] = $CI->Platform_model->insert($platform);
        if($do_echo)  echo "\n--- inserted platform ---\n";
        #endregion

        #region Project Category
        $CI->load->model('Project_category_model');
        $platform_category = array(
            'platform_id' => 1,
            'pc_name' => 'Project Category 1',
            'pc_description' => $this::DESCRIPTION,
            'pc_icon' => 'fa-flag'
        );
        $project_category['pc_id'] = $CI->Project_category_model->insert($project_category);
        if($do_echo) echo "\n--- inserted project category ---\n";
        #endregion
    }

    private function _insert_records($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->model('Project_model');
        $project = array(
            'pc_id' => 1,
            'project_name' => 'Project 1',
            'project_icon' => 'fa-flag',
            'project_description' => $this::DESCRIPTION,
            'selected_project' => 0,
            'project_status' => $this::STATUS_PUBLISH
        );
        $project['project_id'] = $CI->Project_model->insert($project);
        if($do_echo)
        {
            echo "--- inserted projects ---";
            echo "||| project count: " . $CI->Project_model->count_all() . "\n";
        }
        return $project;
    }

    private function _truncate_super_tables($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();

        $CI->db->truncate(TABLE_PLATFORM);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PLATFORM;
            $CI->load->model('Platform_model');
            echo "\n||| platform count:" . $CI->Platform_model->count_all() . "\n";
        }

        $CI->db->truncate(TABLE_PROJECT_CATEORY);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PROJECT_CATEGORY;
            $CI->load->model('Project_category_model');
            echo "\n||| project category count: " . $CI->Project_category_model->count_all() . "\n";
        }

        return array(
            'platform' => $platform,
            'project_category' => $project_category
        );
    }

    private function _truncate_table($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();
        
        $CI->db->truncate(TABLE_PROJECT);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PROJECT;
            $CI->load->model('Project_model');
            echo "\n||| project count: " . $CI->Project_model->count_all() . "\n";
        }
    }
    #endregion

    #region Test Functions
    public function test_index()
    {
        if($this::DO_ECHO) echo "\n+++ test_index +++\n";

        $this->request('GET', 'admin/project/index');
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/browse');
    }

    public function test_browse()
    {
        if($this::DO_ECHO) echo "\n+++ test_browse +++\n";

        $output = $this->request('GET', 'admin/project/browse');
        $this->assertResponseCode(200);
        $this->assertContains('Projects', $output);
    }

    public function test_create()
    {
        if($this::DO_ECHO) echo "\n+++ test_create +++\n";

        $output = $this->request('GET', 'admin/project/create');
        $this->assertResponseCode(200);
        $this->assertContains('Create Project', $output);

        $this->_insert_super_records();
        $this->request('POST', 'admin/project/create',
            array(
                'project_name' => 'Project 1',
                'project_icon' => 'fa-flag',
                'project_description' => $this::DESCRIPTION,
                'selected_project' => 0,
                'project_status' => $this::STATUS_PUBLISH
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/view/1');
    }

    public function test_create_validation()
    {
        if($this::DO_ECHO) echo "\n+++ test_create_validation +++\n";

        $CI =& get_instance();
        $records = $this->_insert_super_records();
        $url = 'admin/project/create';
        $project = array(
            'pc_id' => 1,
            'project_name' => 'Project 1',
            'project_icon' => 'fa-flag',
            'project_description' => $this::DESCRIPTION,
            'selected_project' => 0,
            'project_status' => $this::STATUS_PUBLISH
        );

        #region Project Category ID
        $output = $this->request('POST', $url,
            array(
                'pc_id' => '',
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Category field is required.', $output);
        #endregion
    }

    public function test_view()
    {
        if($this::DO_ECHO) echo "\n+++ test_view +++\n";

        $this->markTestIncomplete('test_view incomplete.');
    }

    public function test_edit()
    {
        if($this::DO_ECHO) echo "\n+++ test_edit +++\n";

        $this->markTestIncomplete('test_edit incomplete.');
    }

    public function test_edit_validation()
    {
        if($this::DO_ECHO) echo "\n+++ test_edit_validation +++\n";

        $this->markTestIncomplete('test_edit_validation incomplete.');
    }

    public function test_delete()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete +++\n";

        $this->markTestIncomplete('test_delete incomplete.');
    }

    public function test_delete_with_sub_records()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete_with_sub_records +++\n";

        $this->markTestIncomplete('test_delete_with_sub_records incomplete.');
    }
    #endregion

}// end Project_test class