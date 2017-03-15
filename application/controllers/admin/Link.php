<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Link_model.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 06 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Link extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Link_model');
		$this->load->model('Link_category_model');
	}
	
	public function index()
	{
	    redirect('admin/link/browse');
	}

    public function browse()
    {
        $this->User_log_model->validate_access();
        $data = array(
            'links' => $this->Link_model->get_all(),
            'create_uri' => 'admin/link/create'
        );
        $this->load->view('admin/link/browse_page', $data);
    }

    public function create()
    {
        $this->User_log_model->validate_access();
        $this->_set_rules_create();
        if($this->form_validation->run())
        {
            if($link_id = $this->Link_model->insert($this->_prepare_create_array()))
            {
                $this->User_log_model->log_message('Link created. | link_id: ' . $link_id);
                $this->session->set_userdata('message', 'Link created. <a href="' . site_url() . '/admin/link/create">Create another.</a>');
                redirect('admin/link/view/' . $link_id);
            }
            else
            {
                $this->User_log_model->log_message('Unable to create Link record.');
                $this->session->set_userdata('message', 'Unable to create Link record.');
            }
        }

        $data = array(
            'link_categories' => $this->Link_category_model->get_all_project_platform('project.project_name', 'ASC'),
            'status_options' => $this->Link_model->_status_array()
        );
        $this->load->view('admin/link/create_page', $data);
    }

    private function _set_rules_create()
    {
        $id_str = implode(',', $this->Link_category_model->get_all_ids());
        $this->form_validation->set_rules('lc_id', 'Category', 'trim|required|in_list[' . $id_str . ']');
        $this->form_validation->set_rules('label', 'Label', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('url', 'URL', 'trim|required|valid_url|max_length[512]');
        $this->form_validation->set_rules('use_https', 'Use HTTPS', 'trim|in_list[0,1]');
        $status_str = implode(',', $this->Link_model->_status_array());
        $this->form_validation->set_rules('link_status', 'Status', 'trim|required|in_list[' . $status_str . ']');
    }

    private function _prepare_create_array()
    {
        $link = array();
        $link['lc_id'] = $this->input->post('lc_id');
        $link['label'] = $this->input->post('label');
        $link['url'] = $this->input->post('url');
        $link['use_https'] = $this->input->post('use_https') == 1 ? 1 : 0;
        $link['link_status'] = $this->input->post('link_status');
        return $link;
    }

    public function view($link_id)
    {
        $this->User_log_model->validate_access();
        $link = $this->Link_model->get_by_id_link_category_project($link_id);
        if($link)
        {
            $data = array(
                'link' => $link,
                'delete_modal_header' => 'Delete Link Record',
                'delete_uri' => 'admin/link/delete/' . $link_id
            );
            $this->load->view('admin/link/view_page', $data);
        }
        else
        {
            $this->session->set_userdata('message', 'Link not found.');
            redirect('admin/link/browse');
        }
    }

    public function edit($link_id)
    {
        $this->User_log_model->validate_access();
        $link = $this->Link_model->get_by_id_link_category_project($link_id);
        if($link)
        {
            $this->_set_rules_edit();
            if($this->form_validation->run())
            {
                if($this->Link_model->update($this->_prepare_edit_array($link)))
                {
                    $this->User_log_model->log_message('Link updated. | link_id: ' . $link_id);
                    $this->session->set_userdata('message', 'Link updated.');
                    redirect('admin/link/view/' . $link_id);
                }
                else
                {
                    $this->User_log_model->log_message('Unable to update Link. | link_id: ' . $link_id);
                    $this->session->set_userdata('message', 'Unable to update Link.');
                }
            }

            $data = array(
                'link' => $link,
                'link_categories' => $this->Link_category_model->get_all_project_platform('project.project_name', 'ASC'),
                'status_options' => $this->Link_model->_status_array()
            );
            $this->load->view('admin/link/edit_page', $data);
        }
        else
        {
            $this->session->set_userdata('message', 'Link not found.');
            redirect('admin/link/browse');
        }
    }

    private function _set_rules_edit()
    {
        $id_str = implode(',', $this->Link_category_model->get_all_ids());
        $this->form_validation->set_rules('lc_id', 'Category', 'trim|required|in_list[' . $id_str . ']');
        $this->form_validation->set_rules('label', 'Label', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('url', 'URL', 'trim|required|valid_url|max_length[512]');
        $this->form_validation->set_rules('use_https', 'Use HTTPS', 'trim|in_list[0,1]');
        $status_str = implode(',', $this->Link_model->_status_array());
        $this->form_validation->set_rules('link_status', 'Status', 'trim|required|in_list[' . $status_str . ']');
    }

    private function _prepare_edit_array($link)
    {
        $link['lc_id'] = $this->input->post('lc_id');
        $link['label'] = $this->input->post('label');
        $link['url'] = $this->input->post('url');
        $link['use_https'] = $this->input->post('use_https') == 1 ? 1 : 0;
        $link['link_status'] = $this->input->post('link_status');
        return $link;
    }

    public function delete($link_id)
    {
        if($this->Link_model->get_by_id($link_id))
        {
            if($this->Link_model->delete_by_id($link_id))
            {
                $this->User_log_model->log_message('Link deleted. | link_id: ' . $link_id);
                $this->session->set_userdata('message', 'Link deleted.');
                redirect('admin/link/browse');
            }
            else
            {
                $this->User_log_model->log_message('Unable to delete Link. | link_id: ' . $link_id);
                $this->session->set_userdata('message', 'Unable to delete Link.');
                redirect('admin/link/view/' . $link_id);
            }
        }
        else
        {
            $this->session->set_userdata('message', 'Link not found.');
            redirect('admin/link/browse');
        }
    }
	
} // end Link controller class