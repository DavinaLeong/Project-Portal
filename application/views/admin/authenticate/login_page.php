<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: login_page.php
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
<link href="<?=RESOURCES_FOLDER;?>pp/pp_parsley.css" rel="stylesheet" type="text/css">
<style>
    html, body {
        width: 100%;
        height: 100%;
    }

    body {
        background: url('<?=RESOURCES_FOLDER;?>pp/images/login-background.jpg') center no-repeat #000;
        background-size: cover;
    }
</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center"><img data-toggle="tooltip" title="<?=ADMIN_SITE_NAME;?>" src="<?=RESOURCES_FOLDER;?>pp/images/pp_logo.png" alt="site logo" width="64" height="64" /></h3>
                </div>
                <div class="panel-body">
                    <?php $this->load->view('admin/_snippets/validation_errors_box'); ?>
                    <?php $this->load->view('admin/_snippets/message_box'); ?>
                    <form method="post" data-parsley-validate>
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" id="username" name="username" type="text"
                                       placeholder="Username" required autofocus />
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="password" name="password" type="password" required />
                            </div>
                            <button class="btn btn-lg btn-primary btn-block" id="submit_btn" type="submit">Login</button>
                        </fieldset>
                    </form>
                </div>
                <div class="panel-footer text-right text-muted text-italic">
                    <small><?=ADMIN_SITE_NAME;?> &#8226; <?=today('Y');?></small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/_snippets/body_resources'); ?>
<script src="<?=RESOURCES_FOLDER;?>vendor/parsleyjs/parsley.min.js"></script>
</body>
</html>
