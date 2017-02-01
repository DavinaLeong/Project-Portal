<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Project_category_model.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 01 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Project_category_model extends CI_Model
{
	public function count_all()
    {
        return $this->db->count_all(TABLE_PROJECT_CATEGORY);
    }

    public function get_all($column='last_updated', $direction="DESC")
    {
        $this->db->order_by($column, $direction);
        $query = $this->db->get(TABLE_PROJECT_CATEGORY);
        return $query->result_array();
    }

    public function get_by_id($pc_id=FALSE)
    {
        if($pc_id)
        {
            $query = $this->db->get(TABLE_PROJECT_CATEGORY, array('pc_id' => $pc_id));
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function insert($pc=FALSE)
    {
        if($pc)
        {
            $temp_array = array(
                'pc_name' => $pc['pc_name'],
                'pc_description' => $pc['pc_description']
            );

            $this->db->set('date_added', now('c'));
            $this->db->set('last_updated', now('c'));
            $this->db->insert(TABLE_PROJECT_CATEGORY, $temp_array);
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    public function update($pc=FALSE)
    {
        if($pc)
        {
            $temp_array = array(
                'pc_name' => $pc['pc_name'],
                'pc_description' => $pc['pc_description']
            );

            $this->db->set('last_updated', now('c'));
            $this->db->update(TABLE_PROJECT_CATEGORY, $temp_array, array('pc_id' => $pc['pc_id']));
            return $this->db->affected_rows();
        }
        else
        {
            return FALSE;
        }
    }

    public function delete_by_id($pc_id=FALSE)
    {
        if($pc_id)
        {
            if($var = $this->db->delete(TABLE_PROJECT_CATEGORY, array('pc_id' => $pc_id)))
            {
                var_dump($var);
                if($this->count_all() <= 0)
                {
                    $this->db->truncate(TABLE_PROJECT_CATEGORY);
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

} // end Project_category_model class