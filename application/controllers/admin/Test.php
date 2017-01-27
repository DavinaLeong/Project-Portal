<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Davina Leong
 * Date: 27/1/2017
 * Time: 12:11 PM
 */
class Test extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
	    $this->load->view('admin/test/index_page');
	}

    public function login()
    {
        $this->load->view('admin/test/login_page');
    }

    public function browse()
    {
        $this->load->view('admin/test/browse_page');
    }

    public function form()
    {
        $this->load->view('admin/test/form_page');
    }
	
} // end Test controller class