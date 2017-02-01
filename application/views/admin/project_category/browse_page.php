<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: browse_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 02 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $project_categories
 * @var $create_uri
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
            <li><a href="<?=site_url('admin/project_category/browse');?>">Home</a></li>
            <li class="active">Project Categories</li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-file-text-o fa-fw"></i> Project Categories</h1>

                <p class="lead">Click on a 'row' to edit a Project Category record.</p>
                <?php $this->load->view('admin/_snippets/message_box');?>
                <?php if( ! $project_categories) $this->load->view('admin/_snippets/no_records_box'); ?>

                <div class="row">
                    <div class="col-md-12">

                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Date Added</th>
                                <th>Last Updated</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($project_categories as $key=>$project_category): ?>
                                <tr class="clickable" onclick="goto_view(<?=$project_category['pc_id'];?>)">
                                    <td><?=$project_category['pc_name'];?></td>
                                    <td><?=$project_category['pc_description'];?></td>
                                    <td data-sort="<?=format_dd_mm_yyyy_hh_ii_ss($project_category['date_added']);?>"
                                        ><?=format_dd_mmm_yyyy($project_category['date_added']);?></td>
                                    <td data-sort="<?=format_dd_mm_yyyy_hh_ii_ss($project_category['last_updated']);?>"
                                        ><?=format_rfc($project_category['last_updated']);?></td>
                                    <td><button class="btn btn-default" onclick="save_delete_id(<?=$project_category['pc_id'];?>)"
                                            data-toggle="modal" data-target="#delete_modal"><i class="fa fa-trash fa-fw"></i></button></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal start -->
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="delete_modal_label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-danger" id="delete_modal_label"><i class="fa fa-exclamation-triangle"></i>&nbsp;Delete Project Category Record</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert"><strong>This action cannot be undone.</strong></div>
                        <p>Do you still want to delete this record?</p>
                    </div>
                    <div class="modal-footer">
                        <button id="delete_btn" class="btn btn-danger" onclick="do_delete()">
                            <i class="fa fa-trash-o fa-fw"></i> Delete</button>
                        <button id="cancel_delete_btn" type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fa fa-ban fa-fw"></i> Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Modal end -->

        <?php $this->load->view('admin/_snippets/footer'); ?>
    </div>
</div>
</div>
<?php $this->load->view('admin/_snippets/body_resources_datatables'); ?>
<script>
    $(document).ready(function()
    {
        $('#dataTable').DataTable({
            "order": [[2, 'desc']],
            "responsive": true
        });
    });

    function goto_view(record_id)
    {
        location.href = '<?=site_url("admin/project_category/edit");?>/' + record_id;
    }

    var delete_pc_id = 0;
    function save_delete_id(delete_id)
    {
        delete_pc_id = delete_id;
    }

    function do_delete()
    {
        location.href = '<?=site_url("admin/project_category/delete");?>/' + delete_pc_id;
    }
</script>
</body>
</html>