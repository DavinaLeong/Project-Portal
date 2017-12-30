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
    <script defer src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script>

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
    <h1 class="display-4"><i class="fas fa-bookmark fa-fw"></i> Project Portal&nbsp;
        <span class="btn btn-primary text-white">
            <i class="fas <?=$platform['platform_icon'];?> fa-fw"></i> <?=$platform['platform_name'];?>&nbsp;
            <span class="badge badge-light text-dark"><?=$total_links;?></span>
        </span>
    </h1>
    <p class="lead">
        <div class="btn-group btn-group-sm">
            <a class="btn btn-outline-info" href="<?=site_url('admin/authenticate/login');?>" target="_blank">
                <i class="fas fa-user fa-fw"></i> Admin Panel
            </a>
            <a class="btn btn-outline-success" href="https://docs.google.com/forms/d/1DipH6wItUim97uXde-DCreLnqX8BDq6Fzp-tbainHfk/viewform" target="_blank">
                <i class="fas fa-check fa-fw"></i> Work Log
            </a>
        </div>
        &nbsp;
        Links to all wamp project landing pages.
    </p>
    <hr>

    <h2 class="mb-3">Project Categories</h2>
    <!-- Accordion start -->
    <div id="pc-accordion" role="tablist">
        <?php
        foreach($project_categories as $pc_key=>$project_category):
            $pc_id = $project_category['pc_id'];?><!-- <?=$project_category['pc_name'];?> start -->
        <div id="pc-<?=$pc_id;?>-card" class="card">
            <div id="pc-<?=$pc_id;?>-card-header" class="card-header" role="tab">
                <h5 id="pc-<?=$pc_id;?>-heading" class="mb-0">
                    <i class="<?=$project_category['pc_icon'];?> fa-fw"></i>&nbsp;<a id="pc-<?=$pc_id;?>-toggle" class="text-dark" data-toggle="collapse" href="#pc-<?=$pc_id;?>-collapse" role="button" aria-expanded="true" aria-controls="pc-<?=$pc_id;?>-collapse"><?=$project_category['pc_name'];?></a>&nbsp;<small>- <?=$project_category['pc_description'];?></small>
                </h5>
            </div>

            <div id="pc-<?=$pc_id;?>-collapse" class="collapse<?=($pc_key > 0) ? '' : ' show';?>" role="tabpanel" aria-labelledby="pc-<?=$pc_id;?>-card-header" data-parent="#pc-accordion">
                <div class="card-body">
                    <div class="row">
                        <?php $projects = $project_category['projects'];
                        if(count($projects) <= 0): ?>
                        <div id="pc-<?=$pc_id;?>-noproject" class="col-12 text-muted">No <em>active</em> "<?=$project_category['pc_name'];?>" projects on this server.</div>
                        <?php else: ?>
                        <?php   foreach($projects as $project_key=>$project):
                            $project_id = $project['project_id'];
                            $border_col = $text_col = $a_class = '';
                            if($project['selected_project'] == 1) {
                                $border_col = ' border-info';
                                $text_col = ' text-info';
                                $a_class = ' class="' . $text_col . '"';
                            } ?>
                        <div id="pc-<?=$pc_id;?>-project-<?=$project_id;?>-card" class="col-12 col-md-3 card<?=$border_col;?>">
                            <div class="card-body">
                                <h5 class="card-title<?=$text_col;?>"><i class="<?=$project['project_icon'];?> fa-fw"></i> <?=$project['project_name'];?></h5>
                                <?php if( ! empty($project['project_description'])): ?>
                                <p class="card-text"><?=$project['project_description'];?></p>
                                <?php endif; ?>

                                <?php $link_categories = $project['link_categories'];
                                foreach($link_categories as $lc_key=>$link_category): ?>
                                <?php if($link_category['lc_name'] !== 'None'): ?>
                                <h6 class="card-subtitle text-secondary">localhost</h6>
                                <?php endif; ?>

                                <?php $links = $link_category['links'];
                                        if(count($links) <= 0): ?>
                                <p class="text-muted">No <em>active</em> links.</p>
                                <?php   else: ?>
                                <ul class="mb-2">
                                <?php foreach($links as $link_key=>$link):
                                    $output_url = ($link['use_https'] == 1 ? 'https://' : 'http://') . $link['url']; ?>
                                    <li><a<?=$a_class;?> href="<?=$output_url;?>" target="_blank"><?=$link['label'];?></a></li>
                                <?php       endforeach; ?>
                                </ul>
                                <?php   endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php   endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- <?=$project_category['pc_name'];?> end -->
        <?php endforeach; ?>
    </div>
    <!-- Accordion end -->

    <!--footer start-->
    <footer class="text-secondary">
        <hr/>
        <div class="text-right">
            <span><em><?=SITE_NAME;?> &#8226; <?= now('Y'); ?></em></span>
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