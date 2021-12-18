<?php
/*-------------------------------------------------------------------------------------------------
@Module: config.php
This server-side module defines all required settings and dependencies for the application

@Author: 
@Date: 
-------------------------------------------------------------------------------------------------*/

    //define all required messages and commands for the session checking purpose
    //request and login/logout commands
    define ('CMD_REQUEST','request'); //the key to access submitted command via POST or GET
    define ('CMD_LOGIN', 'cmd_login');
    define ('CMD_LOGOUT', 'cmd_logout');
    
    //error messages    
    define ('DEBUG', false); //for debug mode set this to true
    define ('ERR_SUCCESS', '_OK_'); //no error, command is successfully executed
    define ('ERR_AUTHENTICATION', 'Wrong username or password');
    define ('ERR_DUPLICATE_USERNAME', 'The username entered is already in use.');
    
    //Perform session checking, if already logged in then just put user through.
    //Otherwise, show the login dialog box
    $php_version = phpversion();
    if (floatval($php_version) >= 5.4) 
    {    
        //need the session to start
        if (session_status() == PHP_SESSION_NONE) 
        {
            session_start();
        }
    } 
    else 
    {
        if (session_id() == '') 
        {
            session_start();
        }
    }

    /*We use 'authorised' as a keyword to identify if the user has not logged in
      if the keyword has not been set, check if this is the login session then continue
      if not simply terminate (a good security practice is to check for eligibility 
      before executing any php code)
    */
/*     if (empty($_SESSION['authorised'])) 
    {
        //no authorisation so check if user is trying to log in        
        if (empty($_REQUEST[CMD_REQUEST])||($_REQUEST[CMD_REQUEST] != CMD_LOGIN)) 
        { 
            //if no request or request is not a login request
            header("Location: login.php");
            //die();
        } 
    } */
    /* ... continue the execution otherwise ... 
    (this is a good security practice to check for the eligibility before executing any code)
    */
    
    //This is a good practice to define all constants which may be used at different places
    //define ('DB_CONNECTION_STRING', "mysql:host=localhost;dbname=db");
    //Replace the XXXXXXXXXXXX with database name user name and password etc.
    define ('DB_CONNECTION_STRING', "mysql:host=localhost;dbname=moviezone_db");
    define ('DB_USER', "root");
    define ('DB_PASS', "");
    define ('MSG_ERR_CONNECTION', "Open connection to the database first");
    
    //user request commands
    define ('CMD_SHOW_MOVIES_DROPDOWN', 'cmd_show_movies_dropdown'); //create and show movies dropdown
    define ('CMD_MOVIE_SELECT_ALL', 'cmd_movie_select_all');
    define ('CMD_MOVIE_DROPDOWN_SELECT', 'cmd_movie_dropdown_select'); //command to load the movies dropdown select box 
    //define ('CMD_SHOW_UPLOAD_FORM', 'cmd_show_upload_form'); //This is the modifed request command
    define ('CMD_LOAD_HOMEPAGE', 'cmd_load_homepage'); //command to load the homepage 
    define ('CMD_SEARCH_BY_ACTOR_DROPDOWN', 'cmd_search_by_actor_dropdown'); 
    define ('CMD_SEARCH_BY_ACTOR_DROPDOWN_SELECT', 'cmd_search_by_actor_dropdown_select'); 
    define ('CMD_SHOW_JOIN_FORM', 'cmd_show_join_form'); 
    define ('CMD_ADD_MEMBER', 'cmd_add_member'); 
    
    define ('CMD_LOAD_CONTACT', 'cmd_load_contact'); //command to load the homepage 
    define ('CMD_SHOW_ALL_MOVIES', 'cmd_show_all_movies'); //command to load the homepage
    define ('ERR_NO_MOVIES', "No movies found for ");
    
    //load the application modules
    require_once('dba.php');
    require_once('model.php');
    require_once('view.php');
    require_once('controller.php');
?>