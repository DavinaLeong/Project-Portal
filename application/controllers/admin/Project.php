<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Project.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 02 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Project extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Project_model');
	}
	
	public function index()
	{
	    redirect('admin/project/browse');
	}

    public function browse()
    {
        $this->User_log_model->validate_access();
        $data = array(
            'projects' => $this->Project_model->get_all(),
            'create_uri' => 'admin/project/create'
        );
        $this->load->view('admin/project/browse_page', $data);
    }

    public function create()
    {
        $this->User_log_model->validate_access();
		$this->load->model('Project_category_model');
        $this->_set_rules_create_project();
        if($this->form_validation->run())
        {
            if($project_id = $this->Project_model->insert($this->_prepare_create_project_array()))
            {
                $this->User_log_model->log_message('Project created. | project_id: ' . $project_id);
                $this->session->set_userdata('message', 'Project created. <a href="' . site_url() . 'admin/project/create">Create another.</a>');
                redirect('admin/project/view/' . $project_id);
            }
            else
            {
                $this->User_log_model->log_message('Unable to create Project.');
                $this->session->set_userdata('message', 'Unable to create Project.');
            }
        }

        $data = array(
			'project_categories' => $this->Project_category_model->get_all('pc_name', 'asc'),
            'status_options' => $this->Project_model->_status_array()
        );
        $this->load->view('admin/project/create_page', $data);
    }

    private function _set_rules_create_project()
    {
		$pc_ids_str = implode(',', $this->Project_category_model->get_all_ids());
		$this->form_validation->set_rules('pc_id', 'Project Category', 'trim|required|in_list[' . $pc_ids_str . ']');
        $this->form_validation->set_rules('project_name', 'Project Name', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('project_description', 'Project Description', 'trim|required|max_length[512]');
        $status_str = implode(',', $this->Project_model->_status_array());
        $this->form_validation->set_rules('project_status', 'Project Status',
            'trim|required|in_list[' . $status_str . ']|max_length[512]');
    }

    private function _prepare_create_project_array()
    {
        $project = array();
        $project['pc_id'] = $this->input->post('pc_id');
        $project['project_name'] = $this->input->post('project_name');
        $project['project_icon'] = $this->input->post('project_icon');
        $project['project_description'] = $this->input->post('project_description');
        $project['project_status'] = $this->input->post('project_status');

        return $project;
    }

    public function view($project_id)
    {
        $this->User_log_model->validate_access();
        $project = $this->Project_model->get_by_pc_id_project_category($project_id);
        if($project)
        {
            $data = array(
                'project' => $project,
                'delete_modal_header' => 'Delete Project Record',
                'delete_uri' => 'admin/project/delete/' . $project_id
            );
            $this->load->view('admin/project/view_page', $data);
        }
        else
        {
            $this->session->set_userdata('message', 'Project not found.');
            redirect('admin/project/browse');
        }
    }

    public function edit($project_id)
    {
        $this->User_log_model->validate_access();
        $project = $this->Project_model->get_by_id($project_id);
        if($project)
        {
			$this->load->model('Project_category_model');
            $this->_set_rules_edit_project();
            if($this->form_validation->run())
            {
                if($this->Project_model->update($this->_prepare_edit_project_array($project)))
                {
                    $this->User_log_model->log_message('Project updated. | project_id: ' . $project_id);
                    $this->session->set_userdata('message', 'Project updated.');
                    redirect('admin/project/view/' . $project_id);
                }
                else
                {
                    $this->User_log_model->log_message('Unable to update Project. | project_id: ' . $project_id);
                    $this->session->set_userdata('message', 'Unable to update Project.');
                }
            }

            $data = array(
                'project' => $project,
				'project_category' => $this->Project_category_model->get_all(),
                'status_options' => $this->Project_model->_status_array()
            );
            $this->load->view('admin/project/edit_page', $data);
        }
        else
        {
            $this->session->set_userdata('message', 'Project not found.');
            redirect('admin/project/browse');
        }
    }

    private function _set_rules_edit_project()
    {
		$pc_ids_str = implode(',', $this->Project_category_model->get_all_ids());
		$this->form_validation->set_rules('pc_id', 'Project Category', 'trim|required|in_list[' . $pc_ids_str . ']');
		$this->form_validation->set_rules('project_name', 'Project Name', 'trim|required|max_length[512]');
		$this->form_validation->set_rules('project_description', 'Project Description', 'trim|required|max_length[512]');
		$status_str = implode(',', $this->Project_model->_status_array());
		$this->form_validation->set_rules('project_status', 'Project Status',
			'trim|required|in_list[' . $status_str . ']|max_length[512]');
    }

    private function _prepare_edit_project_array($project)
    {
        $project['pc_id'] = $this->input->post('pc_id');
        $project['project_name'] = $this->input->post('project_name');
        $project['project_icon'] = $this->input->post('project_icon');
        $project['project_description'] = $this->input->post('project_description');
        $project['project_status'] = $this->input->post('project_status');

        return $project;
    }

    public function delete($project_id)
    {
        $this->User_log_model->validate_access();
        if($this->Project_model->get_by_id($project_id))
        {
            if($this->Project_model->delete_by_id($project_id))
            {
                $this->User_log_model->log_message('Project deleted. | project_id: ' . $project_id);
                $this->session->set_userdata('message', 'Project deleted.');
                redirect('admin/project/browse');
            }
            else
            {
                $this->User_log_model->log_message('Unable to delete Project. | project_id: ' . $project_id);
                $this->session->set_userdata('message', 'Unable to delete Project.');
                redirect('admin/project/view/' . $project_id);
            }
        }
        else
        {
            $this->session->set_userdata('message', 'Project not found.');
            redirect('admin/project/browse');
        }
    }
	
} // end Project controller class