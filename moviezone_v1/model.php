<?php
/*-------------------------------------------------------------------------------------------------
@Module: model.php

@Author: 
@Date: 
--------------------------------------------------------------------------------------------------*/
require_once('config.php');

class Model {
    private $error;
    private $dbAdapter;
    
    // Add initialization code here
    public function __construct(){
        $this->dbAdapter = new DBAdapter(DB_CONNECTION_STRING, DB_USER, DB_PASS);
    }
    
    // Add code to free any unused resource    
    public function __destruct(){
        $this->dbAdapter->dbClose();
    }
    
    //Returns last error
    public function getError(){
        return $this->error;
    }
    
    //Authenticates the user.       
    public function adminLogin($user){
        //for now we simply accept anyone with webdev2 password
        if ($user['password'] == 'webdev2') 
        {
            $this->error = ERR_SUCCESS;            
            return true;
        } 
        else 
        {
            $this->error = ERR_AUTHENTICATION;
            return false;
        }
    }

    //Returns the list of movies
    public function selectAllMovies(){
        $this->error = null; //reset the error first
        $this->dbAdapter->dbOpen();
        $result = $this->dbAdapter->get_movies();
        $this->dbAdapter->dbClose();
        if ($result == null)
        {
            $this->error = $this->dbAdapter->lastError();
        }
        return $result;        
    }
    
    //Returns the selected movie
    public function selectedMovie($condition) {
        $this->error = null; //reset the error first
        $this->dbAdapter->dbOpen();
        $result = $this->dbAdapter->get_selected_movie($condition);
        $this->dbAdapter->dbClose();
        if ($result == null)
        {
            $this->error = $this->dbAdapter->lastError();
        }
        return $result;        
    }
    
    //Returns the list of actors
    public function selectAllActors(){
        $this->error = null; //reset the error first
        $this->dbAdapter->dbOpen();
        $result = $this->dbAdapter->get_actors();
        $this->dbAdapter->dbClose();
        if ($result == null)
        {
            $this->error = $this->dbAdapter->lastError();
        }
        return $result;        
    }
    
    //Returns the selected actor
    public function selectedActor($condition) {
        $this->error = null; //reset the error first
        $this->dbAdapter->dbOpen();
        $result = $this->dbAdapter->get_selected_actor_movies($condition);
        $this->dbAdapter->dbClose();
        if ($result == null)
        {
            $this->error = $this->dbAdapter->lastError();
            if(empty($this->error))
            {
                print("<br><br><br>");
                print("<h2>".ERR_NO_MOVIES." actor ".$condition['actor_name']."</h2>");
            }
        }

        return $result;        
    }
    
    /* Add a new member
    */
    public function addMemberModel($member)
    {
        $this->dbAdapter->dbOpen();
        $result = $this->dbAdapter->memberAddDB($member);
        $this->dbAdapter->dbClose();
        $this->error = $this->dbAdapter->lastError();		
        return $result;	
    }
}
?>