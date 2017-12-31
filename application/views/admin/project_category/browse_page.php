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
                <h1 class="page-header text-info"><i class="fas fa-file-alt fa-fw"></i> Project Categories</h1>

                <p class="lead">Click on a 'row' to view a Project Category record.</p>
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
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($project_categories as $key=>$project_category): ?>
                                <tr id="pc_row_<?-$project_category['pc_id'];?>" class="clickable" onclick="goto_view(<?=$project_category['pc_id'];?>)">
                                    <td><i class="fa <?=$project_category['pc_icon'];?> fa-fw"></i> <?=$project_category['pc_name'];?></td>
                                    <td><?=$project_category['pc_description'];?></td>
                                    <td data-sort="<?=format_dd_mm_yyyy_hh_ii_ss($project_category['date_added']);?>"
                                        ><?=format_dd_mmm_yyyy($project_category['date_added']);?></td>
                                    <td data-sort="<?=format_dd_mm_yyyy_hh_ii_ss($project_category['last_updated']);?>"
                                        ><?=format_rfc($project_category['last_updated']);?></td>
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
            "order": [[2, 'desc']],
            "responsive": true
        });
    });

    function goto_view(record_id)
    {
        location.href = '<?=site_url("admin/project_category/view");?>/' + record_id;
    }
</script>
</body>
</html>