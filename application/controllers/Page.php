<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 08 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Page extends CI_Controller
{
	public function index()
	{
	    $this->load->model('Platform_model');
        $data = array(
            'platforms' => $this->Platform_model->get_all()
        );
        $this->load->view('page/index_page', $data);
	}
	
} // end Page controller class