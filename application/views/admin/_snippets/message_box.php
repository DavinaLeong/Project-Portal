<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: message_box.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 27 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
?>
<?php if($this->session->userdata('message')):?>
    <div id="message_box" class="alert alert-info" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
        <i class="fa fa-info-circle fa-fw"></i> <?= $this->session->userdata('message') ?>
    </div>
    <?php $this->session->unset_userdata('message') ?>
<?php endif;?>