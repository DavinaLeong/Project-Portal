<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: no_records_box.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 01 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $create_uri
 */
?><div id="no_records_box" class="alert alert-warning" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <i class="fa fa-exclamation fa-fw"></i> No records found. <a href="<?=site_url($create_uri);?>">Create new record</a>.
</div>