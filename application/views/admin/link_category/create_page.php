<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: create_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 04 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $project_id
 * @var $projects
 */
?><!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('admin/_snippets/meta'); ?>
<?php $this->load->view('admin/_snippets/head_resources'); ?>
<link href="<?=RESOURCES_FOLDER;?>pp/dist/css/pp_parsley.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="wrapper">
<?php $this->load->view('admin/_snippets/navbar'); ?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/authenticate/start');?>">Home</a></li>
            <li><a href="<?=site_url('admin/link_category/browse');?>">Link Categories</a></li>
            <li class="active">Create Link Category</li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fas fa-plus fa-fw"></i> Create Link Category</h1>

                <div class="row">
                    <div class="col-md-10">

                        <?php $this->load->view('admin/_snippets/validation_errors_box'); ?>
                        <?php $this->load->view('admin/_snippets/message_box'); ?>

                        <form id="form" class="form-horizontal" method="post" data-parsley-validate>
                            <fieldset>
                                <legend>Record Details</legend>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_id">Link <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control" id="project_id" name="project_id" required>
                                            <option id="project_id_0" value="">-- Select Link --</option>
                                            <?php foreach($projects as $key=> $project): ?>
                                            <option id="project_id_<?=$key+1;?>" value="<?=$project['project_id'];?>" <?=set_select('project_id', $project['project_id'], $project['project_id'] == $project_id);?>><?=$project['project_name'];?> (<?=$project['platform_name'];?>)</option>
                                            <?php endforeach ;?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="lc_name">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input class="form-control" type="text" id="lc_name" name="lc_name"
                                                   value="<?=set_value('lc_name');?>" required maxlength="512" />
                                            <span class="input-group-btn">
                                                <button id="fill_none_btn" class="btn btn-default" type="button" onClick="fillNone()">
                                                    Fill with 'None'
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="lc_description">Description</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="lc_description"
                                               name="lc_description" value="<?=set_value('lc_description');?>" maxlength="512" />
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <br/>
                                <div class="col-md-10 col-md-offset-2">
                                    <button id="submit_btn" class="btn btn-primary" type="submit"><i class="fas fa-check fa-fw"></i> Submit</button>
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
<script>
    function fillNone()
    {
        $('#lc_name').val('None');
        $('#fill_none_btn').blur();
    }
</script>
</body>
</html>
