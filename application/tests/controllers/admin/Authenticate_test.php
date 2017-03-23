<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Authenticate_test.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 06 Mar 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Authenticate_test extends TestCase
{
	const DO_ECHO = FALSE;

	const STATUS_ACTIVATED = 'Activated';
	const STATUS_DEACTIVATED = 'Deactivated';

	const USERNAME = 'admin';
	const PASSWORD = 'password';

	public function setUp()
	{
		$this->resetInstance();
		$CI =& get_instance();
		$CI->load->model('Migration_model');
		$CI->Migration_model->reset();

		$CI->load->model('User_log_model');
		$CI->load->library('session');
		$this->_truncate_table();
	}

	public function tearDown()
	{
		$this->_logout();
		$this->_truncate_table();
	}

	#region Helper Function
	private function _login()
	{
		$this->request('POST', 'admin/authenticate/login',
			array(
				'username' => $this::USERNAME,
				'password' => $this::PASSWORD
			)
		);
		$this->request('GET', 'admin/authenticate/start');
		if($this::DO_ECHO) echo "\n--- logged in\n";
	}

	private function _logout()
	{
		$this->request('GET', 'admin/authenticate/logout');
		$this->request('GET', 'admin/authenticate/login');
		if($this::DO_ECHO) echo "\n--- logged out\n";
	}

	private function _truncate_table($do_echo=FALSE)
	{
		$CI =& get_instance();
		$CI->load->database();
		$CI->load->model('User_model');
		$CI->db->truncate(TABLE_USER);

		$admin = array(
			'username' => $this::USERNAME,
			'name' => 'Default Admin',
			'password_hash' => password_hash($this::PASSWORD, PASSWORD_DEFAULT),
			'access' => 'A',
			'status' => $this::STATUS_ACTIVATED
		);
		$CI->User_model->insert($admin);

		if($do_echo)
		{
			echo "\n--- truncated table " . TABLE_USER;
			echo "\n||| count users: " . $CI->User_model->count_all() . "\n";
		}

		$CI->db->truncate(TABLE_USER_LOG);
        if($do_echo)
        {
            echo "\n--- truncated user log table ---\n";
        }
	}
	#endregion

	#region Test Function
	public function test_index()
	{
		if($this::DO_ECHO) echo "\n+++ test_index +++\n";
		$CI =& get_instance();
		$this->request('POST', 'admin/authenticate/login',
			array(
				'username' => $this::USERNAME,
				'password' => $this::PASSWORD
			)
		);

		$this->request('GET', 'admin/authenticate/index');
		$this->assertResponseCode(302);

		$this->assertRedirect('admin/authenticate/start');
	}

	public function test_login()
	{
		if($this::DO_ECHO) echo "\n+++ test_login +++\n";
		$CI =& get_instance();
		
		#region Velidation
		$output = $this->request('POST', 'admin/authenticate/login', 
			array(
				'username' => '',
				'password' => $this::PASSWORD
			)
		);
		$this->assertResponseCode(200);
		$this->assertContains('The Username field is required.', $output);


		$output = $this->request('POST', 'admin/authenticate/login',
			array(
				'username' => 'user',
				'password' => $this::PASSWORD
			)
		);
		$this->assertResponseCode(200);
		$this->assertContains('Invalid Username', $output);


		$CI->load->model('User_model');
		$user = array(
			'username' => 'user',
			'name' => 'Default User',
			'password' => '123456',
			'password_hash' => password_hash('123456', PASSWORD_DEFAULT),
			'access' => 'A',
			'status' => $this::STATUS_DEACTIVATED
		);
		$CI->User_model->insert($user);
		$output = $this->request('POST', 'admin/authenticate/login',
			array(
				'username' => $user['username'],
				'password' => $user['password']
			)
		);
		$this->assertResponseCode(200);
		$this->assertContains('This account has been deactivated.', $output);


		$output = $this->request('POST', 'admin/authenticate/login',
			array(
				'username' => $this::USERNAME,
				'password' => '123456'
			)
		);
		$this->assertResponseCode(200);
		$this->assertContains('Password is incorrect.', $output);
		#endregion

		#region Successful Login
		$this->request('POST', 'admin/authenticate/login',
			array(
				'username' => $this::USERNAME,
				'password' => $this::PASSWORD
			)
		);
		$this->assertResponseCode(302);
		$this->assertRedirect('admin/authenticate/start');

		$output = $this->request('GET', 'admin/authenticate/start');
		$this->assertResponseCode(200);
		$this->assertContains('Welcome', $output);
		#endregion
	}

	public function test_logout()
	{
		if($this::DO_ECHO) echo "\n+++ test_logout +++\n";
		$this->_login();

		$this->request('GET', 'admin/authenticate/logout');
		$this->assertResponseCode(302);
		$this->assertRedirect('admin/authenticate/login');

		$output = $this->request('GET', 'admin/authenticate/login');
		$this->assertResponseCode(200);
		$this->assertContains('You have been logged out.', $output);
	}

	public function test_start()
	{
		if($this::DO_ECHO) echo "\n+++ test_start +++\n";
		$this->_login();

		$output = $this->request('GET', 'admin/authenticate/start');
		$this->assertResponseCode(200);
		$this->assertContains('Welcome', $output);
	}

	public function test_tasks()
	{
		if($this::DO_ECHO) echo "\n+++ test_tasks +++\n";
		$this->_login();

		$output = $this->request('GET', 'admin/authenticate/tasks');
		$this->assertResponseCode(200);
		$this->assertContains('Tasks', $output);
	}
	#endregion

} //end Authenticate_test class