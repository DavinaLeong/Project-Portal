<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Project_model.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 01 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Project_model extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function count_all()
	{
		return $this->db->count_all(TABLE_PROJECT);
	}

	public function get_all($column='last_updated', $direction='DESC')
	{
		$this->db->order_by($column, $direction);
		$query = $this->db->get(TABLE_PROJECT);
		return $query->result_array();
	}

	public function get_by_id($project_id=FALSE)
	{
		if($project_id)
		{
			$query = $this->db->get_where(TABLE_PROJECT, array('project_id' => $project_id));
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function get_by_id_project_category($project_id=FALSE)
	{
		if($project_id)
		{
			$this->db->select(TABLE_PROJECT . '.*, ' . TABLE_PROJECT_CATEGORY . '.pc_name');
			$this->db->from(TABLE_PROJECT);
			$this->db->join(TABLE_PROJECT_CATEGORY, 'project.pc_id = project_category.pc_id', 'left');
			$this->db->where(TABLE_PROJECT . '.project_id = ', $project_id);

			$query = $this->db->get();
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function get_by_pc_id($pc_id=FALSE,
								 $column='last_updated',
								 $direction='DESC')
	{
		if($pc_id)
		{
			$this->db->order_by($column, $direction);
			$query = $this->db->get_where(TABLE_PROJECT, array('pc_id' => $pc_id));
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function get_by_pc_id_project_category($pc_id=FALSE,
								 $column='last_updated',
								 $direction='DESC')
	{
		if($pc_id)
		{
			$this->db->select(TABLE_PROJECT . '.*, ' . TABLE_PROJECT_CATEGORY . '.pc_name');
			$this->db->from(TABLE_PROJECT);
			$this->db->join(TABLE_PROJECT_CATEGORY, 'project.pc_id = project_category.pc_id', 'left');
			$this->db->where(TABLE_PROJECT . '.pc_id = ', $pc_id);
			$this->db->order_by($column, $direction);

			$query = $this->db->get();
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}

	public function insert($project=FALSE)
	{
		if($project)
		{
			$temp_array = array(
				'pc_id' => $project['pc_id'],
				'project_description' => $project['project_description'],
				'project_status' => $project['project_status']
			);

			$this->db->set('date_added', now('c'));
			$this->db->set('last_updated', now('c'));
			$this->db->insert(TABLE_PROJECT, $temp_array);
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}

	public function update($project=FALSE)
	{
		if($project)
		{
			$temp_array = array(
				'pc_id' => $project['pc_id'],
				'project_description' => $project['project_description'],
				'project_status' => $project['project_status']
			);

			$this->db->set('last_updated', now('c'));
			$this->db->update(TABLE_PROJECT, $temp_array, array('project_id' => $project['project_id']));
			return $this->db->affected_rows();
		}
		else
		{
			return FALSE;
		}
	}

	public function delete_by_id($project_id=FALSE)
	{
		if($project_id)
		{
			if($this->db->delete(TABLE_PROJECT, array('project_id' => $project_id)))
			{
				if($this->count_all() <= 0)
				{
					$this->db->truncate(TABLE_PROJECT);
				}
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	public function _status_array()
	{
		return array(
			'Draft',
			'Publish'
		);
	}
	
} // end Project_model controller class