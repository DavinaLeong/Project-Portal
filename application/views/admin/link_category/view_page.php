<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: view_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 06 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $link_category
 * @var $links
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
            <li><a href="<?=site_url('admin/link_category/browse');?>">Link Categories</a></li>
            <li class="active">Link Category ID: <?=$link_category['lc_id'];?></li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-eye fa-fw"></i> View Link Category&nbsp;
                    <div class="btn-group">
                        <button id="action_btn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-gavel fa-fw"></i> Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a id="edit_record" href="<?=site_url('admin/link_category/edit/' . $link_category['lc_id']);?>"><i class="fas fa-edit fa-fw"></i> Edit Record</a></li>
                            <li><a id="delete_record" class="clickable" data-toggle="modal" data-target="#delete_modal"><i class="fas fa-trash-alt fa-fw"></i> Delete Record</a></li>
                        </ul>
                    </div>
                </h1>
                
                <div class="row">
                    <div class="col-md-10">

                        <?php $this->load->view('admin/_snippets/message_box'); ?>

                        <form id="form" class="form-horizontal">
                            <fieldset>
                                <legend>Record Details</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="platform">Platform</label>
                                    <div class="col-md-10">
                                        <p id="platform" class="form-control-static">
                                            <i class="fa <?=$link_category['platform_icon'];?> fa-fw"></i> <?=$link_category['platform_name'];?>
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project">Project</label>
                                    <div class="col-md-10">
                                        <p id="project" class="form-control-static">
                                            <i class="fa <?=$link_category['project_icon'];?> fa-fw"></i> <?=$link_category['project_name'];?>
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="lc_name">Name</label>
                                    <div class="col-md-10">
                                        <p id="lc_name" class="form-control-static"><?=$link_category['lc_name'];?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="lc_description">Description</label>
                                    <div class="col-md-10">
                                        <p id="lc_description" class="form-control-static"><?=$link_category['lc_description'];?></p>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Admin</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="link_category_status">Date Added</label>
                                    <div class="col-md-10">
                                        <p id="date_added" class="form-control-static"><?=format_dd_mm_yyyy_hh_ii_ss($link_category['date_added']);?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="link_category_status">Last Updated</label>
                                    <div class="col-md-10">
                                        <p id="last_updated" class="form-control-static"><?=format_rfc($link_category['last_updated']);?></p>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="space-vert-50"></div>

                <!-- Link panel start -->
                <div id="links" class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <h2 class="panel-title">Links</h2>
                            </div>
                            <div class="col-xs-6">
                                <button id="new_link_btn" class="btn btn-default pull-right" type="button" onclick="goto_create(<?=$link_category['lc_id'];?>)">
                                    <i class="fas fa-plus fa-fw"></i> Create Record
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="table-links" class="table table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Label</th>
                                    <th>Output URL</th>
                                    <th>Status</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($links as $link):
                                    $output_url = ($link['use_https'] == 1 ? 'https' : 'http') . '://' . $link['url'];
                                    ?>
                                    <tr id="link_row_<?=$link['link_id'];?>">
                                        <td><?=$link['link_id'];?></td>
                                        <td><?=$link['label'];?></td>
                                        <td><a href="<?=$output_url;?>" target="_blank"><?=($link['use_https'] == 1 ? 'https' : 'http') . '://' . $link['url'];?></a></td>
                                        <td><span class="label label-default label-<?=strtolower($link['link_status']);?>"><?=$link['link_status'];?></span></td>
                                        <td>
                                            <div class="btn-group">
                                                <a id="view_link_<?=$link['link_id'];?>" class="btn btn-default" href="<?=site_url('admin/link/view/' . $link['link_id']);?>" target="_blank"><i class="fa fa-eye fa-fw"></i></a>
                                                <a id="view_link_url_<?=$link['link_id'];?>" class="btn btn-default" href="<?=$output_url;?>" target="_blank"><i class="fa fa-link fa-fw"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Link panel end -->
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
        $('#table-links').DataTable({
            "order": [[0, 'asc']],
            "responsive": true
        });
    });

    function goto_create(lc_id)
    {
        location.href = '<?=site_url("admin/link/create");?>' + '/' + lc_id;
    }
</script>
</body>
</html>
