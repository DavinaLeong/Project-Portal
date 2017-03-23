<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: User_model.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 27 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class User_model extends CI_Model
{
    public function count_all()
    {
        return $this->db->count_all(TABLE_USER);
    }

	public function get_all($column='last_updated', $direction='DESC')
    {
        $this->db->order_by($column, $direction);
        $query = $this->db->get(TABLE_USER);
        return $query->result_array();
    }

    public function get_by_user_id($user_id=FALSE)
    {
        if($user_id)
        {
            $query = $this->db->get_where(TABLE_USER, array('user_id' => $user_id));
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_by_username($username=FALSE)
    {
        if($username)
        {
            $query = $this->db->get_where(TABLE_USER, array('username' => $username));
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function insert($user=FALSE)
    {
        if($user)
        {
            $temp_array = array(
                'username' => $user['username'],
                'name' => $user['name'],
                'password_hash' => $user['password_hash'],
                'access' => $user['access'],
                'status' => $user['status']
            );

            $this->db->set('date_added', now('c'));
            $this->db->set('last_updated', now('c'));
            $this->db->insert(TABLE_USER, $temp_array);
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    public function update($user=FALSE)
    {
        if($user)
        {
            $temp_array = array(
                'username' => $user['username'],
                'name' => $user['name'],
                'password_hash' => $user['password_hash'],
                'access' => $user['access'],
                'status' => $user['status']
            );

            $this->db->set('last_updated', now('c'));
            $this->db->update(TABLE_USER, $temp_array, array('user_id' => $user['user_id']));
            return $this->db->affected_rows();
        }
        else
        {
            return FALSE;
        }
    }

    public function _access_array()
    {
        return array(
            'Administrator' => 'A',
            'Manager' => 'M',
            'User' => 'U'
        );
    }

    public function _status_array()
    {
        return array(
            'Activated',
            'Deactivated'
        );
    }

} // end User_model class
