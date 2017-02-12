<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: todo_page.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 03 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
?><!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('admin/_snippets/meta'); ?>
<?php $this->load->view('admin/_snippets/head_resources'); ?>
<style type="text/css">
    .list-group {
        list-style: decimal inside;
    }

    .list-group-item {
        display: list-item;
    }
</style>
</head>
<body>
<div id="wrapper">
<?php $this->load->view('admin/_snippets/navbar'); ?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><a href="<?=site_url('admin/authenticate/start');?>">Home</a></li>
            <li class="active">Tasks</li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-tasks fa-fw"></i> Tasks</h1>

                <!-- Tasks List start -->
                <ul id="tasks_list_group" class="list-group">
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Setup Environment
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Authenticate Module &amp; Login
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Platform Module
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Project Category Module
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Project Module
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Link Category Module
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Link Module
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Tables of Sub-Tables on View Page
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Touch-up
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> React Icon Field
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Front Page
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="text-success"><i class="fa fa-check-circle"></i></span> Populate DB
                    </li>
                    <li class="list-group-item list-group-item-danger">
                        <span class="text-danger"><i class="fa fa-times-circle"></i></span> Unit Testing
                    </li>
                </ul>
                <!-- Tasks List end -->
            </div>
        </div>
        <?php $this->load->view('admin/_snippets/footer'); ?>
    </div>
</div>
</div>
<?php $this->load->view('admin/_snippets/body_resources') ;?>
</body>
</html>
