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
                <h1 class="page-header">View Platform&nbsp;
                    <div class="btn-group">
                        <button id="action_btn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-gavel fa-fw"></i> Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a id="edit_record" href="<?=site_url('admin/platform/edit/' . $platform['platform_id']);?>"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Record</a></li>
                            <li><a id="delete_record" class="clickable" data-toggle="modal" data-target="#delete_modal"><i class="fa fa-trash fa-fw"></i> Delete Record</a></li>
                        </ul>
                    </div>
                </h1>

                <div class="row">
                    <div class="col-md-10">

                        <form id="form" class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_name">Name</label>
                                <div class="col-md-10">
                                    <p id="platform_name" class="form-control-static"><?=$platform['platform_name'];?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_description">Description</label>
                                <div class="col-md-10">
                                    <p id="platform_description" class="form-control-static"><?$platform['platform_description'];?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_icon">Icon</label>
                                <div class="col-md-10">
                                    <p id="platform_icon" class="form-control-static"><i class="fa <?=$platform['platform_icon'];?> fa-fw"></i> <small>(<?=$platform['platform_icon'];?>)</small></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_status">Status</label>
                                <div class="col-md-10">
                                    <p id="platform_status" class="form-control-static"><?=$platform['platform_status'];?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_status">Date Added</label>
                                <div class="col-md-10">
                                    <p id="date_added" class="form-control-static"><?=format_dd_mm_yyy_hh_ii_ss($platform['date_added']);?></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-2" for="platform_status">Last Updated</label>
                                <div class="col-md-10">
                                    <p id="last_updated" class="form-control-static"><?=format_rfc($platform['last_updated']);?></p>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
        <?php $this->load->view('admin/_snippets/generic_delete_modal'); ?>
        <?php $this->load->view('admin/_snippets/footer'); ?>
    </div>
</div>
</div>
<?php $this->load->view('admin/_snippets/body_resources') ;?>
</body>
</html>
