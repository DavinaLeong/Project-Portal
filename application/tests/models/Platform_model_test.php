<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Platform_model.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 16 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Platform_model_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $CI = $this->_load_ci();
        $CI->load->model('Migration_model');
        $CI->Migration_model->reset();

        $CI->load->model('Platform_model');
        $CI->load->helper('datetime_format');
        $this->_truncate_table($CI);
    }

    #region Helper Functions
    private function _load_ci()
    {
        $CI =& get_instance();
        return $CI;
    }

    private function _insert_records($CI)
    {
        $platforms = array(
            array(
                'platform_name' => 'Acer Predator',
                'platform_icon' => 'fa-desktop',
                'platform_description' => 'Home main computer',
                'platform_status' => 'Publish'
            ),
            array(
                'platform_name' => 'Lenovo Laptop',
                'platform_icon' => 'fa-laptop',
                'platform_description' => 'Work laptop',
                'platform_status' => 'Publish'
            ),
            array(
                'platform_name' => 'Surface Pro',
                'platform_icon' => 'fa-tablet',
                'platform_description' => 'Tablet by Microsoft',
                'platform_status' => 'Publish'
            )
        );
        foreach ($platforms as $platform)
        {
            $CI->Platform_model->insert($platform);
        }
        echo "\n--- no of records: " . $CI->Platform_model->count_all() . " ---\n";
    }

    private function _truncate_table($CI, $do_echo=FALSE)
    {
        $CI->load->database();
        $CI->db->truncate(TABLE_PLATFORM);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PLATFORM . " ---";
            echo "\n||| count_all: " . $CI->Platform_model->count_all() . "\n";
        }
    }
    #endregion

    #region Test Functions
    public function test_count_all()
    {
        $CI = $this->_load_ci();
        $this->_insert_records($CI);
        $this->assertEquals(3, $CI->Platform_model->count_all());
        $this->_truncate_table($CI);
    }

    public function test_get_all()
    {
        $CI = $this->_load_ci();
        $this->_insert_records($CI);
        $platforms = $CI->Platform_model->get_all();
        $this->assertCount(3, $platforms);
        $this->assertEquals('Acer Predator', $platforms[0]['platform_name']);
        $this->_truncate_table($CI);
    }

    public function test_get_all_ids()
    {
        $CI = $this->_load_ci();
        $this->_insert_records($CI);
        $this->assertCount(3, $CI->Platform_model->get_all_ids());
        $this->_truncate_table($CI);
    }

    public function test_get_by_status()
    {
        $CI = $this->_load_ci();
        $this->_insert_records($CI);
        $platform = array(
            'platform_name' => 'MacBook Air',
            'platform_icon' => 'fa-laptop',
            'platform_description' => 'Mac Laptop',
            'platform_status' => 'Draft'
        );
        $CI->Platform_model->insert($platform);
        $platforms = $CI->Platform_model->get_by_status('Draft');
        $this->assertCount(1, $platforms);
        $this->assertEquals($platform['platform_name'], $platforms[0]['platform_name']);
        $this->_truncate_table($CI);
    }

    public function test_get_by_status_ids()
    {
        $CI = $this->_load_ci();
        $this->_insert_records($CI);
        $platform = array(
            'platform_name' => 'MacBook Air',
            'platform_icon' => 'fa-laptop',
            'platform_description' => 'Mac Laptop',
            'platform_status' => 'Draft'
        );
        $CI->Platform_model->insert($platform);
        $platforms = $CI->Platform_model->get_by_status_ids('Draft');
        $this->assertCount(1, $platforms);
        $this->assertContains(4, $platforms);
        $this->_truncate_table($CI);
    }

    public function test_get_by_id()
    {
        $CI = $this->_load_ci();
        $this->_insert_records($CI);
        $this->assertEquals('Acer Predator', $CI->Platform_model->get_by_id(1)['platform_name']);
        $this->assertEquals('fa-laptop', $CI->Platform_model->get_by_id(2)['platform_icon']);
        $this->assertFalse($CI->Platform_model->get_by_id(FALSE));
        $this->_truncate_table($CI);
    }

    public function test_insert()
    {
        $CI = $this->_load_ci();
        $insert = array(
            'platform_name' => 'Acer Predator',
            'platform_icon' => 'fa-desktop',
            'platform_description' => 'Home desktop',
            'platform_status' => 'Active'
        );
        $insert_id = $CI->Platform_model->insert($insert);
        $this->assertEquals(1, $insert_id);
        $this->assertEquals(1, $CI->Platform_model->count_all());
        $this->assertFalse($CI->Platform_model->insert(FALSE));
        $this->_truncate_table($CI);
    }

    public function test_update()
    {
        $CI = $this->_load_ci();
        $insert = array(
            'platform_name' => 'Acer Predator',
            'platform_icon' => 'fa-desktop',
            'platform_description' => 'Home desktop',
            'platform_status' => 'Active'
        );
        $insert_id = $CI->Platform_model->insert($insert);

        $update = $insert;
        $update['platform_id'] = $insert_id;
        $update['platform_description'] = 'Main home desktop computer';

        $this->assertEquals(1, $CI->Platform_model->update($update));
        $this->assertEquals('Main home desktop computer', $CI->Platform_model->get_by_id($insert_id)['platform_description']);
        $this->assertFalse($CI->Platform_model->update(FALSE));
        $this->_truncate_table($CI);
    }

    public function test_delete_by_id()
    {
        $CI = $this->_load_ci();
        $this->_insert_records($CI);
        $platform_id = 3;
        $this->assertContains('Surface Pro', $CI->Platform_model->get_by_id($platform_id));
        $this->assertEquals(1, $CI->Platform_model->delete_by_id($platform_id));
        $this->assertNull($CI->Platform_model->get_by_id($platform_id));
        $this->assertFalse($CI->Platform_model->delete_by_id(FALSE));
        $this->_truncate_table($CI);
    }

    public function test_status_array()
    {
        $CI = $this->_load_ci();
        $this->assertCount(2, $CI->Platform_model->_status_array());
        $this->assertContains('Draft', $CI->Platform_model->_status_array());
    }
    #endregion

} //end Platform_model_test class