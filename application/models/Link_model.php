<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Link_model.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 06 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Link_model extends CI_Model
{
	public function count_all()
    {
        return $this->db->count_all(TABLE_LINK);
    }

    public function get_all($column='last_updated', $direction='DESC')
    {
        $this->db->order_by($column, $direction);
        $query = $this->db->get(TABLE_LINK);
        return $query->result_array();
    }

    public function get_all_link_category($column='last_updated', $direction='DESC')
    {
        $this->db->select(TABLE_LINK . '.*, ' . TABLE_LINK_CATEGORY . '.lc_name');
        $this->db->from(TABLE_LINK);
        $this->db->join(TABLE_LINK_CATEGORY, TABLE_LINK . '.lc_id = ' . TABLE_LINK_CATEGORY . '.lc_id', 'left');
        $this->db->order_by($column, $direction);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_by_id($link_id=FALSE)
    {
        if($link_id)
        {
            $query = $this->db->get_where(TABLE_LINK, array('link_id' => $link_id));
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_by_id_link_category_project($link_id=FALSE)
    {
        $this->db->select(TABLE_LINK . '.*, ' .
            TABLE_LINK_CATEGORY . '.project_id, ' . TABLE_LINK_CATEGORY . '.lc_name, ' .
            TABLE_PROJECT . '.project_name');
        $this->db->from(TABLE_LINK);
        $this->db->join(TABLE_LINK_CATEGORY, TABLE_LINK . '.lc_id = ' . TABLE_LINK_CATEGORY . '.lc_id', 'left');
        $this->db->join(TABLE_PROJECT, TABLE_LINK_CATEGORY . '.project_id = ' . TABLE_PROJECT . '.project_id', 'left');
        $this->db->where(TABLE_LINK . '.link_id = ', $link_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_by_status($status='Publish', $column='last_updated', $direction='DESC')
    {
        $this->db->order_by($column, $direction);
        $query = $this->db->get_where(TABLE_LINK, array('link_status' => $status));
        return $query->result_array();
    }

    public function get_by_status_ids($status)
    {
        $links = $this->get_by_status($status, 'link_id', 'ASC');
        $id_array = array();
        foreach($links as $link)
        {
            $id_array[] = $link['link_id'];
        }
        return $id_array;
    }

    public function get_by_lc_id($lc_id=FALSE, $column='last_updated', $direction='DESC')
    {
        if($lc_id)
        {
            $this->db->order_by($column, $direction);
            $query = $this->db->get_where(TABLE_LINK, array('lc_id' => $lc_id));
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_links_by_project_id($project_id=FALSE, $column='label', $direction='ASC')
    {
        if($project_id)
        {
            $this->db->select(TABLE_LINK . '.*, ' . TABLE_LINK_CATEGORY . '.lc_name');
            $this->db->from(TABLE_PROJECT);
            $this->db->join(TABLE_LINK_CATEGORY, TABLE_PROJECT . '.project_id = ' . TABLE_LINK_CATEGORY . '.project_id', 'left');
            $this->db->join(TABLE_LINK, TABLE_LINK_CATEGORY . '.lc_id = ' . TABLE_LINK . '.lc_id', 'left');
            $this->db->where(TABLE_PROJECT . '.project_id = ' . $project_id);
            $this->db->order_by($column, $direction);

            $query = $this->db->get();
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_links_by_project_id_status($project_id=FALSE, $status='Publish',
                                                   $column='label', $direction='ASC')
    {
        if($project_id && $status)
        {
            $this->db->select(TABLE_LINK . '*, ' . TABLE_LINK_CATEGORY . '.lc_name');
            $this->db->from(TABLE_PROJECT);
            $this->db->join(TABLE_LINK_CATEGORY, TABLE_PROJECT . '.project_id = ' . TABLE_LINK_CATEGORY . '.project_id', 'left');
            $this->db->join(TABLE_LINK, TABLE_LINK_CATEGORY . '.lc_id = ' . TABLE_LINK . '.lc_id', 'left');
            $this->db->where(TABLE_PROJECT . '.project_id = ' . $project_id);
            $this->db->where(TABLE_LINK . '.link_status = ', $status);
            $this->db->order_by($column, $direction);

            $query = $this->db->get();
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function insert($link=FALSE)
    {
        if($link)
        {
            $temp_array = array(
                'lc_id' => $link['lc_id'],
                'label' => $link['label'],
                'url' => $link['url'],
                'use_https' => $link['use_https'],
                'link_status' => $link['link_status']
            );

            $this->db->set('date_added', now('c'));
            $this->db->set('last_updated', now('c'));
            $this->db->insert(TABLE_LINK, $temp_array);
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    public function update($link=FALSE)
    {
        if($link)
        {
            $temp_array = array(
                'lc_id' => $link['lc_id'],
                'label' => $link['label'],
                'url' => $link['url'],
                'use_https' => $link['use_https'],
                'link_status' => $link['link_status']
            );

            $this->db->set('last_updated', now('c'));
            $this->db->update(TABLE_LINK, $temp_array, array('link_id' => $link['link_id']));
            return $this->db->affected_rows();
        }
        else
        {
            return FALSE;
        }
    }

    public function delete_by_id($link_id=FALSE)
    {
        if($link_id)
        {
            $this->db->delete(TABLE_LINK, array('link_id' => $link_id));
            if($this->count_all() <= 0)
            {
                $this->db->truncate(TABLE_LINK);
            }
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function delete_by_lc_id($lc_id=FALSE)
    {
        if($lc_id)
        {
            $this->db->delete(TABLE_LINK, array('lc_id' => $lc_id));
            if($this->count_all() <= 0)
            {
                $this->db->truncate(TABLE_LINK);
            }
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function _status_array()
    {
        return array(
            'Publish',
            'Draft'
        );
    }

} // end Link class