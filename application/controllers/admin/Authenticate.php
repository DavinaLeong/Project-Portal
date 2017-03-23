<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Authenticate.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 27 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Authenticate extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	public function index()
	{
	    redirect('admin/authenticate/start');
		//@codeCoverageIgnoreStart
	}
	//@codeCoverageIgnoreEnd

    public function login()
    {
        if($this->session->userdata('user_id') || $this->session->userdata('access'))
		{
			$this->User_log_model->log_message('User has been logged out.');
            $this->session->unset_userdata('post_platform_id');
            $this->session->unset_userdata('post_pc_id');
            $this->session->unset_userdata('post_project_id');
            $this->session->unset_userdata('post_lc_id');

			$this->session->unset_userdata('user_id');
			$this->session->unset_userdata('username'
		);
			$this->session->unset_userdata('name');
			$this->session->unset_userdata('access');
			$this->session->set_userdata('message', 'You have been logged out.');
		}

		$this->_set_rules_login();
		if($this->form_validation->run())
		{
			if($user = $this->User_model->get_by_username($this->input->post('username')))
			{
				if($user['status'] == 'Activated')
				{
					if(password_verify($this->input->post('password'), $user['password_hash']))
					{
						$this->_set_userdata($user);
						$this->User_log_model->log_message('User has logged in.');
						$this->session->set_userdata('message', 'Login successful.');
						redirect('admin/authenticate/start');
						//@codeCoverageIgnoreStart
					}
					//@codeCoverageIgnoreEnd
					else
					{
						$this->session->set_userdata('message', 'Password is incorrect.');
					}
				}
				else
				{
					$this->session->set_userdata('message', 'This account has been deactivated.');
				}
			}
			else
			{
				$this->session->set_userdata('message', 'Invalid Username');
			}
		}

		$this->load->view('admin/authenticate/login_page');
    }

	private function _set_rules_login()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[512]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[512]');
	}

	private function _set_userdata($user)
	{
		$this->session->set_userdata('user_id', $user['user_id']);
		$this->session->set_userdata('username', $user['username']);
		$this->session->set_userdata('name', $user['name']);
		$this->session->set_userdata('access', $user['access']);
	}

    public function logout()
    {
		redirect('admin/authenticate/login');
		//@codeCoverageIgnoreStart
    }
	//@codeCoverageIgnoreEnd

    public function start()
    {
		$this->User_log_model->validate_access();
        $this->load->view('admin/authenticate/start_page');
    }

    public function tasks()
    {
        $this->User_log_model->validate_access();
        $this->load->view('admin/authenticate/tasks_page');
    }

} // end Test controller class
