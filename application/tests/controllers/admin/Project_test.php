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
    const DO_ECHO = FALSE;

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
        if($do_echo)  echo "\n--- inserted platform ---\n";
        #endregion

        #region Project Category
        $CI->load->model('Project_category_model');
        $project_category = array(
            'platform_id' => 1,
            'pc_name' => 'Project Category 1',
            'pc_description' => $this::DESCRIPTION,
            'pc_icon' => 'fa-flag'
        );
        $project_category['pc_id'] = $CI->Project_category_model->insert($project_category);
        if($do_echo) echo "\n--- inserted project category ---\n";
        #endregion

        return array(
            'platform' => $platform,
            'project_category' => $project_category
        );
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

        $CI->db->truncate(TABLE_PROJECT_CATEGORY);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PROJECT_CATEGORY;
            $CI->load->model('Project_category_model');
            echo "\n||| project category count: " . $CI->Project_category_model->count_all() . "\n";
        }
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

        $records = $this->_insert_super_records();
        $this->request('POST', 'admin/project/create',
            array(
                'pc_id' => $records['project_category']['pc_id'],
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

        $records = $this->_insert_super_records();
        $url = 'admin/project/create';
        $project = array(
            'pc_id' => $records['project_category']['pc_id'],
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

        $output = $this->request('POST', $url,
            array(
                'pc_id' => 2,
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(200);
        $CI =& get_instance();
        $CI->load->model('Project_category_model');
        $pcid_str = implode(',', $CI->Project_category_model->get_all_ids());
        $this->assertContains('The Category field must be one of: ' . $pcid_str . '.', $output);
        #endregion

        #region Project Name
        $output = $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => '',
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Name field is required.', $output);
        #endregion

        #region Project Icon
        $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => '',
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/view/1');
        #endregion

        #region Project Description
        $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => '',
                'selected_project' => $project['selected_project'],
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/view/2');
        #endregion

        #region Selected Project
        $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => '',
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/view/3');

        $output = $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => 2,
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Selected Project field must be one of: 0,1.', $output);
        #endregion

        #region Project Status
        $output = $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => ''
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Status field is required.', $output);

        $output = $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => 'Hello'
            )
        );
        $this->assertResponseCode(200);
        $CI =& get_instance();
        $CI->load->model('Project_model');
        $status_str = implode(',', $CI->Project_model->_status_array());
        $this->assertContains('The Status field must be one of: ' . $status_str . '.', $output);
        #endregion
    }

    public function test_view()
    {
        if($this::DO_ECHO) echo "\n+++ test_view +++\n";

        #region Valid Record
        $this->_insert_super_records();
        $project = $this->_insert_records();

        $output = $this->request('GET', 'admin/project/view/' . $project['project_id']);
        $this->assertResponseCode(200);
        $this->assertContains('View Project', $output);
        $this->assertContains($project['project_name'], $output);
        #endregion

        #region Invalid Record
        $this->request('GET', 'admin/project/view/' . 999);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/browse');

        $output = $this->request('GET', 'admin/project/browse');
        $this->assertContains('Project not found.', $output);
        #endregion
    }

    public function test_edit()
    {
        if($this::DO_ECHO) echo "\n+++ test_edit +++\n";

        #region Valid Record
        $this->_insert_super_records();
        $project = $this->_insert_records();

        $edit_url = 'admin/project/edit/' . $project['project_id'];
        $view_url = 'admin/project/view/' . $project['project_id'];

        $output = $this->request('GET', $edit_url);
        $this->assertResponseCode(200);
        $this->assertContains('Edit Project', $output);
        $this->assertContains($project['project_name'], $output);

        $new_project_name = 'Lorem Ipsum';
        $this->request('POST', $edit_url,
        array(
            'pc_id' => $project['pc_id'],
            'project_name' => $new_project_name,
            'project_icon' => $project['project_icon'],
            'project_description' => $project['project_description'],
            'selected_project' => $project['selected_project'],
            'project_status' => $project['project_status']
        ));
        $this->assertResponseCode(302);
        $this->assertRedirect($view_url);

        $output = $this->request('GET', $view_url);
        $this->assertContains($new_project_name, $output);
        #endregion

        #region Invalid Record
        $this->request('GET', 'admin/project/edit/' . 999);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/browse');

        $output = $this->request('GET', 'admin/project/browse');
        $this->assertContains('Project not found.', $output);
        #endregion
    }

    public function test_edit_validation()
    {
        if($this::DO_ECHO) echo "\n+++ test_edit_validation +++\n";

        $records = $this->_insert_super_records();
        $project = array(
            'pc_id' => $records['project_category']['pc_id'],
            'project_name' => 'Project 1',
            'project_icon' => 'fa-flag',
            'project_description' => $this::DESCRIPTION,
            'selected_project' => 0,
            'project_status' => $this::STATUS_PUBLISH
        );
        $CI =& get_instance();
        $CI->load->model('Project_model');
        $project['project_id'] = $CI->Project_model->insert($project);
        $url = 'admin/project/edit/' . $project['project_id'];

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

        $output = $this->request('POST', $url,
            array(
                'pc_id' => 2,
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(200);
        $CI =& get_instance();
        $CI->load->model('Project_category_model');
        $pcid_str = implode(',', $CI->Project_category_model->get_all_ids());
        $this->assertContains('The Category field must be one of: ' . $pcid_str . '.', $output);
        #endregion

        #region Project Name
        $output = $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => '',
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Name field is required.', $output);
        #endregion
        
        #region Project Icon
        $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => '',
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/view/1');
        #endregion

        #region Project Description
        $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => '',
                'selected_project' => $project['selected_project'],
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/view/1');
        #endregion

        #region Selected Project
        $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => '',
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/view/1');

        $output = $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => 2,
                'project_status' => $project['project_status']
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Selected Project field must be one of: 0,1.', $output);
        #endregion

        #region Project Status
        $output = $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => ''
            )
        );
        $this->assertResponseCode(200);
        $this->assertContains('The Status field is required.', $output);

        $output = $this->request('POST', $url,
            array(
                'pc_id' => $project['pc_id'],
                'project_name' => $project['project_name'],
                'project_icon' => $project['project_icon'],
                'project_description' => $project['project_description'],
                'selected_project' => $project['selected_project'],
                'project_status' => 'Hello'
            )
        );
        $this->assertResponseCode(200);
        $CI =& get_instance();
        $CI->load->model('Project_model');
        $status_str = implode(',', $CI->Project_model->_status_array());
        $this->assertContains('The Status field must be one of: ' . $status_str . '.', $output);
        #endregion
    }

    public function test_delete()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete +++\n";

        #region Valid Record
        $project = $this->_insert_records();
        $this->request('GET', 'admin/project/delete/' . $project['project_id']);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/browse');

        $output = $this->request('GET', 'admin/project/browse');
        $this->assertContains('Project deleted.', $output);
        #endregion

        #region Invalid Record
        $this->request('GET', 'admin/project/delete/' . 999);
        $this->assertResponseCode(302);
        $this->assertRedirect('admin/project/browse');

        $output = $this->request('GET', 'admin/project/browse');
        $this->assertContains('Project not found.', $output);
        #endregion
    }

    public function test_delete_with_sub_records()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete_with_sub_records +++\n";

        #region Insert Records
        $CI =& get_instance();
        $project = $this->_insert_records();

        $CI->load->model('Link_category_model');
        $link_category = array(
            'project_id' => $project['project_id'],
            'lc_name' => 'Link Category 1',
            'lc_description' => $this::DESCRIPTION
        );
        $link_category['lc_id'] = $CI->Link_category_model->insert($link_category);
        #endregion

        #region Assert Delete
        $view_url = 'admin/project/view/' . $project['project_id'];

        $this->request('GET', 'admin/project/delete/' . $project['project_id']);
        $this->assertResponseCode(302);
        $this->assertRedirect($view_url);

        $output = $this->request('GET', $view_url);
        $this->assertContains('Unable to delete Project as there are existing Link Categories associated with it.', $output);
        #endregion

        #region Clean Up
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->truncate(TABLE_LINK_CATEGORY);

        if($this::DO_ECHO)
        {
            echo "\n--- truncated table " . TABLE_LINK_CATEGORY;
            $CI->load->model('Link_category_model');
            echo "\n||| link category count: " . $CI->Link_category_model->count_all();
        }
        #endregion
    }
    #endregion

}// end Project_test class