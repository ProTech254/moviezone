<?php 
/*-------------------------------------------------------------------------------------------------
@Module: join.php - MOVIEZONE
@Author: 
@Adapted from index.php 
@Date: 03 Sep 2018 
@Version: 2.0
@Modified by: 
-------------------------------------------------------------------------------------------------*/
require_once('moviezone_main.php');
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/moviezone.css">
	<script src="js/ajax.js"></script>
	<script src="js/moviezone.js"></script>
   <script src="js/newMemberValidate.js"></script>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body id="id_container">
   <div id="joinpage">
      <!-- Header holds heading and top menu -->
      <header>
         <h1>MOVIEZONE JOIN FORM</h1>
	   
         <div id="id_top_menu">
            <?php include 'html/mainMenu.html';?>
         </div>
      </header>      
     
      <!-- left area -->	  
      <div id="id_left_column">     
      </div>   
      
      <!-- top of main column -->
      <div id="id_left_notify"> 
         <?php $controller->loadLeftNotifyArea()?>
      </div> 
      
      <div id="id_right_notify">			
			<?php $controller->loadRightNotifyArea()?>
      </div>
           
      <div id="id_main_content">      
         <?php include 'html/join_form.html';?>
       </div>  
             
      <!-- footer area -->
      <footer>
          <?php include 'html/footer_content.html';?>
      </footer>
   </div>
</body>
</html>