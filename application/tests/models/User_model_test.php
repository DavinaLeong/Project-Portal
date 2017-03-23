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
    const DO_ECHO = FALSE;

    const TEST_USERNAME = 'admin';
    const TEST_PASSWORD = 'password';

    public function setUp()
    {
        $this->resetInstance();
        $CI =& get_instance();
        $CI->load->model('Migration_model');
        $CI->Migration_model->reset();

        $CI->load->model('User_model');
        $CI->load->helper('datetime_format');
        $this->_truncate_table();
    }

    public function tearDown()
    {
        $this->_truncate_table();
    }

    #region Helper Functions
    private function _truncate_table($do_echo=FALSE)
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->db->truncate(TABLE_USER);
        $admin = array(
            'username' => 'admin',
            'name' => 'Default Admin',
            'password_hash' => password_hash($this::TEST_PASSWORD, PASSWORD_DEFAULT),
            'access' => 'A',
            'status' => 'Activated'
        );
        $CI->User_model->insert($admin);

        if($do_echo)
        {
            echo "\n--- truncated table " . TABLE_USER . " ---";
            echo "\n||| insert id: " . $CI->User_model->insert($admin);
            echo "\n||| inserted users: " . $CI->User_model->count_all() . "\n";
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
        $CI =& get_instance();
        $this->assertEquals(1, $CI->User_model->count_all());
    }

    public function test_get_all()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_all +++\n";
        $CI =& get_instance();
        $users = $CI->User_model->get_all();
        $this->assertEquals('admin', $users[0]['username']);
        $this->assertEquals('Default Admin', $users[0]['name']);
    }

    public function test_get_by_user_id()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_by_user_id +++\n";
        $CI =& get_instance();
        $user = $CI->User_model->get_by_user_id(1);
        $this->assertEquals('admin', $user['username']);
        $this->assertEquals('Default Admin', $user['name']);
        $this->assertFalse($CI->User_model->get_by_user_id(FALSE));
    }

    public function test_get_by_username()
    {
        if($this::DO_ECHO) echo "\n+++ test_get_by_username +++\n";
        $CI =& get_instance();
        $user = $CI->User_model->get_by_username($this::TEST_USERNAME);
        $this->assertEquals(1, $user['user_id']);
        $this->assertEquals('Default Admin', $user['name']);
        $this->assertFalse($CI->User_model->get_by_username(FALSE));
    }

    public function test_insert()
    {
        if($this::DO_ECHO) echo "\n+++ test_insert +++\n";
        $CI =& get_instance();
        $insert_user = array(
            'username' => 'davina_leong',
            'name' => 'Davina Leong',
            'password_hash' => password_hash($this::TEST_PASSWORD, PASSWORD_DEFAULT),
            'access' => 'A',
            'status' => 'Activated'
        );

        $insert_id = $CI->User_model->insert($insert_user);
        $this->assertEquals(2, $insert_id);
        $this->assertEquals(2, $CI->User_model->count_all());
        $this->assertFalse($CI->User_model->insert(FALSE));
    }

    public function test_update()
    {
        if($this::DO_ECHO) echo "\n+++ test_update +++\n";
        $CI =& get_instance();
        $test_name = 'Davina Leong';
        $insert_user = array(
            'username' => 'davina_leong',
            'name' => $test_name,
            'password_hash' => password_hash($this::TEST_PASSWORD, PASSWORD_DEFAULT),
            'access' => 'A',
            'status' => 'Activated'
        );
        $insert_id = $CI->User_model->insert($insert_user);
        $this->assertContains($test_name, $CI->User_model->get_by_user_id($insert_id));

        $update_user = array(
            'user_id' => $insert_id,
            'username' => 'davina_lsy',
            'name' => $test_name,
            'password_hash' => password_hash($this::TEST_PASSWORD, PASSWORD_DEFAULT),
            'access' => 'A',
            'status' => 'Activated'
        );
        $this->assertEquals(1, $CI->User_model->update($update_user));
        $this->assertNull($CI->User_model->get_by_username('davina_leong'));
        $this->assertContains($test_name, $CI->User_model->get_by_username('davina_lsy'));
        $this->assertFalse($CI->User_model->update(FALSE));
    }

    public function test_access_array()
    {
        if($this::DO_ECHO) echo "\n+++ test_access_array +++\n";
        $CI =& get_instance();
        $accesses = $CI->User_model->_access_array();
        $this->assertCount(3, $accesses);
        $this->assertContains('A', $accesses);
        $this->assertArrayHasKey('Administrator', $accesses);
    }

    public function test_status_array()
    {
        if($this::DO_ECHO) echo "\n+++ test_status_array +++\n";
        $CI =& get_instance();
        $statuses = $CI->User_model->_status_array();
        $this->assertCount(2, $statuses);
        $this->assertContains('Activated', $statuses);
    }
    #endregion

} //end User_model_test class