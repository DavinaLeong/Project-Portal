<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: 20170206164602_add_use_https_field_to_link_table.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 06 Feb 2017
	
	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]
	
***********************************************************************************/
/* Migration version: 
 * 06 Feb 2017, 04:46PM
 * 20170206164602
 */
class Migration_Add_use_https_field_to_link_table extends CI_Migration
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
			ALTER TABLE `link` ADD COLUMN `use_https` INT(1) UNSIGNED NOT NULL DEFAULT 0;
		";
		return $sql;
	}
	
	private function _down_script()
	{
		$sql = "
			ALTER TABLE `link` DROP COLUMN `use_https`;
		";
		return $sql;
	}
	
} // end 20170206164602_add_use_https_field_to_link_table class