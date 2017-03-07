<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Platform_test.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 07 Mar 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Platform_test extends TestCase
{
    const DO_ECHO = FALSE;

    const STATUS_PUBLISH = 'Publish';
    const STATUS_DRAFT = 'Draft';

    const PLATFORM_DESCRIPTION = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    public function setUp()
    {
        $this->resetInstance();
        $CI =& get_instance();
        $CI->load->model('Migration_model');
        $CI->Migration_model->reset();

        $CI->load->model('Platform_model');
        $CI->load->helper('datetime_format');
        $this->_truncate_tables();

        $this->_login();
    }

    public function tearDown()
    {
        $this->_logout();
        $this->_truncate_tables();
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
        $CI->load->model('Platform_model');

        $platform = array(
            'platform_name' => 'Platform 1',
            'platform_icon' => 'fa-flag',
            'platform_description' => $this::PLATFORM_DESCRIPTION,
            'platform_status' => $this::STATUS_PUBLISH
        );
        $platform['platform_id'] = $CI->Platform_model->insert($platform);

        if($do_echo)
        {
            echo "\n--- platform inserted ---";
            echo "\n||| platform count: " . $CI->Platform_model->count_all();
            echo "\n||| platform id: " . $platform['platform_id'] . "\n";
        }

        return $platform;
    }

    private function _truncate_tables($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->truncate(TABLE_PLATFORM);

        if($do_echo)
        {
            echo "\n--- truncated table: " . TABLE_PLATFORM;
            echo "\n||| platform count: " . $CI->Platform_model->count_all() . "\n";
        }
    }
    #endregion

    #region Test Functions
    public function test_index()
    {
        if($this::DO_ECHO) echo "\n+++ test_index +++\n";

        $this->request('GET', 'admin/platform/index');
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/platform/browse');
    }

    public function test_browse()
    {
        if($this::DO_ECHO) echo "\n+++ test_browse +++\n";

        $output = $this->request('GET', 'admin/platform/browse');
        $this->assertResponseCode(200);
        $this->assertContains('Browse Platforms', $output);
    }

    public function test_create()
    {
        if($this::DO_ECHO) echo "\n+++ test_create +++\n";

        $output = $this->request('GET', 'admin/platform/create');
        $this->assertResponseCode(200);
        $this->assertContains('Create Platform', $output);

        $this->request('POST', 'admin/platform/create',
            array(
                'platform_name' => 'Platform 1',
                'platform_icon' => 'fa-flag',
                'platform_description' => $this::PLATFORM_DESCRIPTION,
                'platform_status' => $this::STATUS_PUBLISH
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/platform/view/1');
    }

    public function test_create_validation()
    {
        if($this::DO_ECHO) echo "\n+++ test_create_validation +++\n";

        $url = 'admin/platform/create';

        #region Platform Name
        $output = $this->request('POST', $url,
            array(
                'platform_name' => '',
                'platform_icon' => 'fa-flag',
                'platform_description' => $this::PLATFORM_DESCRIPTION,
                'platform_status' => $this::STATUS_PUBLISH
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Platform Name field is required', $output);
        #endregion

        #region Platform Icon
        $output = $this->request('POST', $url,
            array(
                'platform_name' => 'Platform 1',
                'platform_icon' => '',
                'platform_description' => $this::PLATFORM_DESCRIPTION,
                'platform_status' => $this::STATUS_PUBLISH
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Platform Icon field is required.', $output);
        #endregion

        #region Platform Description
        $output = $this->request('POST', $url,
            array(
                'platform_name' => 'Platform 1',
                'platform_icon' => 'fa-flag',
                'platform_description' => '',
                'platform_status' => $this::STATUS_PUBLISH
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Platform Description field is required.', $output);
        #endregion

        #region Platform Status
        $output = $this->request('POST', $url,
            array(
                'platform_name' => 'Platform 1',
                'platform_icon' => 'fa-flag',
                'platform_description' => $this::PLATFORM_DESCRIPTION,
                'platform_status' => ''
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Platform Status field is required.', $output);

        $output = $this->request('POST', $url,
            array(
                'platform_name' => 'Platform 1',
                'platform_icon' => 'fa-flag',
                'platofmr_description' => $this::PLATFORM_DESCRIPTION,
                'platform_status' => 'Hello'
            )
        );
        $this->assertResponseCode(200);
        $CI =& get_instance();
        $status_str = implode(',', $CI->Platform_model->_status_array());
        $this->assertContains('The Platform Status field must be one of: ' . $status_str . '.', $output);
        #endregion
    }

    public function test_view()
    {
        if($this::DO_ECHO) echo "\n+++ test_view +++\n";
        
        #region Valid Record
        $platform = $this->_insert_record();
        $output = $this->request('GET', 'admin/platform/view/' . $platform['platform_id']);
        $this->assertResponseCode(200);
        $this->assertContains('View Platform', $output);
        $this->assertContains($platform['platform_name'], $output);
        #endregion

        #region Invalid Record
        $this->request('GET', 'admin/platform/view/' . 999);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/platform/browse');

        $output = $this->request('GET', 'admin/platform/browse');
        $this->assertContains('Platform not found.', $output);
        #endregion
    }

    public function test_edit()
    {
        if($this::DO_ECHO) echo "\n+++ test_edit +++\n";
        
        #region Valid Record
        $platform = $this->_insert_record();
        $edit_url = 'admin/platform/edit/' . $platform['platform_id'];
        $view_url = 'admin/platform/view/' . $platform['platform_id'];

        $output = $this->request('GET', $edit_url);
        $this->assertResponseCode(200);
        $this->assertContains('Edit Platform', $output);
        $this->assertContains($platform['platform_name'], $output);

        //successful update
        $new_platform_name = 'New Platform 1';
        $this->request('POST', $edit_url,
            array(
                'platform_name' => $new_platform_name,
                'platform_icon' => $platform['platform_icon'],
                'platform_description' => $platform['platform_description'],
                'platform_status' => $platform['platform_status']
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect($view_url);

        $output = $this->request('GET', $view_url);
        $this->assertContains($new_platform_name, $output);
        #endregion

        #region Invalid Record
        $this->request('GET', 'admin/platform/edit/' . 999);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/platform/browse');

        $output = $this->request('GET', 'admin/platform/browse');
        $this->assertContains('Platform not found.', $output);
        #endregion
    }

    public function test_edit_validation()
    {
        if($this::DO_ECHO) echo "\n+++ test_edit_validation +++\n";
        
        $platform = $this->_insert_record();
        $url = 'admin/platform/edit/' . $platform['platform_id'];

        #region Platform Name
        $output = $this->request('POST', $url,
            array(
                'platform_name' => '',
                'platform_icon' => 'fa-flag',
                'platform_description' => $this::PLATFORM_DESCRIPTION,
                'platform_status' => $this::STATUS_PUBLISH
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Platform Name field is required', $output);
        #endregion

        #region Platform Icon
        $output = $this->request('POST', $url,
            array(
                'platform_name' => 'Platform 1',
                'platform_icon' => '',
                'platform_description' => $this::PLATFORM_DESCRIPTION,
                'platform_status' => $this::STATUS_PUBLISH
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Platform Icon field is required.', $output);
        #endregion

        #region Platform Description
        $output = $this->request('POST', $url,
            array(
                'platform_name' => 'Platform 1',
                'platform_icon' => 'fa-flag',
                'platform_description' => '',
                'platform_status' => $this::STATUS_PUBLISH
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Platform Description field is required.', $output);
        #endregion

        #region Platform Status
        $output = $this->request('POST', $url,
            array(
                'platform_name' => 'Platform 1',
                'platform_icon' => 'fa-flag',
                'platform_description' => $this::PLATFORM_DESCRIPTION,
                'platform_status' => ''
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Platform Status field is required.', $output);

        $output = $this->request('POST', $url,
            array(
                'platform_name' => 'Platform 1',
                'platform_icon' => 'fa-flag',
                'platofmr_description' => $this::PLATFORM_DESCRIPTION,
                'platform_status' => 'Hello'
            )
        );
        $this->assertResponseCode(200);
        $CI =& get_instance();
        $status_str = implode(',', $CI->Platform_model->_status_array());
        $this->assertContains('The Platform Status field must be one of: ' . $status_str . '.', $output);
        #endregion
    }

    public function test_delete()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete +++\n";
        
        #region Successful Delete
        $platform = $this->_insert_record();
        $this->request('GET', 'admin/platform/delete/' . $platform['platform_id']);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/platform/browse');

        $output = $this->request('GET', 'admin/platform/browse');
        $this->assertContains('Platform deleted.', $output);
        #endregion

        #region Unsuccessful Delete
        $this->request('GET', 'admin/platform/delete/' . 999);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/platform/browse');

        $output = $this->request('GET', 'admin/platform/browse');
        $this->assertContains('Platform not found.', $output);
        #endregion
    }

    public function test_delete_with_sub_records()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete_wth_sub_records +++\n";
        
        #region Insert Records
        $CI =& get_instance();
        $platform = $this->_insert_record();

        $CI->load->model('Project_category_model');
        $project_category = array(
            'platform_id' => $platform['platform_id'],
            'pc_name' => 'Project Category 1',
            'pc_description' => $this::PLATFORM_DESCRIPTION,
            'pc_icon' => 'fa-flag'
        );
        $project_category['pc_id'] = $CI->Project_category_model->insert($project_category);
        #endregion

        #region Assert Delete
        $view_url = 'admin/platform/view/' . $platform['platform_id'];

        $this->request('GET', 'admin/platform/delete/' . $platform['platform_id']);
        $this->assertResponseCode(302);
        $this->assertRedirect($view_url);

        $output = $this->request('GET', $view_url);
        $this->assertContains('Unable to delete Platform as there are existing Project Categories associated it.', $output);
        #endregion

        #region Clean Up
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->truncate(TABLE_PROJECT_CATEGORY);
        if($this::DO_ECHO)
        {
            echo "\n--- truncated table " . TABLE_PROJECT_CATEGORY;
            echo "\n||| project category count: " . $CI->Project_category_model->count_all() . "\n";
        }
        #endregion
    }
    #endregion

} //end Platform_test class