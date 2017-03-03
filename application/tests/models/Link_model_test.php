<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Link_model_test.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 03 Mar 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Link_model_test extends TestCase
{
    const DO_ECHO = TRUE;

    const STATUS_PUBLISH = 'PUBLISH';
    const STATUS_DRAFT = 'DRAFT';

    public function setUp()
    {
        $this->resetInstance();
        $CI =& get_instance();
        $CI->load->model('Migration_model');
        $CI->Migration_model->reset();

        $CI->load->model('Link_model');
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
        $links = array(
            array(
                'lc_id' => 1,
                'label' => 'Link 1',
                'url' => 'google.com',
                'use_https' => FALSE,
                'link_status' => $this::STATUS_PUBLISH
            ),
            array(
                'lc_id' => 1,
                'label' => 'Link 2',
                'url' => 'google.com',
                'use_https' => FALSE,
                'link_status' => $this::STATUS_PUBLISH
            ),
            array(
                'lc_id' => 1,
                'label' => 'Link 3',
                'url' => 'google.com',
                'use_https' => FALSE,
                'link_status' => $this::STATUS_DRAFT
            ),
            array(
                'lc_id' => 2,
                'label' => 'Link 4',
                'url' => 'google.com',
                'use_https' => TRUE,
                'link_status' => $this::STATUS_PUBLISH
            ),
            array(
                'lc_id' => 2,
                'label' => 'Link 5',
                'url' => 'google.com',
                'use_https' => FALSE,
                'link_status' => $this::STATUS_PUBLISH
            )
        );

        foreach($links as $link)
        {
            $CI->Link_model->insert($link);
        }

        if($do_echo) echo "\n--- inserted records: " . $CI->Link_model->count_all();
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

        $CI->load->model('Project_category_model');
        $project_category = array(
            'platform_id' => 1,
            'pc_name' => 'Project Category 1',
            'pc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'pc_icon' => 'fa-flag'
        );
        $CI->Project_category_model->insert($project_category);

        $CI->load->model('Project_model');
        $projects = array(
            'pc_id' => 1,
            'project_name' => 'Project 1',
            'project_icon' => 'fa-flag',
            'project_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'selected_project' => 1,
            'project_status' => $this::STATUS_PUBLISH
        );
        $CI->Project_model->insert($project);

        $CI->load->model('Link_category_model');
        $link_categories = array(
            array(
                'project_id' => 1,
                'lc_name' => 'Link Category 1',
                'lc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
            ),
            array(
                'project_id' => 1,
                'lc_name' => 'Link Category 2',
                'lc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
            ),
        );
    }

    private function _truncate_table($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();

        $CI->db->truncate(TABLE_LINK);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_LINK . " ---";
            echo "\n||| count_all: " . $CI->Link_model->count_all() . "\n";
        }
    }

    private function _truncate_super_tables($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();

        $CI->db->truncate(TABLE_PROJECT);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PROJECT . " ---";
            echo "\n||| count_all: " . $CI->Project_model->count_all() . "\n";
        }

        $CI->db->truncate(TABLE_PROJECT_CATEGORY);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PROJECT_CATEGORY . " ---";
            echo "\n||| count_all: " . $CI->Project_category_model->count_all() . "\n";
        }

        $CI->db->truncate(TABLE_PROJECT);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PROJECT . " ---";
            echo "\n||| count_all: " . $CI->Project_model->count_all() . "\n";
        }

        $CI->db->truncate(TABLE_LINK_CATEGORY);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_LINK_CATEGORY . " ---";
            echo "\n||| count_all: " . $CI->Link_category_model->count_all() . "\n";
        }
    }
    #endregion

    #region Test Functions
    public function test_count_all()
    {
        if($this::DO_ECHO) echo "\n++++ test_count_all +++\n";
        $CI =& get_instance();
        $this->_insert_records();
        $this->assertEquals(5, $CI->Link_model->count_all());
    }

    public function test_count_by_status()
    {
        if($this::DO_ECHO) echo "\n+++ test_count_by_status +++\n";
        $CI =& get_instance();
        $this->_insert_records();
        $this->assertEquals(4, $CI->Link_model->count_by_status($this::STATUS_PUBLISH));
    }

    public function test_get_all()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_all +++\n";
        $CI =& get_instance();
        $this->_insert_records();
        $this->assertCount(5, $CI->Link_model->get_all());
    }

    public function test_get_all_link_category()
    {
        $this->markTestIncomplete();
    }

    public function test_get_by_id()
    {
        $this->markTestIncomplete();
    }

    public function test_get_by_id_link_category_project()
    {
        $this->markTestIncomplete();
    }

    public function test_get_by_status()
    {
        $this->markTestIncomplete();
    }

    public function test_get_by_status_ids()
    {
        $this->markTestIncomplete();
    }

    public function test_get_by_lc_id()
    {
        $this->markTestIncomplete();
    }

    public function test_get_lc_id_status()
    {
        $this->markTestIncomplete();
    }

    public function test_get_links_by_project_id()
    {
        $this->markTestIncomplete();
    }

    public function test_get_links_by_project_id_status()
    {
        $this->markTestIncomplete();
    }

    public function test_insert()
    {
        $this->markTestIncomplete();
    }

    public function test_update()
    {
        $this->markTestIncomplete();
    }

    public function test_delete_by_id()
    {
        $this->markTestIncomplete();
    }

    public function test_delete_by_lc_id()
    {
        $this->markTestIncomplete();
    }

    public function test_status_array()
    {
        if($this::DO_ECHO) echo "\n+++ test_status_array +++\n";
        $CI =& get_instance();
        $this->assertCount(2, $CI->Link_model->_status_array());
    }
    #endregion

}// end Link_model_test class