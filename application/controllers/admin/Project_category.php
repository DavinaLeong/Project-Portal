<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Project_category.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 01 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Project_category extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('Platform_model');
		$this->load->model('Project_category_model');
	}
	
	public function index()
	{
	    redirect('admin/project_category/browse');
        //@codeCoverageIgnoreStart
	}
    //@codeCoverageIgnoreEnd

    public function browse()
    {
        $this->User_log_model->validate_access();
        $data = array(
            'project_categories' => $this->Project_category_model->get_all(),
            'create_uri' => 'admin/project_category/create'
        );
        $this->load->view('admin/project_category/browse_page', $data);
    }

    public function create($platform_id='')
    {
        $this->User_log_model->validate_access();
        $this->_set_rules_create();
        if($this->form_validation->run())
        {
            if($pc_id = $this->Project_category_model->insert($this->_prepare_create_array()))
            {
                $this->User_log_model->log_message('Project Category created. | pc_id: ' . $pc_id);
                $this->session->set_userdata('message', 'Project Category created. <a href="' . site_url() . '/admin/project_category/create">Create another.</a>');
                redirect('admin/project_category/view/' . $pc_id);
                //@codeCoverageIgnoreStart
            }
            else
            {
                $this->User_log_model->log_message('Unable to create Project Category.');
                $this->session->set_userdata('Unable to create Project Category.');
            }
        }
        //@codeCoverageIgnoreEnd
        $data = array(
            'platform_id' => $platform_id,
            'platforms' => $this->Platform_model->get_all('platform_name', 'ASC')
        );
        $this->load->view('admin/project_category/create_page', $data);
    }

    private function _set_rules_create()
    {
        $platform_id_str = implode(',', $this->Platform_model->get_by_status_ids());
        $this->form_validation->set_rules('platform_id', 'Platform', 'trim|required|in_list[' . $platform_id_str . ']');

        $this->form_validation->set_rules('pc_name', 'Name', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('pc_icon', 'Icon', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('pc_description', 'Description'. 'trim|max_length[512]');
    }

    private function _prepare_create_array()
    {
        $project_category = array();
        $project_category['platform_id'] = $this->input->post('platform_id');
        $project_category['pc_name'] = $this->input->post('pc_name');
        $project_category['pc_icon'] = $this->input->post('pc_icon');
        $project_category['pc_description'] = $this->input->post('pc_description');
        return $project_category;
    }

    public function view($pc_id)
    {
        $this->User_log_model->validate_access();
        $project_category = $this->Project_category_model->get_by_id_platform($pc_id);
        if($project_category)
        {
            $this->load->model('Project_model');
            $data = array(
                'project_category' => $project_category,
                'projects' => $this->Project_model->get_by_pc_id($pc_id, 'project_id', 'ASC'),
                'delete_modal_header' => 'Delete Project Category Record',
                'delete_uri' => 'admin/project_category/delete/' . $pc_id
            );
            $this->load->view('admin/project_category/view_page', $data);
        }
        else
        {
            $this->session->set_userdata('message', 'Project Category not found.');
            redirect('admin/project_category/browse');
        }
    }

    public function edit($pc_id)
    {
        $this->User_log_model->validate_access();
        $project_category = $this->Project_category_model->get_by_id($pc_id);
        if($project_category)
        {
            $this->_set_rules_edit();
            if($this->form_validation->run())
            {
                if($this->Project_category_model->update($this->_prepare_edit_array($project_category)))
                {
                    $this->User_log_model->log_message('Project Category updated. | pc_id: ' . $pc_id);
                    $this->session->set_userdata('message', 'Project Category updated.');
                    redirect('admin/project_category/view/' . $pc_id);
                    //@codeCoverageIgnoreStart
                }
                else
                {
                    $this->User_log_model->log_message('Unable to update Project Category. | pc_id: ' . $pc_id);
                    $this->session->set_userdata('message', 'Unable to updated Project Category.');
                }
            }
            //@codeCoverageIgnoreEnd

            $data = array(
                'platforms' => $this->Platform_model->get_all('platform_name', 'ACS'),
                'project_category' => $project_category
            );
            $this->load->view('admin/project_category/edit_page', $data);
        }
        else
        {
            $this->session->set_userdata('message', 'Project Category not found.');
            redirect('admin/project_category/browse');
        }
    }

    private function _set_rules_edit()
    {
        $platform_id_str = implode(',', $this->Platform_model->get_by_status_ids());
        $this->form_validation->set_rules('platform_id', 'Platform', 'trim|required|in_list[' . $platform_id_str . ']');

        $this->form_validation->set_rules('pc_name', 'Name', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('pc_icon', 'Icon', 'trim|required|max_length[512]');
        $this->form_validation->set_rules('pc_description', 'Description', 'trim|max_length[512]');
    }

    private function _prepare_edit_array($project_category)
    {
        $project_category['platform_id'] = $this->input->post('platform_id');
        $project_category['pc_name'] = $this->input->post('pc_name');
        $project_category['pc_icon'] = $this->input->post('pc_icon');
        $project_category['pc_description'] = $this->input->post('pc_description');
        return $project_category;
    }

    public function delete($pc_id)
    {
        $this->User_log_model->validate_access();
        if($this->Project_category_model->get_by_id($pc_id))
        {
            $this->load->model('Project_model');
            if($this->Project_model->get_by_pc_id($pc_id))
            {
                $this->session->set_userdata('message',
                    'Unable to delete Project Category as there are existing Projects associated with it.');
                redirect('admin/project_category/view/' . $pc_id);
                //@codeCoverageIgnoreStart
            }
            //@codeCoverageIgnoreEnd
            else
            {
                if($this->Project_category_model->delete_by_id($pc_id))
                {
                    $this->User_log_model->log_message('Project Category deleted. | pc_id: ' . $pc_id);
                    $this->session->set_userdata('message', 'Project Category deleted.');
                    redirect('admin/project_category/browse');
                    //@codeCoverageIgnoreStart
                }
                else
                {
                    $this->User_log_model->log_message('Unable to delete Project Category. | pc_id: ' . $pc_id);
                    $this->session->set_userdata('message', 'Unable to delete Project Category.');
                    redirect('admin/project_category/view/' . $pc_id);
                }
            }
        }
        //@codeCoverageIgnoreEnd
        else
        {
            $this->session->set_userdata('message', 'Project Category not found.');
            redirect('admin/project_category/browse');
        }
        //@codeCoverageIgnoreStart
    }
    //@codeCoverageIgnoreEnd
	
} // end Project_category controller class