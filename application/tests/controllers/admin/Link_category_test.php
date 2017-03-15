<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Link_category_test.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 11 Mar 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Link_category_test extends TestCase
{
    const DO_ECHO = FALSE;

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

        return array(
            'platform' => $platform,
            'project_category' => $project_category,
            'project' => $project
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

        $this->request('GET', 'admin/link_category/index');
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/link_category/browse');
    }

    public function test_browse()
    {
        if($this::DO_ECHO) echo "\n+++ test_browse +++\n";

        $output = $this->request('GET', 'admin/link_category/browse');
        $this->assertResponseCode(200);
        $this->assertContains('Link Categories', $output);
    }

    public function test_create()
    {
        if($this::DO_ECHO) echo "\n+++ test_create +++\n";

        $this->_insert_super_records();
        $output = $this->request('GET', 'admin/link_category/create');
        $this->assertResponseCode(200);
        $this->assertContains('Create Link Category', $output);

        $this->request('POST', 'admin/link_category/create',
            array(
                'project_id' => 1,
                'lc_name' => 'Link Category 1',
                'lc_description' => $this::DESCRIPTION
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/link_category/view/1');
    }

    public function test_create_validation()
    {
        if($this::DO_ECHO) echo "\n+++ test_create_validation +++\n";

        $link_category = array(
            'project_id' => 1,
            'lc_name' => 'Link Category 1',
            'lc_description' => $this::DESCRIPTION
        );
        $this->_insert_super_records();
        $url = 'admin/link_category/create';

        #region Project ID
        $output = $this->request('POST', $url,
            array(
                'project_id' => '',
                'lc_name' => $link_category['lc_name'],
                'lc_description' => $link_category['lc_description']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Project field is required.', $output);

        $output = $this->request('POST', $url,
            array(
                'project_id' => 2,
                'lc_name' => $link_category['lc_name'],
                'lc_description' => $link_category['lc_description']
            )
        );
        $this->assertResponseCode(200);
        $CI =& get_instance();
        $CI->load->model('Project_model');
        $status_str = implode(',', $CI->Project_model->get_all_ids());
        $this->assertContains('The Project field must be one of: ' . $status_str . '.', $output);
        #endregion

        #region Name
        $output = $this->request('POST', $url,
            array(
                'project_id' => $link_category['project_id'],
                'lc_name' => '',
                'lc_description' => $link_category['lc_description']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Name field is required.', $output);
        #endregion

        #region Description
        $output = $this->request('POST', $url,
            array(
                'project_id' => $link_category['project_id'],
                'lc_name' => $link_category['lc_name'],
                'lc_description' => ''
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/link_category/view/1');
        #endregion
    }

    public function test_view()
    {
        if($this::DO_ECHO) echo "\n+++ test_view +++\n";

        #region Valid Record
        $this->_insert_super_records();
        $link_category = $this->_insert_records();

        $output = $this->request('GET', 'admin/link_category/view/' . $link_category['lc_id']);
        $this->assertResponseCode(200);
        $this->assertContains('View Link Category', $output);
        $this->assertContains($link_category['lc_name'], $output);
        #endregion

        #region Invalid Records
        $this->request('GET', 'admin/link_category/view/' . 999);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/link_category/browse');

        $output = $this->request('GET', 'admin/link_category/browse');
        $this->assertContains('Link Category not found.', $output);
        #endregion
    }

    public function test_edit()
    {
        if($this::DO_ECHO) echo "\n+++ test_edit +++\n";

        #region Valid Record
        $this->_insert_super_records();
        $link_category = $this->_insert_records();

        $edit_url = 'admin/link_category/edit/' . $link_category['lc_id'];
        $view_url = 'admin/link_category/view/' . $link_category['lc_id'];

        $output = $this->request('GET', $edit_url);
        $this->assertResponseCode(200);
        $this->assertContains('Edit Link Category', $output);
        $this->assertContains($link_category['lc_name'], $output);

        $new_lc_name = 'Lorem Ipsum';
        $this->request('POST', $edit_url,
            array(
                'project_id' => 1,
                'lc_name' => $new_lc_name,
                'lc_description' => $this::DESCRIPTION
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect($view_url);

        $output = $this->request('GET', $view_url);
        $this->assertContains($new_lc_name, $output);
        #endregion

        #region Invalid Records
        $this->request('GET', 'admin/link_category/edit/' . 999);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/link_category/browse');

        $output = $this->request('GET', 'admin/link_category/browse');
        $this->assertContains('Link Category not found.', $output);
        #endregion
    }

    public function test_edit_validation()
    {
        if($this::DO_ECHO) echo "\n+++ test_edit_validation +++\n";

        $link_category = $this->_insert_records();
        $this->_insert_super_records();
        $url = 'admin/link_category/edit/' . $link_category['lc_id'];

        #region Project ID
        $output = $this->request('POST', $url,
            array(
                'project_id' => '',
                'lc_name' => $link_category['lc_name'],
                'lc_description' => $link_category['lc_description']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Project field is required.', $output);

        $output = $this->request('POST', $url,
            array(
                'project_id' => 2,
                'lc_name' => $link_category['lc_name'],
                'lc_description' => $link_category['lc_description']
            )
        );
        $this->assertResponseCode(200);
        $CI =& get_instance();
        $CI->load->model('Project_model');
        $status_str = implode(',', $CI->Project_model->get_all_ids());
        $this->assertContains('The Project field must be one of: ' . $status_str . '.', $output);
        #endregion

        #region Name
        $output = $this->request('POST', $url,
            array(
                'project_id' => $link_category['project_id'],
                'lc_name' => '',
                'lc_description' => $link_category['lc_description']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Name field is required.', $output);
        #endregion

        #region Description
        $output = $this->request('POST', $url,
            array(
                'project_id' => $link_category['project_id'],
                'lc_name' => $link_category['lc_name'],
                'lc_description' => ''
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/link_category/view/1');
        #endregion
    }

    public function test_delete()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete +++\n";

        #region Valid Record
        $link_category = $this->_insert_records();
        $this->request('GET', 'admin/link_category/delete/' . $link_category['lc_id']);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/link_category/browse');

        $output = $this->request('GET', 'admin/link_category/browse');
        $this->assertContains('Link Category deleted.', $output);
        #endregion

        #region Invalid Records
        $this->request('GET', 'admin/link_category/delete/' . 999);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/link_category/browse');

        $output = $this->request('GET', 'admin/link_category/browse');
        $this->assertContains('Link Category not found.', $output);
        #endregion
    }

    public function test_delete_with_sub_records()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete_with_sub_records +++\n";

        #region Insert Records
        $CI =& get_instance();
        $link_category = $this->_insert_records();

        $CI->load->model('Link_model');
        $link = array(
            'lc_id' => $link_category['lc_id'],
            'label' => 'Link 1',
            'url' => 'www.link-1.com',
            'use_https' => FALSE,
            'link_status' => $this::STATUS_PUBLISH
        );
        $link['link_id'] = $CI->Link_model->insert($link);
        #endregion

        #region Assert Delete
        $view_url = 'admin/link_category/view/' . $link_category['lc_id'];

        $this->request('GET', 'admin/link_category/delete/' . $link_category['lc_id']);
        $this->assertResponseCode(302);
        $this->assertRedirect($view_url);

        $output = $this->request('GET', $view_url);
        $this->assertContains('Unable to delete Link Category as there are existing Link records associated with it.', $output);
        #endregion

        #region Clean Up
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->truncate(TABLE_LINK_CATEGORY);
        if($this::DO_ECHO)
        {
            echo "\n--- truncate table " . TABLE_LINK_CATEGORY;
            echo "\n||| link category count: " . $CI->Link_category_model->count_all();
        }
        #endregion
    }
    #endregion

}//end Link_category_model class