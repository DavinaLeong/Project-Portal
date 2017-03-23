<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: 20170209092304_change_pc_affilate.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 09 Feb 2017
	
	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]
	
***********************************************************************************/
/* Migration version: 
 * 09 Feb 2017, 09:23AM
 * 20170209092304
 */
class Migration_Change_pc_affilate extends CI_Migration
{
    // Public Functions ----------------------------------------------------------------
    public function up()
    {
        $this->load->model('Migration_model');
        $output = $this->Migration_model->run_parsed_sql($this->_up_script())['output_str'];

        if(ENVIRONMENT !== 'testing')
        {
            echo '<h1>Migration: Init Tables</h1>';
            echo '<hr/>';
            echo '<p>Running Up Script...</p>';
            echo '<p style="text-align: center;">- start of script -</p>';
            echo '<div style="border: thin solid #ddd; border-radius: 2px; background: #eee; padding:5px;"><code>';
            echo $output;
            echo '</code></div>';
        }
    }

    public function down()
    {
        $this->load->model('Migration_model');
        $output = $this->Migration_model->run_parsed_sql($this->_down_script())['output_str'];

        if(ENVIRONMENT !== 'testing')
        {
            echo '<h1>Migration: Init Tables</h1>';
            echo '<hr/>';
            echo '<p>Running Up Script...</p>';
            echo '<p style="text-align: center;">- start of script -</p>';
            echo '<div style="border: thin solid #ddd; border-radius: 2px; background: #eee; padding:5px;"><code>';
            echo $output;
            echo '</code></div>';
        }
    }
	
	// Private Functions ---------------------------------------------------------------
	private function _up_script()
	{
		$sql = "
			ALTER TABLE `project_category` ADD COlUMN `platform_id` INT(4) UNSIGNED NOT NULL;

			ALTER TABLE `project` DROP COLUMN `platform_id`;
		";
		return $sql;
	}
	
	private function _down_script()
	{
		$sql = "
			ALTER TABLE `project` ADD COlUMN `platform_id` INT(4) UNSIGNED NOT NULL;

			ALTER TABLE `project_category` DROP COLUMN `platform_id`;
		";
		return $sql;
	}
	
} // end 20170209092304_change_pc_affilate class