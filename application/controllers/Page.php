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
	    $this->load->model('Project_category_model');
	    $this->load->model('Project_model');
	    $this->load->model('Link_category_model');
	    $this->load->model('Link_model');

		$platform_id = 1;
		$project_categories = $this->Project_category_model->get_by_platform_id($platform_id, 'project_category.pc_name', 'ASC');
		foreach($project_categories as $pc_key=>$project_category)
		{
			$projects = $this->Project_model->get_by_pc_id_status($project_category['pc_id']);
			foreach($projects as $project_key=>$project)
			{
				$link_categories = $this->Link_category_model->get_by_project_id($project['project_id']);
				foreach($link_categories as $lc_key=>$link_category)
				{
					$link_categories[$lc_key]['links'] = $this->Link_model->get_by_lc_id($link_category['lc_id']);
				}
				$projects[$project_key]['link_categories'] = $link_categories;
			}
			$project_categories[$pc_key]['projects'] = $projects;
		}

        $data = array(
			'platform' => $this->Platform_model->get_by_id($platform_id),
            'project_categories' => $project_categories,
			'total_links' => $this->Link_model->count_by_status('Publish')
        );
        $this->load->view('page/index_page', $data);
	}
	
} // end Page controller class