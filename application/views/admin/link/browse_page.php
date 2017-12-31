<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: browse_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 06 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $links
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
            <li><a href="<?=site_url('admin/link/browse');?>">Home</a></li>
            <li class="active">Links</li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fas fa-edit fa-fw"></i> Links</h1>

                <p class="lead">Click on a 'row' to view a Link record.</p>
                <?php $this->load->view('admin/_snippets/message_box');?>
                <?php if( ! $links) $this->load->view('admin/_snippets/no_records_box'); ?>

                <div class="row">
                    <div class="col-md-12">

                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Label</th>
                                <th>URL</th>
                                <th>Use HTTPS</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($links as $key=>$link): ?>
                                <tr id="link_row_<?=$link['link_id'];?>" class="clickable" onclick="goto_view(<?=$link['link_id'];?>)">
                                    <td><?=$link['label'];?></td>
                                    <td><?=$link['url'];?></td>
                                    <td><?=$link['use_https'] == 1 ? 'Yes' : 'No';?></td>
                                    <td><span class="label label-default label-<?=strtolower($link['link_status']);?>"><?=$link['link_status'];?></span></td>
                                    <td data-sort="<?=format_dd_mm_yyyy_hh_ii_ss($link['last_updated']);?>"
                                        ><?=$link['last_updated'];?></td>
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
            "order": [[3, 'desc']],
            "responsive": true,
            "pageLength": 25
        });
    });

    function goto_view(record_id)
    {
        location.href = '<?=site_url("admin/link/view");?>/' + record_id;
    }
</script>
</body>
</html>