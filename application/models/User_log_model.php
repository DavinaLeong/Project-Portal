<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: User_log_model.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 26 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
//@codeCoverageIgnoreStart
class User_log_model extends CI_Model
{
    public function get_all()
    {
        $this->db->order_by('timestamp', 'DESC');
        $query = $this->db->get(TABLE_USER_LOG);
        return $query->result_array();
    }

    public function log_message($message=FALSE)
    {
        if(isset($message))
        {
            $temp_array = array(
                'user_id' => $this->session->userdata('user_id'),
                'message' => $message
            );

            $now = now();
            $this->db->set('timestamp', now('c'));
            $this->db->insert(TABLE_USER_LOG, $temp_array);
            return $this->db->insert_id();
        }
        else
        {
            return FALSE;
        }
    }

    public function process_access_validation($required=FALSE, $session=FALSE)
    {
        if(isset($required) && isset($session))
        {
            $valid = FALSE;
            for($i = 0; $i < strlen($session); ++$i)
            {
                if(strpos($required, substr($session, $i, 1)) !== FALSE)
                {
                    $valid = TRUE;
                    break;
                }
            }
            return $valid;
        }
        else
        {
            return FALSE;
        }
    }

    public function validate_access($access_values='A')
    {
        if($this->process_access_validation($access_values, $this->session->userdata('access')) == FALSE)
        {
            $this->session->set_userdata('message', 'This user has invalid access rights to requested page.');
            redirect('admin/authenticate/logout');
        }
    }

    public function get_by_user_id($user_id=FALSE)
    {
        if($user_id)
        {
            $query = $this->db->get_where($user_id);
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }

} // end User_log_model class
//@codeCoverageIgnoreEnd
