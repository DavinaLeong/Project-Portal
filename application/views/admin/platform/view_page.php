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
 * @var $project_categories
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
            <li><a href="<?=site_url('admin/platform/browse');?>">Platforms</a></li>
            <li class="active">Platform ID: <?=$platform['platform_id'];?></li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-eye fa-fw"></i> View Platform&nbsp;
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

                <?php $this->load->view('admin/_snippets/message_box'); ?>

                <div class="row">
                    <div class="col-md-10">

                        <!-- Form start -->
                        <form id="form" class="form-horizontal">
                            <fieldset>
                                <legend>Record Details</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_name">Name</label>
                                    <div class="col-md-10">
                                        <p id="platform_name" class="form-control-static"><?=$platform['platform_name'];?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_description">Description</label>
                                    <div class="col-md-10">
                                        <p id="platform_description" class="form-control-static"><?=$platform['platform_description'];?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_icon">Icon</label>
                                    <div class="col-md-10">
                                        <p id="platform_icon" class="form-control-static"><i class="fa <?=$platform['platform_icon'];?> fa-fw"></i> <small>(<?=$platform['platform_icon'];?>)</small></p>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Admin</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_status">Status</label>
                                    <div class="col-md-10">
                                        <p id="platform_status" class="form-control-static"><span class="label label-default label-<?=strtolower($platform['platform_status']);?>"><?=$platform['platform_status'];?></span></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_status">Date Added</label>
                                    <div class="col-md-10">
                                        <p id="date_added" class="form-control-static"><?=format_dd_mm_yyyy_hh_ii_ss($platform['date_added']);?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform_status">Last Updated</label>
                                    <div class="col-md-10">
                                        <p id="last_updated" class="form-control-static"><?=format_rfc($platform['last_updated']);?></p>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <!-- Form end -->
                    </div>
                </div>

                <div class="space-vert-50"></div>

                <!-- Project Categories table start -->
                <div id="projects-panel" class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Project Categories</h2>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="table-projects" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($project_categories as $project_category): ?>
                                    <tr id="pc_row_<?=$project_category['pc_id'];?>" class="clickable" onclick="goto_view(<?=$project_category['pc_id'];?>)">
                                        <td><?=$project_category['pc_id'];?></td>
                                        <td><?=$project_category['pc_name'];?></td>
                                        <td><?=$project_category['pc_description'];?></td>
                                    </tr>
                                <?php endforeach; ?>
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
        window.open('<?=site_url("admin/project_category/view");?>/' + record_id);
    }
</script>
</body>
</html>
