<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: Page_model.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 08 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/

class Page_model extends CI_Model
{
    public function count_published_links()
    {
		$this->db->get_where(TABLE_LINK, array('link_status' => 'Publish'));
		return $this->db->count_all_results();
    }

	public function get_by_platform_id_links($platform_id=FALSE)
    {
		if($platform_id)
		{
			$this->db->select(TABLE_PLATFORM. '.platform_name, '. TABLE_PLATFORM. '.platform_icon, '. TABLE_PLATFORM. '.platform_description,' .
				TABLE_PROJECT_CATEGORY . '.pc_name,' . TABLE_PROJECT_CATEGORY . '.pc_icon,' .
				TABLE_PROJECT . '.project_name,' . TABLE_PROJECT . '.project_icon,' . TABLE_PROJECT . '.project_description,' .
				TABLE_LINK_CATEGORY . '.lc_name,' . TABLE_LINK_CATEGORY . '.lc_description,' .
				TABLE_LINK . '.*');
			$this->db->from(TABLE_PLATFORM);
			$this->db->join(TABLE_PROJECT_CATEGORY, TABLE_PLATFORM . '.platform_id = ' . TABLE_PROJECT_CATEGORY . '.platform_id', 'left');
			$this->db->join(TABLE_PROJECT, TABLE_PROJECT . '.pc_id = ' . TABLE_PROJECT_CATEGORY . '.pc_id', 'left');
			$this->db->join(TABLE_LINK_CATEGORY, TABLE_LINK_CATEGORY . '.project_id = ' . TABLE_PROJECT . '.project_id', 'left');
			$this->db->join(TABLE_LINK, TABLE_LINK . '.lc_id = ' . TABLE_LINK_CATEGORY . '.lc_id', 'left');

			$this->db->where(TABLE_PLATFORM . '.platform_id = ', $platform_id);
			$this->db->where(TABLE_LINK . '.link_status = ', 'Publish');

			$this->db->order_by(TABLE_PROJECT_CATEGORY . '.pc_id', 'ASC');
			$this->db->order_by(TABLE_PROJECT . '.project_name', 'ASC');
			$this->db->order_by(TABLE_LINK_CATEGORY . '.lc_name', 'ASC');
			$this->db->order_by(TABLE_LINK . '.label', 'ASC');

			$query = $this->db->get();
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
    }

} // end Page_model class