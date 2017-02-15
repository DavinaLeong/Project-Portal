<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: navbar.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 27 Jan 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
?><!-- Navigation start -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <!-- navbar-header start -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?=site_url('admin/authenticate/start');?>"><img src="<?=RESOURCES_FOLDER;?>pp/dist/images/pp_logo.png" alt="Site Logo" height="16px" /> <?=ADMIN_SITE_NAME;?></a>
    </div>
    <!-- navbar-header end -->

    <!-- navbar-top-links start -->
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?=$this->session->userdata('name');?> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?=site_url('admin/authenticate/logout');?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
    <!-- navbar-top-links end -->

    <!-- navbar-static start -->
    <div class="navbar-default sidebar" role="navigation">
        <!-- sidebar-collapse start -->
        <div class="sidebar-nav navbar-collapse">

            <ul class="nav" id="side-menu">
                <li><a href="<?=site_url();?>"><i class="fa fa-file fa-fw"></i> Front Page</a></li>
                <li><a href="<?=site_url('admin/authenticate/tasks');?>"><i class="fa fa-tasks fa-fw"></i> Tasks</a></li>
                <!-- platform module -->
                <li>
                    <a href="#"><i class="fa fa-desktop fa-fw"></i> Platforms<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?=site_url('admin/platform/browse');?>"><i class="fa fa-file-text-o fa-fw"></i> Browse Platforms</a>
                        </li>
                        <li>
                            <a href="<?=site_url('admin/platform/create');?>"><i class="fa fa-plus fa-fw"></i> Create Platform</a>
                        </li>
                    </ul>
                </li>

                <!-- project-category module -->
                <li>
                    <a href="#"><i class="fa fa-tags fa-fw"></i> Project Categories<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?=site_url('admin/project_category/browse');?>"><i class="fa fa-file-text-o fa-fw"></i> Browse Project Categories</a>
                        </li>
                        <li>
                            <a href="<?=site_url('admin/project_category/create');?>"><i class="fa fa-plus fa-fw"></i> Create Project Category</a>
                        </li>
                    </ul>
                </li>

                <!-- project module -->
                <li>
                    <a href="#"><i class="fa fa-sitemap fa-fw"></i> Projects<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?=site_url('admin/project/browse');?>"><i class="fa fa-file-text-o fa-fw"></i> Browse Projects</a>
                        </li>
                        <li>
                            <a href="<?=site_url('admin/project/create');?>"><i class="fa fa-plus fa-fw"></i> Create Project</a>
                        </li>
                    </ul>
                </li>

                <!-- link-category model -->
                <li>
                    <a href="#"><i class="fa fa-tag fa-fw"></i> Link Categories<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?=site_url('admin/link_category/browse');?>"><i class="fa fa-file-text-o fa-fw"></i> Browse Link Categories</a>
                        </li>
                        <li>
                            <a href="<?=site_url('admin/link_category/create');?>"><i class="fa fa-plus fa-fw"></i> Create Link Category</a>
                        </li>
                    </ul>
                </li>

                <!-- link model -->
                <li>
                    <a href="#"><i class="fa fa-link fa-fw"></i> Links<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?=site_url('admin/link/browse');?>"><i class="fa fa-file-text-o fa-fw"></i> Browse Links</a>
                        </li>
                        <li>
                            <a href="<?=site_url('admin/link/create');?>"><i class="fa fa-plus fa-fw"></i> Create Link</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- sidebar-collapse end -->
    </div>
    <!-- navbar-static end -->
</nav>
<!-- Navigation end -->
