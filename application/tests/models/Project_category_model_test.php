<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Project_category_model_test.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 18 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Project_category_model_test extends TestCase
{
	const DO_ECHO = FALSE;

	public function setUp()
	{
		$this->resetInstance();
		$CI =& get_instance();
		$CI->load->model('Migration_model');
		$CI->Migration_model->reset();

		$CI->load->model('Project_category_model');
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
		$CI->load->model('Platform_model');

		$platforms = array(
			array(
				'platform_name' => 'Platform 1',
				'platform_icon' => 'fa-flag',
				'platform_description' => 'Test Platform 1',
				'platform_status' => 'Published'
			),
			array(
				'platform_name' => 'Platform 2',
				'platform_icon' => 'fa-flag',
				'platform_description' => 'Test Platform 2',
				'platform_status' => 'Published'
			)
		);
		foreach($platforms as $platform)
		{
			$CI->Platform_model->insert($platform);
		}
		if($do_echo) echo "\n||| inserted platforms: " . $CI->Platform_model->count_all();

		$project_categories = array(
			array(
				'pc_name' => 'Project Category 1',
				'platform_id' => 1,
				'pc_icon' => 'fa-flag',
				'pc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'pc_status' => 'Published'
			),
			array(
				'pc_name' => 'Project Category 2',
				'platform_id' => 1,
				'pc_icon' => 'fa-flag',
				'pc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'pc_status' => 'Draft'
			),
			array(
				'pc_name' => 'Project Category 3',
				'platform_id' => 2,
				'pc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'pc_icon' => 'fa-flag',
				'pc_status' => 'Published'
			)
		);

		foreach($project_categories as $project_category)
		{
			$CI->Project_category_model->insert($project_category);
		}
		if($do_echo) echo "\n||| inserted project categories: " . $CI->Project_category_model->count_all() . "\n";
	}

	private function _truncate_table($do_echo=FALSE)
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->db->truncate(TABLE_PLATFORM);
		$CI->db->truncate(TABLE_PROJECT_CATEGORY);

		if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PROJECT_CATEGORY . " ---";
            echo "\n||| count_all: " . $CI->Project_category_model->count_all() . "\n";
        }

		$CI->db->truncate(TABLE_USER_LOG);
        if($do_echo)
        {
            echo "\n--- truncated user log table ---\n";
        }
	}
	#endregion
	
	#region Test Functions
	public function test_count_all()
	{
		if($this::DO_ECHO) echo "\n+++ test_count_all +++\n";
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertEquals(3, $CI->Project_category_model->count_all());
	}

	public function test_get_all()
	{
		if($this::DO_ECHO) echo "\n+++ test_get_all +++\n";
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertCount(3, $CI->Project_category_model->get_all());
	}

	public function test_get_all_platform()
	{
		if($this::DO_ECHO) echo "\n+++ test_get_all_platform +++\n";
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertCount(3, $CI->Project_category_model->get_all_platform());
	}

	public function test_get_all_ids()
	{
		if($this::DO_ECHO) echo "\n+++ test_get_all_ids +++\n";
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertCount(3, $CI->Project_category_model->get_all_ids());
	}

	public function test_get_by_id()
	{
		if($this::DO_ECHO) echo "\n+++ test_get_by_id +++\n";
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertEquals('Project Category 1', $CI->Project_category_model->get_by_id(1)['pc_name']);
		$this->assertFalse($CI->Project_category_model->get_by_id(FALSE));
	}

	public function test_get_by_id_platform()
	{
		if($this::DO_ECHO) echo "\n+++ test_get_by_id_platform +++\n";
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertEquals('Platform 1', $CI->Project_category_model->get_by_id_platform(1)['platform_name']);
		$this->assertFalse($CI->Project_category_model->get_by_id_platform(FALSE));
	}
	
	public function test_get_by_platform_id()
	{
		if($this::DO_ECHO) echo "\n+++ test_get_by_platform_id +++\n";
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertCount(2, $CI->Project_category_model->get_by_platform_id(1));
		$this->assertFalse($CI->Project_category_model->get_by_platform_id(FALSE));
	}
	
	public function test_insert()
	{
		if($this::DO_ECHO) echo "\n+++ test_insert +++\n";
		$CI =& get_instance();
		$project_category = array(
			'pc_name' => 'Project Category 1',
			'platform_id' => 1,
			'pc_icon' => 'fa-flag',
			'pc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'pc_status' => 'Published'
		);
		$this->assertEquals(1, $CI->Project_category_model->insert($project_category));

		$this->assertFalse($CI->Project_category_model->insert(FALSE));
	}
	
	public function test_update()
	{
		if($this::DO_ECHO) echo "\n+++ test_update +++\n";
		$CI =& get_instance();
		$insert = array(
			'pc_name' => 'Project Category 1',
			'platform_id' => 1,
			'pc_icon' => 'fa-flag',
			'pc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'pc_status' => 'Published'
		);
		$insert['pc_id'] = $CI->Project_category_model->insert($insert);

		$update = $insert;
		$update['pc_name'] = 'Project Category 999';
		$this->assertEquals(1, $CI->Project_category_model->update($update));

		$this->assertFalse($CI->Project_category_model->update(FALSE));
	}

	public function test_delete_by_id()
	{
		if($this::DO_ECHO) echo "\n+++ test_delete_by_id +++\n";
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertEquals(1, $CI->Project_category_model->delete_by_id(1));

		$this->assertFalse($CI->Project_category_model->delete_by_id(FALSE));
	}

	public function test_delete_by_platform_id()
	{
		if($this::DO_ECHO) echo "\n+++ test_delete_by_platform_id +++\n";
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertEquals(2, $CI->Project_category_model->delete_by_platform_id(1));

		$this->assertFalse($CI->Project_category_model->delete_by_platform_id(FALSE));
	}
	#endregion
	
} // end Project_category_model_test controller class