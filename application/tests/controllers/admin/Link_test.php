<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Link_test.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 11 Mar 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Link_test extends TestCase
{
    const DO_ECHO = TRUE;

    const DESCRIPTION = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

    const STATUS_PUBLISH = 'Publish';
    const STATUS_DRAFT = 'Draft';

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
    private function _login()
    {
        $this->request('POST', 'admin/authenticate/login',
            array(
                'username' => 'admin',
                'password' => 'password'
            )
        );
        $this->request('GET', 'admin/authenticate/start');
    }

    private function _logout()
    {
        $this->request('GET', 'admin/authenticate/logout');
        $this->request('GET', 'admin/authenticate/login');
    }

    private function _insert_super_records($do_echo=FALSE)
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
        if($do_echo)
        {
            echo "\n--- inserted platform records ---";
            echo "\n||| platform count: " . $CI->Platform_model->count_all() . "\n";
        }
        #endregion

        #region Project Category
        $CI->load->model('Project_category_model');
        $project_category = array(
            'platform_id' => $platform['platform_id'],
            'pc_name' => 'Project Category 1',
            'pc_icon' => 'fa-flag',
            'pc_description' => $this::DESCRIPTION
        );
        $project_category['pc_id'] = $CI->Project_category_model->insert($project_category);
        if($do_echo)
        {
            echo "\n--- inserted project category records ---";
            echo "\n||| project category count: " . $CI->Project_category_model->count_all() . "\n";
        }
        #endregion

        #region Project
        $CI->load->model('Project_model');
        $project = array(
            'pc_id' => $project_category['pc_id'],
            'project_name' => 'Project 1',
            'project_icon' => 'fa-flag',
            'project_description' => $this::DESCRIPTION,
            'selected_project' => 0,
            'project_status' => $this::STATUS_PUBLISH
        );
        $project['project_id'] = $CI->Project_model->insert($project);
        if($do_echo)
        {
            echo "\n--- inserted project records ---";
            echo "\n||| project count: " . $CI->Project_model->count_all() . "\n";
        }
        #endregion

        #region Link Category
        $CI->load->model('Link_category_model');
        $link_category = array(
            'project_id' => $project['project_id'],
            'lc_name' => 'Link Category 1',
            'lc_description' => $this::DESCRIPTION
        );
        #endregion

        return array(
            'platform' => $platform,
            'project_category' => $project_category,
            'project' => $project,
            'link_category' => $link_category
        );
    }

    private function _insert_records($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->model('Link_category_model');
        $link_category = array(
            'project_id' => 1,
            'lc_name' => 'Link Category 1',
            'lc_description' => $this::DESCRIPTION
        );
        $link_category['lc_id'] = $CI->Link_category_model->insert($link_category);
        if($do_echo)
        {
            echo "\n--- inserted link category records ---";
            echo "\n||| link category count: " . $CI->Link_category_model->count_all() . "\n";
        }
        return $link_category;
    }

    private function _truncate_super_tables($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();

        $CI->db->truncate(TABLE_LINK_CATEGORY);
        if($do_echo)
        {
            echo "\n--- truncated " . TABLE_LINK_CATEGORY;
            $CI->load->model('Link_category_model');
            echo "\n||| link category count: " . $CI->Link_category_model->count_all() . "\n";
        }

        $CI->db->truncate(TABLE_PROJECT);
        if($do_echo)
        {
            echo "\n--- truncated " . TABLE_PROJECT;
            $CI->load->model('Project_model');
            echo "\n||| project count: " . $CI->Project_model->count_all() . "\n";
        }

        $CI->db->truncate(TABLE_PROJECT_CATEGORY);
        if($do_echo)
        {
            echo "\n--- truncated " . TABLE_PROJECT_CATEGORY;
            $CI->load->model('Project_category_model');
            echo "\n||| project category count: " . $CI->Project_category_model->count_all() . "\n";
        }

        $CI->db->truncate(TABLE_PLATFORM);
        if($do_echo)
        {
            echo "\n--- truncated " . TABLE_PLATFORM;
            $CI->load->model('Platform_model');
            echo "\n||| platform count: " . $CI->Platform_model->count_all() . "\n";
        }
    }

    private function _truncate_table($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->model('Link_category_model');

        $CI->db->truncate(TABLE_LINK_CATEGORY);
        if($do_echo)
        {
            echo "\n--- truncated " . TABLE_LINK_CATEGORY;
            $CI->load->model('Link_category_model');
            echo "\n||| link category mode: " . $CI->Link_category_model->count_all() . "\n";
        }
    }
    #endregion

    #region Test Functions
    public function test_index()
    {
        if($this::DO_ECHO) echo "\n+++ test_index +++\n";

        $this->markTestIncomplete();
    }

    public function test_browse()
    {
        if($this::DO_ECHO) echo "\n+++ test_browse +++\n";

        $this->markTestIncomplete();
    }

    public function test_create()
    {
        if($this::DO_ECHO) echo "\n+++ test_create +++\n";

        $this->markTestIncomplete();
    }

    public function test_create_validation()
    {
        if($this::DO_ECHO) echo "\n+++ test_create_validation +++\n";

        $this->markTestIncomplete();

        #region Project ID

        #endregion

        #region Name

        #endregion

        #region Description

        #endregion
    }

    public function test_view()
    {
        if($this::DO_ECHO) echo "\n+++ test_view +++\n";

        $this->markTestIncomplete();
        #region Valid Record

        #endregion

        #region Invalid Records

        #endregion
    }

    public function test_edit()
    {
        if($this::DO_ECHO) echo "\n+++ test_edit +++\n";

        $this->markTestIncomplete();
        #region Valid Record

        #endregion

        #region Invalid Records

        #endregion
    }

    public function test_edit_validation()
    {
        if($this::DO_ECHO) echo "\n+++ test_edit_validation +++\n";

        $this->markTestIncomplete();
        #region Project ID

        #endregion

        #region Name

        #endregion

        #region Description

        #endregion
    }

    public function test_delete()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete +++\n";

        $this->markTestIncomplete();
        #region Valid Record

        #endregion

        #region Invalid Records

        #endregion
    }

    public function test_delete_with_sub_records()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete_with_sub_records +++\n";

        $this->markTestIncomplete();
    }
    #endregion

}//end Link_category_model class