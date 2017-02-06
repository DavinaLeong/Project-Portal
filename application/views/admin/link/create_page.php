<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: create_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 06 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $link_categories
 * @var $status_options
 */
?><!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('admin/_snippets/meta'); ?>
<?php $this->load->view('admin/_snippets/head_resources'); ?>
<link href="<?=RESOURCES_FOLDER;?>pp/pp_parsley.css" rel="stylesheet" type="text/css">
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
            <li class="active">Create Link</li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-plus fa-fw"></i> Create Link</h1>

                <div class="row">
                    <div class="col-md-10">

                        <?php $this->load->view('admin/_snippets/validation_errors_box'); ?>
                        <?php $this->load->view('admin/_snippets/message_box'); ?>

                        <form id="form" class="form-horizontal" method="post" data-parsley-validate>
                            <fieldset>
                                <legend>Record Details</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="lc_id">Category <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control" id="lc_id" name="lc_id" required>
                                            <option id="lc_id_0" value="">-- Select Category --</option>
                                            <?php foreach($link_categories as $key=> $link_category): ?>
                                                <option id="lc_id_<?=$key+1;?>" value="<?=$link_category['lc_id'];?>" <?=set_select('lc_id', $link_category['lc_id']);?>><?=$link_category['project_name'];?>: <?=$link_category['lc_name'];?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="label">Label <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="label" name="label"
                                               value="<?=set_value('label');?>" required maxlength="512" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="url">URL <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="url" id="url" name="url"
                                               value="<?=set_value('url');?>" required maxlength="512" />
                                        <p class="help-block">Exclude 'http://' from URL.</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="use_https">Use HTTPS</label>
                                    <div class="col-md-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="use_https" name="use_https" value="1" <?=set_checkbox('use_https', 1); ?> /> Yes
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Admin</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="link_status">Status <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control" id="link_status" name="link_status" required>
                                            <option id="link_status_0" value="">-- Select Status --</option>
                                            <?php foreach($status_options as $key=>$status_option): ?>
                                                <option id="link_status_<?=$key+1;?>" value="<?=$status_option;?>" <?=set_select('link_status', $status_option);?>><?=$status_option;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <br/>
                                <div class="col-md-10 col-md-offset-2">
                                    <button id="submit_btn" class="btn btn-primary" type="submit"><i class="fa fa-check fa-fw"></i> Submit</button>
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
<script src="<?=RESOURCES_FOLDER;?>parsleyjs/parsley.min.js"></script>
</body>
</html>
