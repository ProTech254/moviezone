<?php
/*-------------------------------------------------------------------------------------------------
@Module: login.php
This server-side module provides provides the login UI for user authentication

@Author: 
@Date: 
--------------------------------------------------------------------------------------------------*/
    
    /*Perform session checking, if already logged in then just put user through
      otherwise, show login dialog */
    $php_version = phpversion();
    if (floatval($php_version) >= 5.4) 
    {    
        //this starts the session
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

    if (isset($_SESSION['authorised'])) 
    {
        //we use 'authorised' keyword to identify if the user has not logged in
        //if the keyword has been set, simply redirect the user to the index page
        header("Location: index.php");
        die(); //and terminate
    }
    //otherwise, show the below login page
?>

<html>
    <head>
        <link rel='stylesheet' type='text/css' href='css/modal_dialog.css'>
        <script src="js/ajax.js"></script>
    </head>
<body>
    <!-- The Modal -->
    <div id='myModal' class='modal' style='padding-top: 150px;'>
        <form name='login'>
            <!-- Modal content -->
            <div class='modal-content' style='width: 500px;'>
                <div class='modal-header'>
                    <span>Login</span>
                </div>
                <div class='modal-body'>
                    Username: <input type='text' name='username' placeholder="Use any name"><br>
                    Password: <input type='password' name='password' placeholder="Use webdev2"><br>
                    <div id='id_error'></div>
                </div>
                <div class='modal-footer'>
                    <button type='button' name='btnOK' id='id_OK' onclick='login_btnOKClicked();'>OK</button> 
                    <button type='button' name='btnCancel' id='id_Cancel' onclick='login_btnCancelClicked();'>Cancel</button> 
                </div>
            </div>
        </form> 
    </div>
    <script>
        //simply goes back to the index file index.php. 
        //which then presents the login page if the user has not logged in.
        function login_btnCancelClicked() 
        {
            window.location.replace('index.php');
        }
        //send an ajax request to ask for server-side authentication
        function login_btnOKClicked() 
        {
            var formData = new FormData(document.login);
            makeAjaxPostRequest('main.php','cmd_login',formData, success);
        }
        //handle the server response.
        function success(data) 
        {
            //trim any whitespace from the data that may be present.
            data = data.trim();
            //ERR_SUCCESS == '_OK_' defined in config.php
            if (data == '_OK_') 
            { 
                //the replace function in javascript disables any history i.e. the back button will not work
                window.location.replace('index.php');
            } 
            else 
            {
                document.getElementById('id_error').innerHTML = data;
            }
        }
    </script>
</body>
</html>
