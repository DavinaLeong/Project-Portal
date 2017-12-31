<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: browse_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 02 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $projects
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
            <li><a href="<?=site_url('admin/project/browse');?>">Home</a></li>
            <li class="active">Platforms</li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fas fa-file-alt fa-fw"></i> Projects</h1>

                <p class="lead">Click on a 'row' to view a Project record.</p>
                <?php $this->load->view('admin/_snippets/message_box');?>
                <?php if( ! $projects) $this->load->view('admin/_snippets/no_records_box'); ?>

                <div class="row">
                    <div class="col-md-12">

                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Selected Project</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($projects as $key=> $project): ?>
                                <tr id="project_row_<?=$project['project_id'];?>" class="clickable" onclick="goto_view(<?=$project['project_id'];?>)">
                                    <td><i class="<?=$project['project_icon'];?> fa-fw"></i> <?=$project['project_name'];?></td>
                                    <td><?=$project['project_description'];?></td>
                                    <td><?=$project['selected_project'] == 1 ? '<span class="text-primary">Yes</span>' : 'No';?></td>
                                    <td><span class="label label-default label-<?=strtolower($project['project_status']);?>"><?=$project['project_status'];?></span></td>
                                    <td data-sort="<?=format_dd_mm_yyyy_hh_ii_ss($project['last_updated']);?>"
                                        ><?=$project['last_updated'];?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('admin/_snippets/footer'); ?>
    </div>
</div>
</div>
<?php $this->load->view('admin/_snippets/body_resources_datatables'); ?>
<script>
    $(document).ready(function()
    {
        $('#dataTable').DataTable({
            "order": [[4, 'desc']],
            "responsive": true,
            "pageLength": 25
        });
    });

    function goto_view(record_id)
    {
        location.href = '<?=site_url("admin/project/view");?>/' + record_id;
    }
</script>
</body>
</html>