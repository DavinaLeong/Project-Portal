<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: 20170201133725_insert_platform_records.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 01 Feb 2017
	
	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]
	
***********************************************************************************/
/* Migration version: 
 * 01 Feb 2017, 01:37PM
 * 20170201133725
 */
class Migration_Insert_platform_records extends CI_Migration
{
	// Public Functions ----------------------------------------------------------------
	public function up()
	{
        $this->load->model('Migration_model');
        echo '<h1>Migration: Insert Platform Records</h1>';
        echo '<hr/>';
        echo '<p>Running Up Script...</p>';
        echo '<p style="text-align: center;">- start of script -</p>';
        echo '<div style="border: thin solid #ddd; border-radius: 2px; background: #eee; padding:5px;"><code>';
        echo $this->Migration_model->run_parsed_sql($this->_up_script())['output_str'];
        echo '</code></div>';
	}
	
	public function down()
	{
        $this->load->model('Migration_model');
        echo '<h1>Migration: Insert Platform Records</h1>';
        echo '<hr/>';
        echo '<p>Running Down Script...</p>';
        echo '<p style="text-align: center;">- start of script -</p>';
        echo '<div style="border: thin solid #ddd; border-radius: 2px; background: #eee; padding:5px;"><code>';
        echo $this->Migration_model->run_parsed_sql($this->_down_script())['output_str'];
        echo '</code></div>';
	}
	
	// Private Functions ---------------------------------------------------------------
	private function _up_script()
	{
		$sql = "
			INSERT INTO `platform` (`platform_id`, `platform_name`, `platform_icon`, `platform_description`,
			`date_added`, `last_updated`, `platform_status`)
			VALUES
                (1, 'Acer Predator', 'fa-desktop', 'Main desktop computer', '2017-02-01 12:05:36', '2017-02-01 12:19:36', 'Publish'),
                (2, 'Lenovo Laptop 20378', 'fa-laptop', 'Lenovo Work Laptop', '2017-02-01 13:03:24', '2017-02-01 13:03:24', 'Publish'),
                (3, 'Surface Pro', 'fa-tablet', 'Microsoft table Surface Pro', '2017-02-01 13:14:34', '2017-02-01 13:14:34', 'Publish');
		";
		return $sql;
	}
	
	private function _down_script()
	{
		$sql = "
			TRUNCATE TABLE `platform`;
		";
		return $sql;
	}
	
} // end 20170201133725_insert_platform_records class