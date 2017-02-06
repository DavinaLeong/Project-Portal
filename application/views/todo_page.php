<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: todo_page.jpg
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 03 Feb 2016

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
?><!DCOTYPE html>
<html lang="en">
<head>
    <title><?=SITE_NAME;?> - TODO List</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?=RESOURCES_FOLDER;?>bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link href="<?=RESOURCES_FOLDER;?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <h1 class="page-header">TODO List</h1>
    <ol type="1">
        <li><span class="text-success"><i class="fa fa-check-circle"></i></span> Platform Module</li>
        <li><span class="text-success"><i class="fa fa-check-circle"></i></span> Project Category Module</li>
        <li><span class="text-success"><i class="fa fa-check-circle"></i></span> Project Module</li>
        <li><span class="text-success"><i class="fa fa-check-circle"></i></span> Link Category Module</li>
        <li><span class="text-danger"><i class="fa fa-times-circle"></i></span> Link Module</li>
        <li><span class="text-success"><i class="fa fa-check-circle"></i></span> Tables of Sub-Tables on View Page</li>
    </ol>
</div>
</body>
<!-- jQuery -->
<script src="<?=RESOURCES_FOLDER;?>jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?=RESOURCES_FOLDER;?>bootstrap/js/bootstrap.min.js"></script>
</html>