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
    const DO_ECHO = FALSE;

    public function setUp()
    {
        $this->resetInstance();
        $CI =& get_instance();
        $CI->load->model('Migration_model');
        $CI->Migration_model->reset();

        $CI->load->model('Platform_model');
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
        if($do_echo) echo "\n||| inserted platforms: " . $CI->Platform_model->count_all() . "\n";
    }

    private function _truncate_table($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->truncate(TABLE_PLATFORM);
        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_PLATFORM . " ---";
            echo "\n||| count all: " . $CI->Platform_model->count_all() . "\n";
        }
    }
    #endregion

    #region Test Functions
    public function test_count_all()
    {
        if($this::DO_ECHO) echo "\n+++ test_count_all +++\n";
        $CI =& get_instance();
        $this->_insert_records();
        $this->assertEquals(3, $CI->Platform_model->count_all());
    }

    public function test_get_all()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_all +++\n";
        $CI =& get_instance();
        $this->_insert_records();
        $platforms = $CI->Platform_model->get_all();
        $this->assertCount(3, $platforms);
        $this->assertEquals('Acer Predator', $platforms[0]['platform_name']);
    }

    public function test_get_all_ids()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_all_ids +++\n";
        $CI =& get_instance();
        $this->_insert_records();
        $this->assertCount(3, $CI->Platform_model->get_all_ids());
    }

    public function test_get_by_status()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_by_status +++\n";
        $CI =& get_instance();
        $this->_insert_records();
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
    }

    public function test_get_by_status_ids()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_by_status_ids +++\n";
        $CI =& get_instance();
        $this->_insert_records();
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
    }

    public function test_get_by_id()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_by_id +++\n";
        $CI =& get_instance();
        $this->_insert_records();
        $this->assertEquals('Acer Predator', $CI->Platform_model->get_by_id(1)['platform_name']);
        $this->assertEquals('fa-laptop', $CI->Platform_model->get_by_id(2)['platform_icon']);
        $this->assertFalse($CI->Platform_model->get_by_id(FALSE));
    }

    public function test_insert()
    {
        if($this::DO_ECHO) echo "\n+++ test_insert +++\n";
        $CI =& get_instance();
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
    }

    public function test_update()
    {
        if($this::DO_ECHO) echo "\n+++ test_update +++\n";
        $CI =& get_instance();
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
    }

    public function test_delete_by_id()
    {
        if($this::DO_ECHO) echo "\n+++ test_delete_by_id +++\n";
        $CI =& get_instance();
        $this->_insert_records();
        $platform_id = 3;
        $this->assertContains('Surface Pro', $CI->Platform_model->get_by_id($platform_id));
        $this->assertEquals(1, $CI->Platform_model->delete_by_id($platform_id));
        $this->assertNull($CI->Platform_model->get_by_id($platform_id));
        $this->assertFalse($CI->Platform_model->delete_by_id(FALSE));
    }

    public function test_status_array()
    {
        if($this::DO_ECHO) echo "\n+++ test_status_array +++\n";
        $CI =& get_instance();
        $this->assertCount(2, $CI->Platform_model->_status_array());
        $this->assertContains('Draft', $CI->Platform_model->_status_array());
    }
    #endregion

} //end Platform_model_test class