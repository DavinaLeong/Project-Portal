<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: index_page.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 08 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $platform
 * @var $project_categories
 * @var $total_links
 */
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?=SITE_NAME;?>">
    <meta name="author" content="Davina Leong">

    <title><?=SITE_NAME;?></title>

    <!-- favicon -->
    <link href="<?=RESOURCES_FOLDER;?>pp/dist/images/pp_icon.png" type="image/png" rel="icon" />

    <!-- Bootstrap 4 styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

    <!-- Font Awesome 5 -->
    <link href="<?=RESOURCES_FOLDER;?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- <script defer src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script> -->

    <!-- Project Portal CSS -->
    <!-- <link href="<?=RESOURCES_FOLDER;?>pp/dist/css/pp_styles.css" rel="stylesheet" type="text/css" /> -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    -->
</head>
<body>
<!-- container start -->
<div class="container">
    <h1 class="display-4"><i class="fa fa-bookmark fa-fw"></i> Project Portal&nbsp;
        <span class="btn btn-primary text-white">
            <i class="fa <?=$platform['platform_icon'];?> fa-fw"></i> <?=$platform['platform_name'];?>&nbsp;
            <span class="badge badge-light text-dark"><?=$total_links;?></span>
        </span>
    </h1>
    <p class="lead">
        <div class="btn-group btn-group-sm">
            <a class="btn btn-outline-info" href="<?=site_url('admin/authenticate/login');?>" target="_blank">
                <i class="fa fa-user fa-fw"></i> Admin Panel
            </a>
            <a class="btn btn-outline-success" href="https://docs.google.com/forms/d/1DipH6wItUim97uXde-DCreLnqX8BDq6Fzp-tbainHfk/viewform" target="_blank">
                <i class="fa fa-check fa-fw"></i> Work Log
            </a>
        </div>
        &nbsp;
        Links to all wamp project landing pages.
    </p>

    <!-- Accordion start -->
    <div class="panel-group" id="pc_accordion" role="tablist" aria-multiselectable="true">
        <?php
        foreach($project_categories as $pc_key=>$project_category):
            $name_underscore = str_replace(' ', '_', strtolower($project_category['pc_name']));
            $name_camel = str_replace(' ', '', $project_category['pc_name']); ?>
            <!-- <?=$project_category['pc_name'];?> Panel start -->
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="pc_panel_<?=$project_category['pc_id'];?>_heading">
                    <h1 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#pc_accordion" href="#<?=$name_underscore;?>_panel" aria-expanded="true" aria-controls="collapse<?=$name_camel;?>">
                            <i class="fa <?=$project_category['pc_icon'];?> fa-fw"></i> <?=$project_category['pc_name'];?> <small>- <?=$project_category['pc_description'];?></small>
                        </a>
                    </h1>
                </div>
                <div id="<?=$name_underscore;?>_panel" class="panel-collapse collapse<?=$pc_key == 0 ? ' in' : '';?>" role="tabpanel" aria-labelledby="<?=$name_underscore;?>_panel_heading">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">

                                <!-- Projects start -->
                                <div class="row">
                                    <?php
                                    $projects = $project_category['projects'];
                                    if(count($projects) <= 0):
                                        ?>
                                        <div class="col-md-12 col-project"><em class="text-muted">No "<?=strtolower($project_category['pc_name']);?>" projects on this server</em></div>
                                    <?php else: ?>
                                        <?php foreach($projects as $project): ?>
                                            <div id="project_<?=$project['project_id'];?>" class="col-md-3 col-sm-2 col-xs-12 col-project<?=$project['selected_project'] == 1 ? ' selected-project' : '';?>">
                                                <h4><i class="fa <?=$project['project_icon'];?> fa-fw"></i> <?=$project['project_name'];?></h4>
                                                <?php if($project['project_description']): ?>
                                                    <p><?=$project['project_description'];?></p>
                                                <?php endif; ?>

                                                <?php
                                                $link_categories = $project['link_categories'];
                                                foreach($link_categories as $link_category): ?>
                                                    <?php if($link_category['lc_name'] !== 'None'): ?>
                                                        <p><?=$link_category['lc_name'];?></p>
                                                    <?php endif; ?>
                                                    <?php if($link_category['lc_description']): ?>
                                                        <p><small><?=$link_category['lc_description'];?></small></p>
                                                    <?php endif; ?>

                                                    <ul>
                                                        <?php $links = $link_category['links'];
                                                        foreach($links as $link):
                                                            $output_url = ($link['use_https'] == 1 ? 'https://' : 'http://') . $link['url'];
                                                            ?>
                                                            <li><a id="link_<?=$link['link_id'];?>" href="<?=$output_url;?>" target="_blank"><?=$link['label'];?></a></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endforeach;?>
                                    <?php endif; ?>
                                </div>
                                <!-- Projects end -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- <?=$project_category['pc_name'];?> Panel end -->
        <?php endforeach; ?>
    </div>
    <!-- Accordion end -->

    <!--footer start-->
    <footer class="site-footer">
        <hr/>
        <div class="text-right">
            <span class="text-secondary"><em><?=SITE_NAME;?> &#8226; <?= now('Y'); ?></em></span>
        </div>
    </footer>
    <!--footer end-->

    <div style="height: 100px">&nbsp;</div>
</div>
<!-- container end -->

<!-- Bootstrap 4 scripts -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
</body>
</html>