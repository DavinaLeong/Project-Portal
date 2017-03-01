<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Project_model_test.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 18 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
class Project_model_test extends TestCase
{
	public function setUp()
	{
		$this->resetInstance();
		$CI =& get_instance();
		$CI->load->model('Migration_model');
		$CI->Migration_model->reset();

		$CI->load->model('Project_model');
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
		$projects = array(
			array(
				'pc_id' => 1,
				'project_name' => 'Project 1',
				'project_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'project_icon' => 'fa-flag',
				'selected_project' => 1,
				'project_status' => 'Publish'
			),
			array(
				'pc_id' => 1,
				'project_name' => 'Project 2',
				'project_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'project_icon' => 'fa-flag',
				'selected_project' => 0,
				'project_status' => 'Publish'
			),
			array(
				'pc_id' => 1,
				'project_name' => 'Project 3',
				'project_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'project_icon' => 'fa-flag',
				'selected_project' => 0,
				'project_status' => 'Publish'
			),
			array(
				'pc_id' => 2,
				'project_name' => 'Project 4',
				'project_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'project_icon' => 'fa-flag',
				'selected_project' => 0,
				'project_status' => 'Publish'
			),
			array(
				'pc_id' => 1,
				'project_name' => 'Project 5',
				'project_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'project_icon' => 'fa-flag',
				'selected_project' => 0,
				'project_status' => 'Draft'
			)
		);

		foreach($projects as $project)
		{
			$CI->Project_model->insert($project);
		}

		if($do_echo) echo "\n--- inserted records: " . $CI->Project_model->count_all();
	}

	private function _truncate_table($do_echo=FALSE)
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->db->truncate(TABLE_PROJECT);

		if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PROJECT . " ---";
            echo "\n||| count_all: " . $CI->Project_model->count_all() . "\n";
        }
	}
	#endregion
	
	#region Test Functions
	public function test_count_all()
	{
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertEquals(5, $CI->Project_model->count_all());
	}

	public function test_get_all()
	{
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertCount(5, $CI->Project_model->get_all());
	}

	public function test_get_all_ids()
	{
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertCount(5, $CI->Project_model->get_all_ids());
	}

	public function test_get_all_platform()
	{
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertCount(5, $CI->Project_model->get_all_platform());
	}

	public function test_get_by_id()
	{
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertEquals('Project 1', $CI->Project_model->get_by_id(1)['project_name']);
	}

	public function test_get_by_id_project_category()
	{
		$this->_insert_records();
		$CI =& get_instance();
		$CI->load->model('Project_category_model');

		$project_category = array(
			'pc_name' => 'Project Category 1',
			'pc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'pc_icon' => 'fa-flag',
			'platform_id' => 1
		);
		$project_category['pc_id'] = $CI->Project_category_model->insert($project_category);

		$this->assertEquals('Project Category 1', $CI->Project_model->get_by_id_project_category(1)['pc_name']);

		$CI->load->database();
		$CI->db->truncate(TABLE_PROJECT_CATEGORY);
	}

	public function test_get_by_status()
	{
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertCount(4, $CI->Project_model->get_by_status('Publish'));
	}

	public function test_get_by_status_platform()
	{
		$this->_insert_records();
		$CI =& get_instance();

		$CI->load->model('Platform_model');
		$CI->load->model('Project_category_model');

		$platform = array(
			'platform_name' => 'Platform 1',
			'platform_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'platform_icon' => 'fa-flag',
			'platform_status' => 'Publish'
		);
		$CI->Platform_model->insert($platform);

		$project_category = array(
			'pc_name' => 'Project Category 1',
			'pc_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'pc_icon' => 'fa-flag',
			'platform_id' => 1
		);
		$project_category['pc_id'] = $CI->Project_category_model->insert($project_category);

		$this->assertCount(4, $CI->Project_model->get_by_status_platform('Publish'));
		$this->assertContains('Platform 1', $CI->Project_model->get_by_status_platform('Publish')[0]);
		//$projects = $CI->Project_model->get_by_status_platform('Publish');
		//var_dump($projects);

		$CI->load->database();
		$CI->db->truncate(TABLE_PROJECT_CATEGORY);
	}

	public function test_get_by_status_ids()
	{
		$this->_insert_records();
		$CI =& get_instance();
		$this->assertCount(4, $CI->Project_model->get_by_status_ids('Publish'));
	}
	#endregion

} //end Project_model_test class