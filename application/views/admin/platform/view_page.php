<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: view_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 31 Jan 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $platform
 */
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
            <li><a href="<?=site_url('admin/authenticate/start');?>">Home</a></li>
            <li><a href="<?=site_url('admin/platform/browse');?>"><i class="fa fa-desktop fa-fw"></i> Platforms</a></li>
            <li class="active">Platform ID: <?=$platform['platform_id'];?></li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header">View Platform</h1>

                <div class="row">
                    <div class="col-md-10">

                        <form id="form" class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_name">Name <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <p id="platform_name"><?=$platform['platform_name'];?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_description">Description <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <p id="platform_description"><?$platform['platform_description'];?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_icon">Icon <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <p id="platform_icon"><i class="fa <?=$platform['platform_icon'];?> fa-fw"></i> <small><?=$platform['platform_icon'];?></small></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_status">Status <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <p id="platform_status"><?=$platform['platform_status'];?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_status">Date Added <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <p id="date_added"><?=format_dd_mm_yyy_hh_ii_ss($platform['date_added']);?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_status">Last Updated <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <p id="last_updated"><?=format_rfc($platform['last_updated']);?></p>
                                </div>
                            </div>
                        </form>

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
