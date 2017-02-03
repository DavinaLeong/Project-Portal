<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: edit_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 01 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $project
 * @var $platforms
 * @var $project_categories
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
            <li><a href="<?=site_url('admin/project/browse');?>">Projects</a></li>
            <li><a href="<?=site_url('admin/project/view/' . $project['project_id']);?>">Project ID: <?=$project['project_id'];?></a></li>
            <li class="active">Edit Project</li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Project</h1>

                <div class="row">
                    <div class="col-md-10">

                        <form id="form" class="form-horizontal" method="post" data-parsley-validate>
                            <fieldset>
                                <legend>Grouping</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_id">Platform <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control" id="platform_id" name="platform_id" required>
                                            <option id="platform_id_0" value="">-- Select Platform --</option>
                                            <?php foreach($platforms as $key=>$platform): ?>
                                                <option id="platform_id<?=$key+1;?>" value="<?=$platform['platform_id'];?>" <?=set_select('platform_id', $platform['platform_id'], ($project['platform_id'] == $platform['platform_id']));?>><?=$platform['platform_name'];?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="pc_id">Category <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control" id="pc_id" name="pc_id" required>
                                            <option id="pc_id_0" value="">-- Select Category --</option>
                                            <?php foreach($project_categories as $key=>$project_category): ?>
                                                <option id="pc_id_<?=$key+1;?>" value="<?=$project_category['pc_id'];?>" <?=set_select('pc_id', $project_category['pc_id'], ($project['pc_id'] == $project_category['pc_id']));?>><?=$project_category['pc_name'];?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Identifiers</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_name">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="project_name" name="project_name" value="<?=set_value('project_name', $project['project_name']);?>" required maxlength="512" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_description">Description <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="project_description" name="project_description" value="<?=set_value('project_description', $project['project_description']);?>" required maxlength="512" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_icon">Icon</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="project_icon" name="project_icon" value="<?=set_value('project_icon', $project['project_icon']);?>" maxlength="512" />
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Admin</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_status">Status <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control" id="project_status" name="project_status" required>
                                            <option id="project_status_0" value="">-- Select Status --</option>
                                            <?php foreach($status_options as $key=>$status_option): ?>
                                                <option id="project_status_<?=$key+1;?>" value="<?=$status_option;?>" <?=set_select("project_status", $status_option, ($project['project_status'] == $status_option));?>><?=$status_option;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_status">Date Added</label>
                                    <div class="col-md-10">
                                        <p id="date_added" class="form-control-static"><?=format_dd_mmm_yyyy_hh_ii_ss($project['date_added']);?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_status">Last Updated</label>
                                    <div class="col-md-10">
                                        <p id="last_updated" class="form-control-static"><?=format_rfc($project['last_updated']);?></p>
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
