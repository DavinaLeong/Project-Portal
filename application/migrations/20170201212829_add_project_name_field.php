<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: 20170201212829_add_project_name_field.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 01 Feb 2017
	
	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]
	
***********************************************************************************/
/* Migration version: 
 * 01 Feb 2017, 09:28PM
 * 20170201212829
 */
class Migration_Add_project_name_field extends CI_Migration
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
			ALTER TABLE `project` ADD COLUMN `project_name` VARCHAR(512) NOT NULL;
		";
		return $sql;
	}
	
	private function _down_script()
	{
		$sql = "
			ALTER TABLE `project` DROP COLUMN `project_name`;
		";
		return $sql;
	}
	
} // end 20170201212829_add_project_name_field class