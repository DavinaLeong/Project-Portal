<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: view_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 31 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $project
 * @var $link_categories
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
            <li><a href="<?=site_url('admin/project/browse');?>">Projects</a></li>
            <li class="active">Project ID: <?=$project['project_id'];?></li>
        </ol>

        <div class="row">
            <div id="main" class="col-lg-12">
                <h1 class="page-header text-info"><i class="fa fa-eye fa-fw"></i> View Project&nbsp;
                    <div class="btn-group">
                        <button id="action_btn" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-gavel fa-fw"></i> Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a id="edit_record" href="<?=site_url('admin/project/edit/' . $project['project_id']);?>"><i class="fas fa-edit fa-fw"></i> Edit Record</a></li>
                            <li><a id="delete_record" class="clickable" data-toggle="modal" data-target="#delete_modal"><i class="fas fa-trash-alt fa-fw"></i> Delete Record</a></li>
                        </ul>
                    </div>
                </h1>

                <?php $this->load->view('admin/_snippets/message_box'); ?>

                <div class="row">
                    <div class="col-md-10">
                        <!-- View Form start -->
                        <form id="form" class="form-horizontal">
                            <fieldset>
                                <legend>Record Details</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="pc_name">Project Category</label>
                                    <div class="col-md-10">
                                        <p id="pc_name" class="form-control-static">
                                            <i class="fa <?=$project['pc_icon'];?> fa-fw"></i> <?=$project['pc_name'];?>
                                            <?php if($project['pc_name']): ?>
                                                <br/>(<a href="<?=site_url('admin/project_category/view/' . $project['pc_id']);?>" target="_blank">View Project Category</a>)
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_name">Name</label>
                                    <div class="col-md-10">
                                        <p id="project_name" class="form-control-static"><?=$project['project_name'];?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_description">Description</label>
                                    <div class="col-md-10">
                                        <p id="project_description" class="form-control-static"><?=$project['project_description'];?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_icon">Icon</label>
                                    <div class="col-md-10">
                                        <p id="project_icon" class="form-control-static"><i class="<?=$project['project_icon'];?> fa-fw"></i> <small>(<?=$project['project_icon'];?>)</small></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="selected_project">Selected Project</label>
                                    <div class="col-md-10">
                                        <p id="selected_project" class="form-control-static">
                                            <span class="label label-default">
                                                <?=$project['selected_project'] == 1 ? 'Yes' : 'No';?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Admin</legend>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_status">Status</label>
                                    <div class="col-md-10">
                                        <p id="project_status" class="form-control-static"><span class="label label-default label-<?=strtolower($project['project_status']);?>"><?=$project['project_status'];?></span></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_status">Date Added</label>
                                    <div class="col-md-10">
                                        <p id="date_added" class="form-control-static"><?=format_dd_mm_yyyy_hh_ii_ss($project['date_added']);?></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2" for="project_status">Last Updated</label>
                                    <div class="col-md-10">
                                        <p id="last_updated" class="form-control-static"><?=format_rfc($project['last_updated']);?></p>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                        <!-- View Form end -->
                    </div>
                </div>
                <div class="space-vert-50"></div>

                <!-- Link Categories start -->
                <div id="lc-panel" class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <h2 class="panel-title">Link Categories</h2>
                            </div>
                            <div class="col-xs-6">
                                <button id="new_lc_btn" class="btn btn-default pull-right" onclick="goto_create(<?=$project['project_id'];?>)">
                                    <i class="fas fa-plus fa-fw"></i> Create Record
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="table-lc" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Last Updated</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($link_categories as $link_category): ?>
                                    <tr class="clickable" onclick="goto_lc_view(<?=$link_category['lc_id'];?>)">
                                        <td><?=$link_category['lc_name'];?></td>
                                        <td><?=$link_category['lc_description'];?></td>
                                        <td data-sort="<?=format_yyyy_mm_dd_hh_ii_ss($link_category['last_updated']);?>"><?=format_dd_mm_yyyy_hh_ii_ss($link_category['last_updated']);?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Link Categories end -->

                <!-- Link start -->
                <div id="links-panel" class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Links</h2>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="table-links" class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Category</th>
                                    <th>Output URL</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
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
                <!-- Link end -->

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
        $('#table-lc').DataTable({
            "order": [[0, 'asc']],
            "responsive": true
        });

        $('#table-links').DataTable({
            "order": [[0, 'asc']],
            "responsive": true
        });
    });

    function goto_lc_view(record_id)
    {
        window.open('<?=site_url("admin/link_category/view");?>/' + record_id);
    }

    function goto_create(project_id)
    {
        location.href = '<?=site_url("admin/link_category/create");?>' + '/' + project_id;
    }

    function goto_link_view(record_id)
    {
        window.open('<?=site_url("admin/link/view");?>/' + record_id);
    }
</script>
</body>
</html>
