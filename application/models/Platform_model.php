<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Platform_model.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 31 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Platform_model extends CI_Model
{
	public function count_all()
    {
        return $this->db->count_all(TABLE_PLATFORM);
    }

    public function get_all($column='last_updated', $direction='DESC')
    {
        $this->db->order_by($column, $direction);
        $query = $this->db->get(TABLE_PLATFORM);
        return $query->result_array();
    }

    public function get_all_ids()
    {
        $platforms = $this->get_all('platform_id', 'ASC');
        $id_array = array();
        foreach($platforms as $platform)
        {
            $id_array[] = $platform['platform_id'];
        }
        return $id_array;
    }

    public function get_by_status($status='Publish', $column='last_updated', $direction='DESC')
    {
        $this->db->order_by($column, $direction);
        $query = $this->db->get_where(TABLE_PLATFORM, array('platform_status' => $status));
        return $query->result_array();
    }

    public function get_by_status_ids($status='Publish')
    {
        $platforms = $this->get_by_status($status, 'platform_id', 'ASC');
        $id_array = array();
        foreach($platforms as $platform)
        {
            $id_array[] = $platform['platform_id'];
        }
        return $id_array;
    }

    public function get_by_id($platform_id=FALSE)
    {
        if($platform_id)
        {
            $query = $this->db->get_where(TABLE_PLATFORM, array('platform_id' => $platform_id));
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function insert($platform=FALSE)
    {
        if($platform)
        {
            $temp_array = array(
                'platform_name' => $platform['platform_name'],
                'platform_icon' => $platform['platform_icon'],
                'platform_description' => $platform['platform_description'],
                'platform_status' => $platform['platform_status']
            );

            $this->db->set('date_added', now('c'));
            $this->db->set('last_updated', now('c'));
            $this->db->insert(TABLE_PLATFORM, $temp_array);
            return $this->db->insert_id();
        }
        else
        {
            return $platform;
        }
    }

    public function update($platform=FALSE)
    {
        if($platform)
        {
            $temp_array = array(
                'platform_name' => $platform['platform_name'],
                'platform_icon' => $platform['platform_icon'],
                'platform_description' => $platform['platform_description'],
                'platform_status' => $platform['platform_status']
            );

            $this->db->set('last_updated', now('c'));
            $this->db->update(TABLE_PLATFORM, $temp_array, array('platform_id' => $platform['platform_id']));
            return $this->db->affected_rows();
        }
        else
        {
            return FALSE;
        }
    }

    public function delete_by_id($platform_id=FALSE)
    {
        if($platform_id)
        {
            if($this->db->delete(TABLE_PLATFORM, array('platform_id' => $platform_id)))
            {
                if($this->count_all() <= 0)
                {
                    $this->db->truncate(TABLE_PLATFORM);
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

} // end Platform_model class