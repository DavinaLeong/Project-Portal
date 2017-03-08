<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: create_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 31 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $platforms
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
            <li><a href="<?=site_url('admin/project_category/browse');?>">Project Categories</a></li>
            <li class="active">Create Project Category</li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-plus fa-fw"></i> Create Project Category</h1>

                <div class="row">
                    <div class="col-md-10">

                        <?php $this->load->view('admin/_snippets/validation_errors_box'); ?>
                        <?php $this->load->view('admin/_snippets/message_box'); ?>

                        <form id="form" class="form-horizontal" method="post" data-parsley-validate>
                            <fieldset>
                                <legend>Record Details</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_id">Platform <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <select class="form-control" id="platform_id" name="platform_id" required>
                                            <option id="platform_id_0" value="">-- Select Platform --</option>
                                            <?php foreach($platforms as $key=>$platform): ?>
                                                <option id="platform_id<?=$key+1;?>" value="<?=$platform['platform_id'];?>" <?=set_select('platform_id', $platform['platform_id']);?>><?=$platform['platform_name'];?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="pc_name">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="pc_name" name="pc_name"
                                               value="<?=set_value('pc_name');?>" required maxlength="512" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="pc_description">Description</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" id="pc_description"
                                               name="pc_description" value="<?=set_value('pc_description');?>"
                                               maxlength="512" />
                                    </div>
                                </div>

                                <div id="IconField"></div>
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
<?php $this->load->view('admin/_snippets/react_min_resources'); ?>
<script src="<?=RESOURCES_FOLDER;?>pp/dist/js/IconField.min.js"></script>
<script>
    var element = React.createElement(
        IconField,
        {
            "icon_name": "<?=set_value('pc_icon');?>",
            "field_name": "pc_icon",
            "required": false
        }
    );

    ReactDOM.render(
        element,
        document.getElementById('IconField')
    );
</script>
</body>
</html>
