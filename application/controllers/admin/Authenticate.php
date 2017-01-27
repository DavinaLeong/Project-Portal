<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Authenticate.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 27 Jan 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Authenticate extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
	    redirect('admin/test/start');
	}

    public function login()
    {
        $this->load->view('admin/test/login_page');
    }

    public function logout()
    {

    }

    public function start()
    {
        $this->load->view('admin/test/start_page');
    }
	
} // end Test controller class