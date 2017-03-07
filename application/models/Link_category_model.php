<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Link_category_model.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 04 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Link_category_model extends CI_Model
{
	public function count_all()
    {
        return $this->db->count_all(TABLE_LINK_CATEGORY);
    }

    public function get_all($column='last_updated', $direction='DESC')
    {
        $this->db->order_by($column, $direction);
        $query = $this->db->get(TABLE_LINK_CATEGORY);
        return $query->result_array();
    }

    public function get_all_project($column='last_updated', $direction='DESC')
    {
        $this->db->select(TABLE_LINK_CATEGORY . '.*, ' . TABLE_PROJECT . '.project_name');
        $this->db->from(TABLE_LINK_CATEGORY);
        $this->db->join(TABLE_PROJECT, TABLE_LINK_CATEGORY . '.project_id = ' . TABLE_PROJECT . '.project_id', 'left');
        $this->db->order_by($column, $direction);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_project_platform($column='last_updated', $direction='DESC')
    {
        $this->db->select(TABLE_LINK_CATEGORY . '.*, ' .
            TABLE_PROJECT . '.project_name, ' . TABLE_PROJECT . '.project_icon, ' .
            TABLE_PLATFORM . '.platform_name, ' . TABLE_PLATFORM . '.platform_icon');
        $this->db->from(TABLE_LINK_CATEGORY);
        $this->db->join(TABLE_PROJECT, TABLE_PROJECT . '.project_id = ' . TABLE_LINK_CATEGORY . '.project_id', 'left');
        $this->db->join(TABLE_PROJECT_CATEGORY, TABLE_PROJECT_CATEGORY . '.pc_id = ' . TABLE_PROJECT . '.pc_id', 'left');
        $this->db->join(TABLE_PLATFORM, TABLE_PLATFORM . '.platform_id = ' . TABLE_PROJECT_CATEGORY . '.platform_id', 'left');
        $this->db->order_by($column, $direction);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_ids()
    {
        $link_categories = $this->get_all('lc_name', 'ASC');
        $id_array = array();
        foreach($link_categories as $link_category)
        {
            $id_array[] = $link_category['lc_id'];
        }
        return $id_array;
    }

    public function get_by_id($lc_id=FALSE)
    {
        if($lc_id)
        {
            $quest = $this->db->get_where(TABLE_LINK_CATEGORY, array('lc_id' => $lc_id));
            return $quest->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_by_id_project($lc_id=FALSE)
    {
        if($lc_id)
        {
            $this->db->select(TABLE_LINK_CATEGORY . '.*, ' .
                TABLE_PROJECT . '.project_name, ' . TABLE_PROJECT . '.project_icon, ');
            $this->db->from(TABLE_LINK_CATEGORY);
            $this->db->join(TABLE_PROJECT, TABLE_LINK_CATEGORY . '.project_id = ' . TABLE_PROJECT . '.project_id', 'left');
            $this->db->where(TABLE_LINK_CATEGORY . '.lc_id = ', $lc_id);
            $query = $this->db->get();
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_by_id_project_platform($lc_id=FALSE)
    {
        if($lc_id)
        {
            $this->db->select(TABLE_LINK_CATEGORY . '.*, ' .
                TABLE_PROJECT . '.project_name, ' . TABLE_PROJECT . '.project_icon, ' .
                TABLE_PLATFORM . '.platform_name, ' . TABLE_PLATFORM . '.platform_icon');
            $this->db->from(TABLE_LINK_CATEGORY);
            $this->db->join(TABLE_PROJECT, TABLE_PROJECT . '.project_id = ' . TABLE_LINK_CATEGORY . '.project_id', 'left');
            $this->db->join(TABLE_PROJECT_CATEGORY, TABLE_PROJECT_CATEGORY . '.pc_id = ' . TABLE_PROJECT . '.pc_id', 'left');
            $this->db->join(TABLE_PLATFORM, TABLE_PLATFORM . '.platform_id = ' . TABLE_PROJECT_CATEGORY . '.platform_id', 'left');
            $this->db->where(TABLE_LINK_CATEGORY . '.lc_id = ', $lc_id);

            $query = $this->db->get();
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_by_project_id($project_id, $column='last_updated', $direction='DESC')
    {
        if($project_id)
        {
            $this->db->order_by($column, $direction);
            $query = $this->db->get_where(TABLE_LINK_CATEGORY, array('project_id' => $project_id));
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_by_project_id_lc_name($project_id=FALSE, $lc_name=FALSE)
    {
        if($project_id && $lc_name)
        {
            $query = $this->db->get_where(TABLE_LINK_CATEGORY, array('project_id' => $project_id, 'lc_name' => $lc_name));
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function insert($link_category=FALSE)
    {
        if($link_category)
        {
            $temp_array = array(
                'project_id' => $link_category['project_id'],
                'lc_name' => $link_category['lc_name'],
                'lc_description' => $link_category['lc_description']
            );

            $this->db->set('date_added', now('c'));
            $this->db->set('last_updated', now('c'));
            $this->db->insert(TABLE_LINK_CATEGORY, $temp_array);
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    public function update($link_category=FALSE)
    {
        if($link_category)
        {
            $temp_array = array(
                'project_id' => $link_category['project_id'],
                'lc_name' => $link_category['lc_name'],
                'lc_description' => $link_category['lc_description']
            );

            $this->db->set('last_updated', now('c'));
            $this->db->update(TABLE_LINK_CATEGORY, $temp_array, array('lc_id' => $link_category['lc_id']));
            return $this->db->affected_rows();
        }
        else
        {
            return FALSE;
        }
    }

    public function delete_by_id($lc_id=FALSE)
    {
        if($lc_id)
        {
            $this->db->delete(TABLE_LINK_CATEGORY, array('lc_id' => $lc_id));
            if($this->count_all() <= 0)
            {
                $this->db->truncate(TABLE_LINK_CATEGORY);
            }
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function delete_by_project_id($project_id=FALSE)
    {
        if($project_id)
        {
            $this->db->delete(TABLE_LINK_CATEGORY, array('project_id' => $project_id));
            if($this->count_all() <= 0)
            {
                //@codeCoverageIgnoreStart
                $this->db->truncate(TABLE_LINK_CATEGORY);
            }
            //@codeCoverageIgnoreEnd
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

} // end Link_category_model class