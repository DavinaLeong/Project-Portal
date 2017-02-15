<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: User_model_test.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 15 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class User_model_test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $CI =& get_instance();
        $CI->load->model('Migration_model');
        $CI->Migration_model->reset();
    }

    private function _load_ci()
    {
        $CI =& get_instance();
        $CI->load->model('User_model');
        return $CI;
    }

    public function test_count_all()
    {
        $CI = $this->_load_ci();
        $this->assertEquals(1, $CI->User_model->count_all());
    }

    public function test_get_all()
    {
        $CI = $this->_load_ci();
        $users = $CI->User_model->get_all();
        $this->assertEquals('admin', $users[0]['username']);
        $this->assertEquals('Default Admin', $users[0]['name']);
    }

    public function test_get_by_user_id()
    {
        $CI = $this->_load_ci();
        $user = $CI->User_model->get_by_user_id(1);
        $this->assertEquals('admin', $user['username']);
        $this->assertEquals('Default Admin', $user['name']);
    }

    public function test_get_by_username()
    {
        $CI = $this->_load_ci();
        $user = $CI->User_model->get_by_username('admin');
        $this->assertEquals(1, $user['user_id']);
        $this->assertEquals('Default Admin', $user['name']);
    }

    public function test_access_array()
    {
        $CI = $this->_load_ci();
        $accesses = $CI->User_model->_access_array();
        $this->assertCount(3, $accesses);
        $this->assertContains('A', $accesses);
        $this->assertArrayHasKey('Administrator', $accesses);
    }

    public function test_status_array()
    {
        $CI = $this->_load_ci();
        $statuses = $CI->User_model->_status_array();
        $this->assertCount(2, $statuses);
        $this->assertContains('Activated', $statuses);
    }

} //end User_model_test class