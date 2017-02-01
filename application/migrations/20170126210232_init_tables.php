<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: 20170126210232_init_tables.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 26 Jan 2017
	
	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]
	
***********************************************************************************/
/* Migration version: 
 * 26 Jan 2017, 09:02PM
 * 20170126210232
 */
class Migration_Init_tables extends CI_Migration
{
	// Public Functions ----------------------------------------------------------------
	public function up()
	{
		$this->load->model('Migration_model');
		echo '<h1>Migration: Init Tables</h1>';
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
		echo '<h1>Migration: Init Tables</h1>';
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
			DROP TABLE IF EXISTS `ci_sessions`;
			CREATE TABLE `ci_sessions` (
				`id` varchar(40) NOT NULL,
				`ip_address` varchar(45) NOT NULL,
				`timestamp` int(10) unsigned NOT NULL DEFAULT '0',
				`data` blob NOT NULL,
				KEY `ci_sessions_timestamp` (`timestamp`)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;

			DROP TABLE IF EXISTS `user`;
			CREATE TABLE `user` (
				`user_id` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
				`username` VARCHAR(512) NOT NULL,
				`name` VARCHAR(512) NOT NULL,
				`password_hash` VARCHAR(512) NOT NULL,
				`access` VARCHAR(8) NOT NULL,
				`status` VARCHAR(512) NOT NULL,
				`date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				`last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

				PRIMARY KEY(`user_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

			DROP TABLE IF EXISTS `user_log`;
			CREATE TABLE `user_log` (
				`ul_id` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
				`user_id` INT(4) UNSIGNED NOT NULL,
				`message` VARCHAR(512) NOT NULL,
				`timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

				PRIMARY KEY(`ul_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

			DROP TABLE IF EXISTS `platform`;
			CREATE TABLE `platform` (
				`platform_id` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
				`platform_name` VARCHAR(512) NOT NULL,
				`platform_icon` VARCHAR(512) NOT NULL,
				`platform_description` VARCHAR(512) NOT NULL,
				`date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				`last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

				PRIMARY KEY(`platform_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

			DROP TABLE IF EXISTS `project_category`;
			CREATE TABLE `project_category` (
				`pc_id` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
				`pc_name` VARCHAR(512) NOT NULL,
				`pc_description` VARCHAR(512),
				`date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				`last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

				PRIMARY KEY(`pc_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

			DROP TABLE IF EXISTS `project`;
			CREATE TABLE `project` (
				`project_id` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
				`pc_id` INT(4) UNSIGNED NOT NULL,
				`project_description` VARCHAR(512),
				`date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				`last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

				PRIMARY KEY(`project_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

			DROP TABLE IF EXISTS `link_category`;
			CREATE TABLE `link_category` (
				`lc_id` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
				`project_id` INT(4) UNSIGNED NOT NULL,
				`lc_name` VARCHAR(512) NOT NULL,
				`lc_description` VARCHAR(512) NOT NULL,
				`date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				`last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

				PRIMARY KEY(`lc_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

			DROP TABLE IF EXISTS `link`;
			CREATE TABLE `link` (
				`link_id` INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
				`label` VARCHAR(512) NOT NULL,
				`url` VARCHAR(512) NOT NULL,
				`date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				`last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

				PRIMARY KEY(`link_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
		";
		return $sql;
	}
	
	private function _down_script()
	{
		$sql = "
			DROP TABLE IF EXISTS `ci_sessions`;

			DROP TABLE IF EXISTS `user`;

			DROP TABLE IF EXISTS `user_log`;

			DROP TABLE IF EXISTS `platform`;

			DROP TABLE IF EXISTS `project_category`;

			DROP TABLE IF EXISTS `project`;

			DROP TABLE IF EXISTS `link_category`;

			DROP TABLE IF EXISTS `link`;
		";
		return $sql;
	}
	
} // end 20170126210232_init_tables class