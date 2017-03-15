<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Migrate.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 26 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
//@codeCoverageIgnoreStart
class Migrate extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Migration_model');
		$this->load->library('migration');
	}

	public function index()
	{
		if($this->migration->current() === FALSE)
		{
			show_error($this->migration->error_string());
		}
		else
		{
			echo '<hr/>';
			echo '<h3>Status</h3>';
			echo '<p>Migration successful.<br/>';
			echo 'Migration version: ' . $this->Migration_model->get_version() . '</p>';
			$this->load->view('migrate/result_page');
		}
	}

	public function reset()
	{
		$this->Migration_model->reset();
	}
	
} // end Migrate controller class
//@codeCoverageIgnoreEnd