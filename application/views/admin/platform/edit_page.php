<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: edit_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 01 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $platform
 * @var $status_options
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
            <li><a href="<?=site_url('admin/platform/browse');?>">Platforms</a></li>
            <li><a href="<?=site_url('admin/platform/view/' . $platform['platform_id']);?>">Platform ID: <?=$platform['platform_id'];?></a></li>
            <li class="active">Edit Platform</li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fas fa-edit fa-fw"></i> Edit Platform</h1>

                <div class="row">
                    <div class="col-md-10">

                        <?php $this->load->view('admin/_snippets/validation_errors_box'); ?>
                        <?php $this->load->view('admin/_snippets/message_box'); ?>

                        <form id="form" class="form-horizontal" method="post" data-parsley-validate>
                            <fieldset>
                                <legend>Record Details</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_name">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="platform_name" name="platform_name" value="<?=set_value('platform_name', $platform['platform_name']);?>" required maxlength="512" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_description">Description <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="platform_description" name="platform_description" value="<?=set_value('platform_description', $platform['platform_description']);?>" required maxlength="512" />
                                    </div>
                                </div>

                                <div id="IconField"></div>
                            </fieldset>

                            <fieldset>
                                <legend>Admin</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_status">Status <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control" id="platform_status" name="platform_status" required>
                                            <option id="platform_status_0" value="">-- Select Status --</option>
                                            <?php foreach($status_options as $key=>$status_option): ?>
                                                <option id="platform_status_<?=$key+1;?>" value="<?=$status_option;?>" <?=set_select("platform_status", $status_option, ($platform['platform_status'] == $status_option));?>><?=$status_option;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_status">Date Added</label>
                                    <div class="col-md-10">
                                        <p id="date_added" class="form-control-static"><?=format_dd_mmm_yyyy_hh_ii_ss($platform['date_added']);?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_status">Last Updated</label>
                                    <div class="col-md-10">
                                        <p id="last_updated" class="form-control-static"><?=format_rfc($platform['last_updated']);?></p>
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
<?php $this->load->view('admin/_snippets/react_min_resources'); ?>
<script src="<?=RESOURCES_FOLDER;?>pp/dist/js/IconField.min.js"></script>
<script>
    var element = React.createElement(
        IconField,
        {
            "icon_name": "<?=set_value('platform_icon', $platform['platform_icon']);?>",
            "field_name": "platform_icon",
            "required": true
        }
    );

    ReactDOM.render(
        element,
        document.getElementById('IconField')
    );
</script>
</body>
</html>
