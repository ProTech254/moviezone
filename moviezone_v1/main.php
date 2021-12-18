<?php
/*-------------------------------------------------------------------------------------------------
@Module: main.php
This server-side main module interacts with the UI to process user requests

@Author: 
@Date: 
--------------------------------------------------------------------------------------------------*/
require_once('config.php'); 

//initialises the model and view
$model = new Model();
$view = new View();
//the controller here composes the model and view
$controller = new Controller($model, $view);

//this interacts with the UI via GET/POST methods and processes all requests
//check if there is a request to process
if (!empty($_REQUEST[CMD_REQUEST])) 
{ 
    $request = $_REQUEST[CMD_REQUEST];    
    $controller->processRequest($request);
}
?>