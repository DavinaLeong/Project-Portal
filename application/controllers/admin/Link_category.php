<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Link_category.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 04 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Link_category extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Link_category_model');
		$this->load->model('Project_model');
	}

	public function index()
	{
		redirect('admin/link_category/browse');
	}

	public function browse()
	{
		$this->User_log_model->validate_access();
		$data = array(
			'link_categories' => $this->Link_category_model->get_all_project(),
			'create_uri' => 'admin/link_category/create'
		);
		$this->load->view('admin/link_category/browse_page', $data);
	}

	public function create()
	{
		$this->User_log_model->validate_access();
		$this->_set_rules_create();
		if($this->form_validation->run())
		{
			if($lc_id = $this->Link_category_model->insert($this->_prepare_create_array()))
			{
				$this->User_log_model->log_message('Link Category created. | lc_id: ' . $lc_id);
				$this->session->set_userdata('message', 'Link Category created. <a href="' . site_url() . 'admin/link_category/create">Create another.</a>');
				redirect('admin/link_category/browse');
			}
			else
			{
				$this->User_log_model->log_message('Unable to create Link Category.');
				$this->session->set_userdata('message', 'Unable to create Link Category.');
			}
		}
		$data = array(
			'projects' => $this->Project_model->get_by_status('Publish', 'project_name', 'ASC')
		);
		$this->load->view('admin/link_category/create_page', $data);
	}

	private function _set_rules_create()
	{
		$id_array_str = implode(',', $this->Project_model->get_all_ids());
		$this->form_validation->set_rules('project_id', 'Project', 'trim|required|in_list[' . $id_array_str . ']');
		$this->form_validation->set_rules('lc_name', 'Name', 'trim|required|max_length[512]');
		$this->form_validation->set_rules('lc_description', 'Description'. 'trim|max_length[512]');
	}

	private function _prepare_create_array()
	{
		$link_category = array();
		$link_category['project_id'] = $this->input->post('project_id');
		$link_category['lc_name'] = $this->input->post('lc_name');
		$link_category['lc_description'] = $this->input->post('lc_description');
		return $link_category;
	}

    public function view($lc_id)
    {
        $this->User_log_model->validate_access();
        $link_category = $this->Link_category_model->get_by_id($lc_id);
        if($link_category)
        {
            //$this->load->model('Link_model');
            $data = array(
                'link_category' => $link_category,
                'links' => array(), //$this->Link_model->get_by_lc_id($lc_id),
                'delete_modal_header' => 'Delete Link Category Record',
                'delete_uri' => 'admin/link_category/delete/' . $lc_id
            );
            $this->load->view('admin/link_category/view_page', $data);
        }
        else
        {
            $this->session->set_userdata('message', 'Link Category record not found.');
            redirect('admin/link_project/browse');
        }
    }

	public function edit($lc_id)
	{
		$this->User_log_model->validate_access();
		$link_category = $this->Link_category_model->get_by_id($lc_id);
		if($link_category)
		{
			$this->_set_rules_edit();
			if($this->form_validation->run())
			{
				if($this->Link_category_model->update($this->_prepare_edit_array($link_category)))
				{
					$this->User_log_model->log_message('Link Category updated. | lc_id: ' . $lc_id);
					$this->session->set_userdata('message', 'Link Category updated.');
					redirect('admin/link_category/browse');
				}
				else
				{
					$this->User_log_model->log_message('Unable to update Link Category. | lc_id: ' . $lc_id);
					$this->session->set_userdata('message', 'Unable to update Link Category.');
				}
			}

			$data = array(
				'link_category' => $link_category,
				'projects' => $this->Project_model->get_by_status('Publish', 'project_name', 'ASC')
			);
			$this->load->view('admin/link_category/edit_page', $data);
		}
		else
		{
			$this->session->set_userdata('message', 'Link Category record not found.');
			redirect('admin/link_category/browse');
		}
	}

	private function _set_rules_edit()
	{
		$id_array_str = implode(',', $this->Project_model->get_all_ids());
		$this->form_validation->set_rules('project_id', 'Project', 'trim|required|in_list[' . $id_array_str . ']');
		$this->form_validation->set_rules('lc_name', 'Name', 'trim|required|max_length[512]');
		$this->form_validation->set_rules('lc_description', 'Description'. 'trim|max_length[512]');
	}

	private function _prepare_edit_array($link_category)
	{
		$link_category['project_id'] = $this->input->post('project_id');
		$link_category['lc_name'] = $this->input->post('lc_name');
		$link_category['lc_description'] = $this->input->post('lc_description');
		return $link_category;
	}

	public function delete($lc_id)
	{
		if($this->Link_category_model->get_by_id(($lc_id)))
		{
			if($this->Link_category_model->delete_by_id($lc_id))
			{
				$this->User_log_model->log_message('Link Category deleted. | lc_id: ' . $lc_id);
				$this->session->set_userdata('message', 'Link Category deleted.');
			}
			else
			{
				$this->User_log_model->log_message('Unable to delete Link Category. | lc_id: ' . $lc_id);
				$this->session->set_userdata('message', 'Unable to delete Link Category.');
			}
			redirect('admin/link_category/browse');
		}
		else
		{
			$this->session->set_userdata('message', 'Unable to delete Link Category.');
			redirect('admin/link_category/browse');
		}
	}
	
} // end Link_category controller class