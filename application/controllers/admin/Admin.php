<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Admin.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 31 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
//@codeCoverageIgnoreStart
class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
	    redirect('admin/admin/start');
	}

    public function start()
    {
        $this->User_log_model->validate_access();
        $this->load->view('admin/authenticate/start_page');
    }
	
} // end Admin controller class
//@codeCoverageIgnoreEnd