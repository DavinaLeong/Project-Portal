<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: 20170128160323_default_admin.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 28 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/* Migration version:
 * 28 Jan 2017, 16:03PM
 * 20170128160323
 */
class Migration_Default_admin extends CI_Migration
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
		$password_hash = password_hash('password', PASSWORD_DEFAULT);
		$today = today('c');
		$sql = "
			INSERT INTO `user` (`username`, `name`, `password_hash`, `access`, `status`)
			VALUES('admin', 'Default Admin', '" . $password_hash . "', 'A', 'Activated');
		";
		return $sql;
	}

	private function _down_script()
	{
		$sql = "
			DELETE FROM user WHERE username = 'admin';
		";
		return $sql;
	}

} // end 20170126210232_init_tables class
