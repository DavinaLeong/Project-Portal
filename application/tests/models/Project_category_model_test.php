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
	public function setUp()
	{
		$this->resetInstance();
		$CI = $this->_load_ci();
		$CI->load->model('Migration_model');
		$CI->Migration_model->reset();

		$CI->load->model('Project_category_model');
		$CI->load->helper('datetime_format');
	}

	public function tearDown()
	{
		$this->_truncate_table($this->_load_ci());
	}

	#region Helper Functions
	private function _load_ci()
	{
		$CI =& get_instance();
		return $CI;
	}

	private function _insert_records($CI)
	{
		$CI->load->model('Platform_model');
		$desktop_id = $CI->Platform_model->insert(
			array(
				'platform_name' => 'Desktop',
				'platform_description' => 'Acer Predator',
				'platform_icon' => 'fa fa-desktop',
				'platform_status' => 'Active'
			)
		);
		$laptop_id = $CI->Platform_model->insert(
			array(
				'platform_name' => 'Laptop',
				'platform_description' => 'Lenovo',
				'platform_icon' => 'fa fa-laptop',
				'platform_status' => 'Active'
			)
		);

		$project_categories = array(
			array(
				'pc_name' => 'Resources',
				'pc_description' => 'Links to commonly used resources.',
				'pc_icon' => 'fa-book',
				'platform_id' => $desktop_id
			),
			array(
				'pc_name' => 'Personal Projects',
				'pc_description' => 'Links to self-made locally hosted projects.',
				'pc_icon' => 'fa-user',
				'platform_id' => $desktop_id
			),
			array(
				'pc_name' => 'Work Projects',
				'pc_description' => 'Links to Work projects on localhost.',
				'pc_icon' => 'fa-building',
				'platform_id' => $desktop_id
			),
			array(
				'pc_name' => 'Resources',
				'pc_description' => 'Links to commonly used resources.',
				'pc_icon' => 'fa-book',
				'platform_id' => $laptop_id
			),
		);

		return array(
			$desktop_id, $laptop_id
		);
	}

	private function _truncate_table($CI, $do_echo=TRUE)
	{
		$CI->load->database();
		$CI->db->truncate(TABLE_PROJECT_CATEGORY);
		if($do_echo)
		{
			echo "\n--- truncated table " . TABLE_PROJECT_CATEGORY . " ---\n";
			echo "\n||| count_all: " . $CI->Project_category_model->count_all();
		}
	}
	#endregion

	#region Test Functions
	public function test_count_all()
	{
		$CI = $this->_load_ci();
		$this->_insert_records($CI);
		$this->assertEqual(4, $CI->Project_category_model->count_all());
		$this->_truncate_table($CI);
	}

	public function test_get_all()
	{
		$CI = $this->_load_ci();
		$this->_insert_records($CI);
		$this->assertCount(4, $CI->Project_category_model->get_all());
	}

	public function test_get_all_platform()
	{
		$CI = $this->_load_ci();
		$this->_insert_records($CI);
		$this->assertEqual(1, $CI->Project_category_model->get_all_platform(2));
	}

	public function test_get_all_ids()
	{
		$CI = $this->_load_ci();
		$this->_insert_records($CI);
		$this->assertCount(4, $CI->Project_category_model->get_all_ids());
	}

	public function test_get_by_id()
	{
		$CI = $this->_load_ci();
		$this->_insert_records($CI);

		$project_category = $CI->Project_category_model->get_by_id(2);
		$this->assertEqual('Resources', $project_category['pc_name']);
		$this->assertEqual(2, $project_category['platform_id']);
		$this->assertFalse($CI->Project_category_model->get_by_id(FALSE));
	}

	public function test_get_by_id_platform()
	{
		$CI = $this->_load_ci();
		$this->_insert_records($CI);

		$project_category = $CI->Project_category_model->get_by_id_platform(2);
		$this->assertEqual('Resources', $project_category['pc_name']);
		$this->assertEqual('Laptop', $project_category['platform_name']);
		$this->assertFalse($CI->Project_category_model->get_by_id_platform(FALSE));
	}

	public function test_get_by_platform_id()
	{
		$CI = $this->_load_ci();
		$this->_insert_records($CI);

		$project_categories = $CI->Project_category_model->get_by_platform_id(1);
		$this->assertCount(3, $project_categories);
		$this->assertContains('Desktop', $project_categories);
	}

	public function test_insert()
	{
		$CI = $this->_load_ci();
		$this->_insert_records($CI);

		$insert = array(
			'pc_name' => 'Personal Projects',
			'pc_description' => '',
			'pc_icon' => 'fa-user',
			'platform_id' => 2
		);
		$insert_id = $CI->Project_category_model->insert($insert);
		$this->assertEqual(5, $insert_id);
		$this->assertFalse($CI->Project_category_model->insert(FALSE));
	}

	public function test_update()
	{
		$CI = $this->_load_ci();
		$insert = array(
			'pc_name' => 'Personal Projects',
			'pc_description' => '',
			'pc_icon' => 'fa-user',
			'platform_id' => 2
		);
		$insert_id = $CI->Project_category_model->insert($insert);

		$update = $insert;
		$update['pc_id'] = $insert_id;
		$update['pc_name'] = 'Personal Projects';
		$this->assertEqual(1, $CI->Project_category_model->update($update));
		$this->assertFalse($CI->Project_category_model->update(FALSE));
	}

	public function test_delete_by_id()
	{
		$CI = $this->_load_ci();
		$this->_insert_records($CI);

		$this->assertEqual(1, $CI->Project_category_model->delete_by_id(1));
		$this->assertFalse($CI->Project_category_model->delete_by_id(FALSE));
	}

	public function test_delete_by_id_platform()
	{
		$CI = $this->_load_ci();
		$this->_insert_records($CI);

		$this->assertEqual(3, $CI->Project_category_model->delete_by_platform_id(1));
		$this->assertFalse($CI->Project_category_model->delete_by_platform_id(FALSE));
	}
	#endregion
	
} // end Project_category_model_test controller class