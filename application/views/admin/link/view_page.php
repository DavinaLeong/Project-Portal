<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: view_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 06 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $link
 */
$output_url = ($link['use_https'] == 1 ? 'https' : 'http') . '://' . $link['url'];
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
            <li><a href="<?=site_url('admin/link/browse');?>">Links</a></li>
            <li class="active">Link ID: <?=$link['link_id'];?></li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-eye fa-fw"></i> View Link&nbsp;
                    <div class="btn-group">
                        <button id="action_btn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-gavel fa-fw"></i> Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a id="edit_record" href="<?=site_url('admin/link/edit/' . $link['link_id']);?>"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Record</a></li>
                            <li><a id="delete_record" class="clickable" data-toggle="modal" data-target="#delete_modal"><i class="fa fa-trash fa-fw"></i> Delete Record</a></li>
                        </ul>
                    </div>
                </h1>

                <?php $this->load->view('admin/_snippets/message_box'); ?>

                <div class="row">
                    <div class="col-md-10">

                        <form id="form" class="form-horizontal">
                            <fieldset>
                                <legend>Record Details</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2">Category</label>
                                    <div class="col-md-10">
                                        <p class="form-control-static">
                                            <a id="lc_name" href="<?=site_url('admin/link_category/view/' . $link['lc_id']);?>" target="_blank" data-toggle="tooltip" title="Link Category"><?=$link['lc_name'];?></a> (<a id="project_name" href="<?=site_url('admin/project/view/' . $link['project_id']);?>" target="_blank" data-toggle="tooltip" title="Project"><?=$link['project_name'];?></a>)
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="label">Label</label>
                                    <div class="col-md-10">
                                        <p id="label" class="form-control-static"><?=$link['label'];?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="url">URL</label>
                                    <div class="col-md-10">
                                        <p id="url" class="form-control-static"><a href="<?=$output_url;?>" target="_blank"><?=$link['url'];?></a><br/>
                                        <small>Output URL: <?=$output_url;?></small></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="use_https">Use HTTPS</label>
                                    <div class="col-md-10">
                                        <p id="use_https" class="form-control-static"><?= $link['use_https'] == 1 ? 'Yes' : 'No';?></p>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Admin</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="link_status">Status</label>
                                    <div class="col-md-10">
                                        <p id="link_status" class="form-control-static"><span class="label label-default label-<?=strtolower($link['link_status']);?>"><?=$link['link_status'];?></span></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="link_status">Date Added</label>
                                    <div class="col-md-10">
                                        <p id="date_added" class="form-control-static"><?=format_dd_mm_yyyy_hh_ii_ss($link['date_added']);?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="link_status">Last Updated</label>
                                    <div class="col-md-10">
                                        <p id="last_updated" class="form-control-static"><?=format_rfc($link['last_updated']);?></p>
                                    </div>
                                </div>
                            </fieldset>
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
