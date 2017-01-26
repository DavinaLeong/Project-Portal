<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Migration_model.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 26 Jan 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Migration_model extends CI_Model
{
	public function run_sql($sql, $success_msg='Success', $error_msg='Error')
    {
        if($this->db->query($sql))
        {
            return $success_msg;
        }
        else
        {
            return $error_msg;
        }
    }

    public function reset()
    {
        $this->load->library('migration');
        $this->migration->version('20170126182500');
        $this->migration->current();
    }

    public function get_version()
    {
        $query = $this->db->get('migrations');
        return $query->row_array()['version'];
    }

} // end Migration_model class