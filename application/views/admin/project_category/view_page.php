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
 * @var $project_category
 * @var $projects
 */
?><!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('admin/_snippets/meta'); ?>
<?php $this->load->view('admin/_snippets/head_resources_datatables'); ?>
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
            <li class="active">Project Category ID: <?=$project_category['pc_id'];?></li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-eye fa-fw"></i> View Project Category&nbsp;
                    <div class="btn-group">
                        <button id="action_btn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-gavel fa-fw"></i> Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a id="edit_record" href="<?=site_url('admin/project_category/edit/' . $project_category['pc_id']);?>"><i class="fa fa-pencil-square-o fa-fw"></i> Edit Record</a></li>
                            <li><a id="delete_record" class="clickable" data-toggle="modal" data-target="#delete_modal"><i class="fa fa-trash fa-fw"></i> Delete Record</a></li>
                        </ul>
                    </div>
                </h1>

                <?php $this->load->view('admin/_snippets/message_box'); ?>

                <div class="row">
                    <div class="col-md-10">

                        <!-- From start -->
                        <form id="form" class="form-horizontal">
                            <fieldset>
                                <legend>Record Details</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="pc_name">Name</label>
                                    <div class="col-md-10">
                                        <p id="pc_name" class="form-control-static"><?=$project_category['pc_name'];?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="pc_icon">Icon</label>
                                    <div class="col-md-10">
                                        <p id="pc_icon" class="form-control-static"><i class="fa <?=$project_category['pc_icon'];?> fa-fw"></i> (<?=$project_category['pc_icon'];?>)</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="pc_description">Description</label>
                                    <div class="col-md-10">
                                        <p id="pc_description" class="form-control-static"><?=$project_category['pc_description'];?></p>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Admin</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_category_status">Date Added</label>
                                    <div class="col-md-10">
                                        <p id="date_added" class="form-control-static"><?=format_dd_mm_yyyy_hh_ii_ss($project_category['date_added']);?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_category_status">Last Updated</label>
                                    <div class="col-md-10">
                                        <p id="last_updated" class="form-control-static"><?=format_rfc($project_category['last_updated']);?></p>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <!-- Form end -->
                    </div>
                </div>

                <div class="space-vert-50"></div>

                <!-- Projects table start -->
                <div id="projects-panel" class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Projects</h2>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="table-projects" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($projects as $project): ?>
                                    <tr class="clickable" onclick="goto_view(<?=$project['project_id'];?>)">
                                        <td><?=$project['project_id'];?></td>
                                        <td><?=$project['project_name'];?></td>
                                        <td><?=$project['project_description'];?></td>
                                        <td><span class="label label-default label-<?=strtolower($project['project_status']);?>"><?=$project['project_status'];?></span></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Projects table end -->

            </div>
        </div>
        <?php $this->load->view('admin/_snippets/generic_delete_modal'); ?>
        <?php $this->load->view('admin/_snippets/footer'); ?>
    </div>
</div>
</div>
<?php $this->load->view('admin/_snippets/body_resources_datatables') ;?>
<script>
    $(document).ready(function()
    {
        $('#table-projects').DataTable({
            "order": [[0, 'asc']],
            "responsive": true
        });
    });

    function goto_view(record_id)
    {
        window.open('<?=site_url("admin/project/view");?>/' + record_id);
    }
</script>
</body>
</html>
