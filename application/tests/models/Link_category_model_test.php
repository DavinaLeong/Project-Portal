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
    const DO_ECHO = TRUE;

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
                'lc_description' => 'Lorem ipsum',
            ),
            array(
                'project_id' => 2,
                'lc_name' => 'Link Category 3',
                'lc_description' => 'Lorem ipsum',
            )
        );

        foreach($link_categories as $link_category)
        {
            $CI->Link_category_model->insert($link_category);
        }

        if($do_echo) echo "\n--- inserted records: " . $CI->Link_category_model->count_all();
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
        $this->_insert_records();

        $CI->load->model('Project_model');
        $CI->Project_model->insert(
            array(
                'pc_id' => 1,
                'project_name' => 'Project 1',
                'project_description' => 'Lorem Ipsum',
                'project_icon' => 'fa-flag',
                'selected_project' => 0,
                'project_status' => $this::STATUS_PUBLISH
            )
        );

        $this->assertCount(3, $CI->Link_category_model->get_all_project());
    }
    #endregion

} //end Link_category_test_model class