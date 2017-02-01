<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: start_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 27 Jan 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
?><!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('admin/_snippets/meta'); ?>
<?php $this->load->view('admin/_snippets/head_resources'); ?>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('admin/_snippets/navbar'); ?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="active">Home</li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-home fa-fw"></i> Welcome to <span class="text-primary"><?=ADMIN_SITE_NAME;?></span></h1>

                <p class="lead">You are logged in as <span class="text-info"><?=$this->session->userdata('name');?></span>.</p>
                <?php $this->load->view('admin/_snippets/message_box'); ?>

                <div class="row">
                    <div class="col-md-2 text-center">
                        <img src="<?=RESOURCES_FOLDER;?>pp/images/pp_logo.png" alt="Site Logo" />
                    </div>
                    <div class="col-md-10">
                        <h2>About</h2>
                        <ul>
                            <li>This admin panel provides a user friendly interface in handling the database.</li>
                            <li>It also manages how the Project Links are displayed on the Project Portal page.</li>
                            <li>This particular admin panel does not have a User module.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('admin/_snippets/footer'); ?>
    </div>
</div>
</div>
<?php $this->load->view('admin/_snippets/body_resources') ;?>
</body>
</html>
