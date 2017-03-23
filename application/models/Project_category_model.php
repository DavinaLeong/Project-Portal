<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Project_category_model.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 01 Feb 2017

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

    public function get_all($column='last_updated', $direction='DESC')
    {
        $this->db->order_by($column, $direction);
        $query = $this->db->get(TABLE_PROJECT_CATEGORY);
        return $query->result_array();
    }

    public function get_all_platform($column='last_updated', $direction='DESC')
    {
        $this->db->select(TABLE_PROJECT_CATEGORY . '.*, ' . TABLE_PLATFORM . '.platform_name, ' . TABLE_PLATFORM . '.platform_icon');
        $this->db->from(TABLE_PROJECT_CATEGORY);
        $this->db->join(TABLE_PLATFORM, TABLE_PLATFORM . '.platform_id = ' . TABLE_PROJECT_CATEGORY . '.platform_id', 'left');
        $this->db->order_by($column, $direction);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_ids()
    {
        $projects = $this->get_all('pc_name', 'ASC');
        $id_array = array();
        foreach($projects as $project)
        {
            $id_array[] = $project['pc_id'];
        }
        return $id_array;
    }

    public function get_by_id($pc_id=FALSE)
    {
        if($pc_id)
        {
            $query = $this->db->get_where(TABLE_PROJECT_CATEGORY, array('pc_id' => $pc_id));
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_by_id_platform($pc_id=FALSE)
    {
        if($pc_id)
        {
            $this->db->select(TABLE_PROJECT_CATEGORY . '.*, ' . TABLE_PLATFORM . '.platform_name, ' . TABLE_PLATFORM . '.platform_icon');
            $this->db->from(TABLE_PROJECT_CATEGORY);
            $this->db->join(TABLE_PLATFORM, TABLE_PLATFORM . '.platform_id = ' . TABLE_PROJECT_CATEGORY . '.platform_id', 'left');
            $this->db->where(TABLE_PROJECT_CATEGORY . '.pc_id = ', $pc_id);

            $query = $this->db->get();
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_by_platform_id($platform_id=FALSE, $column='last_updated', $direction='DESC')
    {
        if($platform_id)
        {
            $this->db->order_by($column, $direction);
            $query = $this->db->get_where(TABLE_PROJECT_CATEGORY, array('platform_id' => $platform_id));
            return $query->result_array();
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
                'platform_id' => $pc['platform_id'],
                'pc_name' => $pc['pc_name'],
                'pc_icon' => $pc['pc_icon'],
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
                'platform_id' => $pc['platform_id'],
                'pc_name' => $pc['pc_name'],
                'pc_icon' => $pc['pc_icon'],
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
                if($this->count_all() <= 0)
                {
                    //@codeCoverageIgnoreStart
                    $this->db->truncate(TABLE_PROJECT_CATEGORY);
                }
                //@codeCoverageIgnoreEnd
                return TRUE;
            }
            //@codeCoverageIgnoreStart
            else
            {
                return FALSE;
            }
            //@codeCoverageIgnoreEnd
        }
        else
        {
            return FALSE;
        }
    }

    public function delete_by_platform_id($platform_id=FALSE)
    {
        if($platform_id)
        {
            if($var = $this->db->delete(TABLE_PROJECT_CATEGORY, array('platform_id' => $platform_id)))
            {
                if($this->count_all() <= 0)
                {
                    //@codeCoverageIgnoreStart
                    $this->db->truncate(TABLE_PROJECT_CATEGORY);
                }
                //@codeCoverageIgnoreEnd
                return TRUE;
            }
            //@codeCoverageIgnoreStart
            else
            {
                return FALSE;
            }
            //@codeCoverageIgnoreEnd
        }
        else
        {
            return FALSE;
        }
    }

} // end Project_category_model class