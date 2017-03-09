<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Link_category_test_model.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 02 Mar 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Link_category_test_model extends TestCase
{
    const DO_ECHO = FALSE;

    const STATUS_PUBLISH = 'PUBLISH';
    const STATUS_DRAFT = 'DRAFT';
    
    public function setUp()
    {
        $this->resetInstance();
        $CI =& get_instance();
        $CI->load->model('Migration_model');
        $CI->Migration_model->reset();

        $CI->load->model('Link_category_model');
        $CI->load->helper('datetime_format');
        $this->_truncate_table();
    }

    public function tearDown()
    {
        $this->_truncate_table();
        $this->_truncate_super_tables();
    }

    #region Helper Functions
    private function _insert_records($do_echo=FALSE)
    {
        $CI =& get_instance();
        $link_categories = array(
            array(
                'project_id' => 1,
                'lc_name' => 'Link Category 1',
                'lc_description' => 'Lorem ipsum',
            ),
            array(
                'project_id' => 1,
                'lc_name' => 'Link Category 2',
                'lc_description' => 'Hello World',
            ),
            array(
                'project_id' => 2,
                'lc_name' => 'Link Category 3',
                'lc_description' => 'Hello Earth',
            )
        );

        foreach($link_categories as $link_category)
        {
            $CI->Link_category_model->insert($link_category);
        }

        if($do_echo) echo "\n||| inserted link categories: " . $CI->Link_category_model->count_all() . "\n";
    }

    private function _insert_super_records($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->model('Platform_model');
        $platform = array(
            'platform_name' => 'Project 1',
            'platform_icon' => 'fa-flag',
            'platform_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'platform_status' => $this::STATUS_PUBLISH
        );
        $CI->Platform_model->insert($platform);
        if($do_echo) echo "\n||| inserted platforms: " . $CI->Platform_model->count_all();

        $CI->load->model('Project_category_model');
        $project_category = array(
            'platform_id' => 1,
            'pc_name' => 'Project Category 1',
            'pc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'pc_icon' => 'fa-flag'
        );
        $CI->Project_category_model->insert($project_category);
        if($do_echo) echo "\n||| inserted project categories: " . $CI->Project_category_model->count_all();

        $CI->load->model('Project_model');
        $projects = array(
            array(
                'pc_id' => 1,
                'project_name' => 'Project 1',
                'project_icon' => 'fa-flag',
                'project_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'selected_project' => 1,
                'project_status' => $this::STATUS_PUBLISH
            ),
            array(
                'pc_id' => 1,
                'project_name' => 'Project 2',
                'project_icon' => 'fa-flag',
                'project_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'selected_project' => 0,
                'project_status' => $this::STATUS_PUBLISH
            )
        );
        foreach($projects as $project)
        {
            $CI->Project_model->insert($project);
        }
        if($do_echo) echo "\n||| inserted projects: " . $CI->Project_model->count_all() . "\n";
    }

    private function _truncate_table($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();

        $CI->db->truncate(TABLE_LINK_CATEGORY);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_LINK_CATEGORY . " ---";
            echo "\n||| count_all: " . $CI->Link_category_model->count_all() . "\n";
        }

        $CI->db->truncate(TABLE_USER_LOG);
        if($do_echo)
        {
            echo "\n--- truncated user log table ---\n";
        }
    }

    private function _truncate_super_tables($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();

        $CI->db->truncate(TABLE_PROJECT);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PLATFORM . " ---";
            echo "\n||| count all: " . $CI->Platform_model->count_all() . "\n";
        }

        $CI->db->truncate(TABLE_PROJECT_CATEGORY);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PROJECT_CATEGORY . " ---";
            echo "\n||| count all: " . $CI->Project_category_model->count_all() . "\n";
        }

        $CI->db->truncate(TABLE_PROJECT);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PROJECT . " ---";
            echo "\n||| count all: " . $CI->Project_model->count_all() . "\n";
        }
    }
    #endregion

    #region Test Functions
    public function test_count_all()
    {
        if($this::DO_ECHO) echo "\n+++ test_count_all +++\n";
        $CI =& get_instance();
        $this->_insert_records();
        $this->assertEquals(3, $CI->Link_category_model->count_all());
    }

    public function test_get_all()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_all +++\n";
        $CI =& get_instance();
        $this->_insert_records();
        $this->assertCount(3, $CI->Link_category_model->get_all());
    }

    public function test_get_all_project()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_all_project +++\n";
        $CI =& get_instance();

        $this->_insert_super_records();
        $this->_insert_records();

        $this->assertCount(3, $CI->Link_category_model->get_all_project());
    }

    public function test_get_all_project_platform()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_all_project_platform +++\n";
        $CI =& get_instance();

        $this->_insert_super_records();
        $this->_insert_records();

        $this->assertCount(3, $CI->Link_category_model->get_all_project_platform());
    }

    public function test_get_all_ids()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_all_ids +++\n";
        $CI =& get_instance();

        $this->_insert_super_records();
        $this->_insert_records();

        $this->assertCount(3, $CI->Link_category_model->get_all_ids());
    }

    public function test_get_by_id()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_by_id +++\n";
        $CI =& get_instance();
        $this->_insert_records();

        $this->assertEquals('Link Category 1', $CI->Link_category_model->get_by_id(1)['lc_name']);
        $this->assertFalse($CI->Link_category_model->get_by_id(FALSE));
    }

    public function test_get_by_id_project()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_by_id_project +++\n";
        $CI =& get_instance();

        $this->_insert_super_records();
        $this->_insert_records();

        $this->assertEquals('Link Category 1', $CI->Link_category_model->get_by_id_project(1)['lc_name']);
        $this->assertFalse($CI->Link_category_model->get_by_id_project(FALSE));
    }

    public function test_get_by_id_project_platform()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_by_id_project_platform +++\n";
        $CI =& get_instance();

        $this->_insert_super_records();
        $this->_insert_records();

        $this->assertEquals('Link Category 1', $CI->Link_category_model->get_by_id_project_platform(1)['lc_name']);
        $this->assertFalse($CI->Link_category_model->get_by_id_project_platform(FALSE));
    }

    public function test_get_by_project_id()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_by_project_id +++\n";
        $CI =& get_instance();

        $this->_insert_super_records();
        $this->_insert_records();

        $this->assertCount(2, $CI->Link_category_model->get_by_project_id(1));
        $this->assertFalse($CI->Link_category_model->get_by_project_id(FALSE));
    }

    public function test_get_by_project_id_lc_name()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_by_project_id_lc_name +++\n";
        $CI =& get_instance();

        $this->_insert_super_records();
        $this->_insert_records();

        $this->assertEquals('Lorem ipsum', $CI->Link_category_model->get_by_project_id_lc_name(1, 'Link Category 1')['lc_description']);
        $this->assertFalse($CI->Link_category_model->get_by_project_id_lc_name(FALSE));
    }

    public function test_insert()
    {
        if($this::DO_ECHO) echo "\n+++ test_insert +++\n";
        $CI =& get_instance();

        $link_category = array(
            'project_id' => 1,
            'lc_name' => 'Lorem Ipsum',
            'lc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
        );
        $link_category['lc_id'] = $CI->Link_category_model->insert($link_category);
        $this->assertEquals(1, $link_category['lc_id']);
        $this->assertFalse($CI->Link_category_model->insert(FALSE));
    }

    public function test_update()
    {
        if($this::DO_ECHO) echo "\n+++ test_update +++\n";
        $CI =& get_instance();

        $link_category = array(
            'project_id' => 1,
            'lc_name' => 'Lorem Ipsum',
            'lc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
        );
        $link_category['lc_id'] = $CI->Link_category_model->insert($link_category);
        $link_category['lc_name'] = 'Hello World';

        $this->assertEquals(1, $CI->Link_category_model->update($link_category));
        $this->assertFalse($CI->Link_category_model->update(FALSE));
    }

    public function test_delete_by_id()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete_by_id +++\n";
        $CI =& get_instance();

        $link_category = array(
            'project_id' => 1,
            'lc_name' => 'Lorem Ipsum',
            'lc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
        );
        $link_category['lc_id'] = $CI->Link_category_model->insert($link_category);

        $this->assertEquals(1, $CI->Link_category_model->delete_by_id($link_category['lc_id']));
        $this->assertFalse($CI->Link_category_model->delete_by_id(FALSE));
    }

    public function test_delete_by_project_id()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete_by_project_id +++\n";
        $CI =& get_instance();
        $this->_insert_records();

        $this->assertEquals(2, $CI->Link_category_model->delete_by_project_id(1));
        $this->assertFalse($CI->Link_category_model->delete_by_project_id(FALSE));
    }
    #endregion

} //end Link_category_test_model class