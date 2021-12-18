<?php
/*-------------------------------------------------------------------------------------------------
@Module: dba.php
This module acts as the database abstraction layer for the application

@Author: 
@Date: 
-------------------------------------------------------------------------------------------------*/
//The connection paramaters are set in config.php
require_once('config.php'); 

// The DBAdpater class performs all required CRUD (i.e. Create, Read, Update, and Delete) functions for the application
class DBAdapter {
    //local member variables    
    private $dbConnectionString;
    private $dbUser;
    private $dbPassword;
    private $dbConn; //holds the connection object
    private $dbError; //holds the last error message
    
    // The class constructor    
    public function __construct($dbConnectionString, $dbUser, $dbPassword) 
    {
        $this->dbConnectionString = $dbConnectionString;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
    }    

    //Opens a connection to the database
    public function dbOpen() 
    {
        $this->dbError = null; //resets the error message before any execution
        try 
        {
            $this->dbConn = new PDO($this->dbConnectionString, $this->dbUser, $this->dbPassword);
            // sets the PDO error mode to exception
            $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
        }
        catch(PDOException $e) 
        {
            $this->dbError = $e->getMessage().'<br>In file: '.$e->getFile().'<br>Thrown on line: '.$e->getLine();
            $this->dbConn = null;
        }
    }

    //Closes connection to the database
    public function dbClose() 
    {
        //in PDO assigning null to the connection object closes the connection
        $this->dbConn = null;
    }

    //Returns the  last database error
    public function lastError() 
    {
        return $this->dbError;
    }

    //Returns the database connection so it can be accessible outside the dbAdapter class
    public function getDbConnection() 
    {
        return $this->dbConn;
    }
    
    /*------------------------------------------------------------------------------------------- 
                              DATABASE MANIPULATION FUNCTIONS
    -------------------------------------------------------------------------------------------*/
    //This gets the movie titles to load into the dropdown box
    public function get_movies() 
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->dbConn != null) 
        {        
            try 
            {
                //Make a prepared query so that we can use data binding and avoid SQL injections. 
                $smt = $this->dbConn->prepare(
                    'SELECT *
                    FROM `movie_detail_view` 
                    GROUP BY movie_id
                    ORDER BY title ASC'
                    );                                              
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);    
                //use PDO::FETCH_BOTH to have both column name and column index
                //i.e. $result = $sql->fetchAll(PDO::FETCH_BOTH);
            }
            catch (PDOException $e) 
            {
                //Return the error message to the caller
                $this->dbError = $e->getMessage().'<br>In file: '.$e->getFile().'<br>Thrown on line: '.$e->getLine();
                $result = null;
            }
        } 
        else 
        {
            $this->dbError = MSG_ERR_CONNECTION;
        }
        return $result;            
    }

    //This gets the movie data to display to the user
    public function get_selected_movie($condition) {
        $movieID = $condition['movie_id'];
        $result = null;
        $this->dbError = null; //resets the error message before any execution
        if ($this->dbConn != null) 
        {        
            try 
            {
                //Make a prepared query so that we can use data binding and avoid SQL injections. 
                $smt = $this->dbConn->prepare(                                              
                    'SELECT *
                    FROM movie_detail_view 
                    WHERE movie_id = '.$movieID.'
                    ORDER BY title ASC, year'
                    );
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);    
                //use PDO::FETCH_BOTH to have both column name and column index
                //i.e. $result = $sql->fetchAll(PDO::FETCH_BOTH);
            }
            catch (PDOException $e) 
            {
                //Returns the error message to the caller
                $this->dbError = $e->getMessage().'<br>In file: '.$e->getFile().'<br>Thrown on line: '.$e->getLine();
                $result = null;
            }
        } else {
            $this->dbError = MSG_ERR_CONNECTION;
        }
        return $result;            
    }

    //This gets the actor movie data to display to the user
    public function get_selected_actor_movies($condition) {
        $actorID = $condition['actor_id'];
        $actor_name = $condition['actor_name'];
        $result = null;
        $this->dbError = null; //resets the error message before any execution
        if ($this->dbConn != null) 
        {        
            try 
            {
                //Make a prepared query so that we can use data binding and avoid SQL injections. 
                $smt = $this->dbConn->prepare(                                              
                    "SELECT *
                    FROM movie_detail_view 
                    WHERE 
                    star1 = '{$actor_name}' OR 
                    star2 = '{$actor_name}' OR 
                    star3 = '{$actor_name}' OR
                    costar1 = '{$actor_name}' OR 
                    costar2 = '{$actor_name}' OR 
                    costar3 = '{$actor_name}'
                    ORDER BY title ASC, year"                   
                    );
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);    
                //use PDO::FETCH_BOTH to have both column name and column index
                //i.e. $result = $sql->fetchAll(PDO::FETCH_BOTH);
            }
            catch (PDOException $e) 
            {
                //Returns the error message to the caller
                $this->dbError = $e->getMessage().'<br>In file: '.$e->getFile().'<br>Thrown on line: '.$e->getLine();
                $result = null;
            }
        } else {
            $this->dbError = MSG_ERR_CONNECTION;
        }
        return $result;            
    }

    //This gets the actors to load into the dropdown box
    public function get_actors() 
    {
        $result = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->dbConn != null) 
        {        
            try 
            {
                //Make a prepared query so that we can use data binding and avoid SQL injections. 
                $smt = $this->dbConn->prepare(
                    'SELECT actor_id, actor_name
                    FROM `actor` 
                    ORDER BY actor_name ASC'
                    );                                              
                //Execute the query
                $smt->execute();
                $result = $smt->fetchAll(PDO::FETCH_ASSOC);    
                //use PDO::FETCH_BOTH to have both column name and column index
                //i.e. $result = $sql->fetchAll(PDO::FETCH_BOTH);
            }
            catch (PDOException $e) 
            {
                //Return the error message to the caller
                $this->dbError = $e->getMessage().'<br>In file: '.$e->getFile().'<br>Thrown on line: '.$e->getLine();
                $result = null;
            }
        } 
        else 
        {
            $this->dbError = MSG_ERR_CONNECTION;
        }
        //print_r($result);
        return $result;            
    }
    
    /*  This module adds the new member data to the database
    */
    public function memberAddDB($member)
    {
        $success = null;
        $this->dbError = null; //reset the error message before any execution
        if ($this->dbConn != null) 
        {		
            //Try and insert the member, if there is a DB exception return
            //the error message to the caller.
            try 
            {
                //Make a prepared query so that we can use data binding and avoid SQL injections. 
                $smt = $this->dbConn->prepare('INSERT INTO member 
                (surname, other_name, contact_method, email, mobile, landline, magazine, 
                street, suburb, postcode, username, password, occupation, join_date) VALUES
                (:surname, :other_name, :contact_method, :email, :mobile, :landline, :magazine, 
                :street, :suburb, :postcode, :username, :password, :occupation, CURRENT_DATE())');

                //Bind the data from the form to the query variables.
                //Doing it this way means PDO sanitises the input which prevents SQL injection.
                $smt->bindParam(':surname', $member['surname'], PDO::PARAM_STR);
                $smt->bindParam(':other_name', $member['other_name'], PDO::PARAM_STR);				
                $smt->bindParam(':contact_method', $member['contact'], PDO::PARAM_STR); 
                $smt->bindParam(':email', $member['email'], PDO::PARAM_STR);
                $smt->bindParam(':mobile', $member['mobile'], PDO::PARAM_STR);
                $smt->bindParam(':landline', $member['landline'], PDO::PARAM_STR);
                $smt->bindParam(':magazine', $member['magazine'], PDO::PARAM_INT);				
                $smt->bindParam(':street', $member['street_addr'], PDO::PARAM_STR);			
                $smt->bindParam(':suburb', $member['suburb_state'], PDO::PARAM_STR); 
                $smt->bindParam(':postcode', $member['postcode'], PDO::PARAM_INT);
                $smt->bindParam(':username', $member['username'], PDO::PARAM_STR);
                $smt->bindParam(':password', $member['password'], PDO::PARAM_STR);
                $smt->bindParam(':occupation', $member['occupation'], PDO::PARAM_STR);		

                //Execute the query and thus insert the car
                $smt->execute();
                $success = null;
                $success = $this->dbConn->lastInsertId();				
            }
            catch (PDOException $e) 
            {
                //Return the error message to the caller
                //The error code for a duplicate entry on a unique database field is 23000
                //DEBUG is defined in config.php
                if(DEBUG)
                {
                    $this->dbError = $e->getMessage().'<br>In file: '.$e->getFile().'<br>Thrown on line: '.$e->getLine().'<br>'.ERR_DUPLICATE_USERNAME;
                }
                elseif($e->getCode() == 23000)
                {
                    $this->dbError = ERR_DUPLICATE_USERNAME; //$e->getMessage().'<br>'.$e->getCode();
                }
                $success = null;
            }
        } 
        else 
        {
        $this->dbError = MSG_ERR_CONNECTION;
        }	
        return $success;
    }
}

//this is a test function to test methods in the dba class
function testDBA() {
	$dbAdapter = new DBAdapter(DB_CONNECTION_STRING, DB_USER, DB_PASS);
	
	$dbAdapter->dbOpen();
	
    //set the result to each of the dba methods defined in the DBAdapter class 
    $result = $dbAdapter->get_movies();
	//$result = $dbAdapter->get_actors();	
	
	if ($result != null)
    {        
		print_r($result);
    }
	else
    {
		echo $dbAdapter->lastError();
    }
	$dbAdapter->dbClose();
}

//Use this to execute the test. Comment testDBA(); out when you don't want it to run.
//testDBA();

?>
