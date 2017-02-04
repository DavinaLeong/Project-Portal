<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Platform.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 31 Jan 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Platform extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Platform_model');
	}
	
	public function index()
	{
	    redirect('admin/platform/browse');
	}

    public function browse()
    {
        $this->User_log_model->validate_access();
        $data = array(
            'platforms' => $this->Platform_model->get_all(),
            'create_uri' => 'admin/platform/create'
        );
        $this->load->view('admin/platform/browse_page', $data);
    }

    public function create()
    {
        $this->User_log_model->validate_access();
        $this->_set_rules_create_platform();
        if($this->form_validation->run())
        {
            if($platform_id = $this->Platform_model->insert($this->_prepare_create_platform_array()))
            {
                $this->User_log_model->log_message('Platform created. | platform_id: ' . $platform_id);
                $this->session->set_userdata('message', 'Platform created. <a href="' . site_url() . 'admin/platform/create">Create another.</a>');
                redirect('admin/platform/view/' . $platform_id);
            }
            else
            {
                $this->User_log_model->log_message('Unable to create Platform.');
                $this->session->set_userdata('message', 'Unable to create Platform.');
            }
        }

        $data = array(
            'status_options' => $this->Platform_model->_status_array()
        );
        $this->load->view('admin/platform/create_page', $data);
    }

    private function _set_rules_create_platform()
    {
        $this->form_validation->set_rules('platform_name', 'Platform Name', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('platform_icon', 'Platform Icon', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('platform_description', 'Platform Description', 'trim|required|max_length[512]');
        $status_str = implode(',', $this->Platform_model->_status_array());
        $this->form_validation->set_rules('platform_status', 'Platform Status',
            'trim|required|in_list[' . $status_str . ']|max_length[512]');
    }

    private function _prepare_create_platform_array()
    {
        $platform = array();
        $platform['platform_name'] = $this->input->post('platform_name');
        $platform['platform_icon'] = $this->input->post('platform_icon');
        $platform['platform_description'] = $this->input->post('platform_description');
        $platform['platform_status'] = $this->input->post('platform_status');

        return $platform;
    }

    public function view($platform_id)
    {
        $this->User_log_model->validate_access();
        $platform = $this->Platform_model->get_by_id($platform_id);
        if($platform)
        {
            $this->load->model('Project_model');
            $data = array(
                'platform' => $platform,
                'delete_modal_header' => 'Delete Platform Record',
                'delete_uri' => 'admin/platform/delete/' . $platform_id
            );
            $this->load->view('admin/platform/view_page', $data);
        }
        else
        {
            $this->session->set_userdata('message', 'Platform not found.');
            redirect('admin/platform/browse');
        }
    }

    public function edit($platform_id)
    {
        $this->User_log_model->validate_access();
        $platform = $this->Platform_model->get_by_id($platform_id);
        if($platform)
        {
            $this->_set_rules_edit_platform();
            if($this->form_validation->run())
            {
                if($this->Platform_model->update($this->_prepare_edit_platform_array($platform)))
                {
                    $this->User_log_model->log_message('Platform updated. | platform_id: ' . $platform_id);
                    $this->session->set_userdata('message', 'Platform updated.');
                    redirect('admin/platform/view/' . $platform_id);
                }
                else
                {
                    $this->User_log_model->log_message('Unable to update Platform. | platform_id: ' . $platform_id);
                    $this->session->set_userdata('message', 'Unable to update Platform.');
                }
            }

            $data = array(
                'platform' => $platform,
                'status_options' => $this->Platform_model->_status_array()
            );
            $this->load->view('admin/platform/edit_page', $data);
        }
        else
        {
            $this->session->set_userdata('message', 'Platform not found.');
            redirect('admin/platform/browse');
        }
    }

    private function _set_rules_edit_platform()
    {
        $this->form_validation->set_rules('platform_name', 'Platform Name', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('platform_icon', 'Platform Icon', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('platform_description', 'Platform Description', 'trim|required|max_length[512]');
        $status_str = implode(',', $this->Platform_model->_status_array());
        $this->form_validation->set_rules('platform_status', 'Platform Status',
            'trim|required|in_list[' . $status_str . ']|max_length[512]');
    }

    private function _prepare_edit_platform_array($platform)
    {
        $platform['platform_name'] = $this->input->post('platform_name');
        $platform['platform_icon'] = $this->input->post('platform_icon');
        $platform['platform_description'] = $this->input->post('platform_description');
        $platform['platform_status'] = $this->input->post('platform_status');

        return $platform;
    }

    public function delete($platform_id)
    {
        $this->User_log_model->validate_access();
        if($this->Platform_model->get_by_id($platform_id))
        {
            $this->load->model('Project_model');
            if($this->Project_model->get_by_platform_id($platform_id))
            {
                $this->session->set_userdata('message', 'Unable to delete Platform as there are existing Projects associated it.');
                redirect('admin/platform/view/' . $platform_id);
            }
            else
            {
                if($this->Platform_model->delete_by_id($platform_id))
                {
                    $this->User_log_model->log_message('Platform deleted. | platform_id: ' . $platform_id);
                    $this->session->set_userdata('message', 'Platform deleted.');
                    redirect('admin/platform/browse');
                }
                else
                {
                    $this->User_log_model->log_message('Unable to delete Platform. | platform_id: ' . $platform_id);
                    $this->session->set_userdata('message', 'Unable to delete Platform.');
                    redirect('admin/platform/view/' . $platform_id);
                }
            }
        }
        else
        {
            $this->session->set_userdata('message', 'Platform not found.');
            redirect('admin/platform/browse');
        }
    }
	
} // end Platform controller class