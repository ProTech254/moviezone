<?php
/*-------------------------------------------------------------------------------------------------
@Module: index.php

@Author: 
@Date: 
-------------------------------------------------------------------------------------------------*/
require_once('main.php');
?>
<html>
<head>
    <title> Movie Zone </title>
    <link rel="stylesheet" type="text/css" href="css/template_styles.css">
    <link rel="stylesheet" type="text/css" href="css/form_styles.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/ajax.js"></script>
    <script src="js/template.js"></script>
    <script src="js/new_member_validate.js"></script>
</head>

<body>
    <div id="id_container">
        <header>
            <h1> Movie Zone </h1>
            <!--<h2><?php echo "(Logged on as ".$_SESSION['authorised'].")"?></h2>-->
            <?php include_once('html/h_navbar.html'); ?>
        </header>
        <!-- left navigation area -->
        <div id="id_left">
            <!-- load the navigation panel by embedding php code -->
            <?php $controller->loadLeftNavPanel()?>
        </div>
        <!-- right area -->    
        <div id="id_right">
            <!-- top navigation area -->
            <div id="id_topnav">            
                <!-- the top navigation panel is loaded on demand using Ajax (see js code) -->
            </div>
            <!-- main content area -->
            <div id="id_content"></div>
        </div>
        <!-- footer area -->
        <footer>copyright 2021</footer>
    </div>
</body>
</html>