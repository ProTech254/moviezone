<?php
/*-------------------------------------------------------------------------------------------------
@Module: controller.php
This server-side module provides all required functionality to process request commands

@Author: 
@Date: 
--------------------------------------------------------------------------------------------------*/

require_once('config.php'); 

class Controller {
    private $model;
    private $view;
    
    //Class contructor
    public function __construct($model, $view) 
    {
        $this->model = $model;
        $this->view = $view;
    }
    
    //Class destructor
    public function __destruct() 
    {
        $this->model = null;
        $this->view = null;
    }
    
    // This Processes user requests and calls the corresponding functions
    // The request and data are submitted via POST or GET methods
    public function processRequest($request) 
    {
        switch ($request) 
        {
            case CMD_LOGIN: 
                $this->handleAdminLoginRequest();
                break;
            case CMD_LOGOUT: 
                $this->handleAdminLogoutRequest();
                break;            
            case CMD_SHOW_MOVIES_DROPDOWN: //this loads the movies drop down box
                $this->loadMoviesDropdown();
                break;
            case CMD_MOVIE_DROPDOWN_SELECT: //this runs when a user selects a movie in the movies drop down box
                $this->loadMoviesDropdown(); //this re-loads the movies drop down box to allow the user to select another movie
                $this->handleSelectedMovieRequest(); //this handles the user's choice when they select a movie
                break;
            case CMD_LOAD_HOMEPAGE:
                $this->handleLoadHomepageRequest();
                break;    
            case CMD_SEARCH_BY_ACTOR_DROPDOWN: //this loads the actors drop down box
                $this->loadActorDropdown();
                break;

            case CMD_SHOW_ALL_MOVIES: //this runs when a user selects an actor in the actors drop down box
                $this->handleShowAllMoviesRequest(); //this handles the user's choice when they select an actor
                break;
				
            case CMD_SEARCH_BY_ACTOR_DROPDOWN_SELECT: //this runs when a user selects an actor in the actors drop down box
                $this->loadActorDropdown(); //this re-loads the actors drop down box to allow the user to select another actor
                $this->handleSelectedActorRequest(); //this handles the user's choice when they select an actor
                break;
            case CMD_SHOW_JOIN_FORM: //this runs when a user clicks the join button
                $this->handleShowJoinFormRequest(); //this shows the join form
                break;
            case CMD_ADD_MEMBER: //this runs when a user submits the join form button and the data is valid
                $this->handleAddMember(); //this returns an error if the username is already in use otherwise it processes the data and adds new member details to the database
                break;
				
            case CMD_LOAD_CONTACT:
                $this->handleLoadContactPageRequest();
                break; 
				
            default:
                break;
        }
    }
    
    //Loads the left navigation panel
    public function loadLeftNavPanel() 
    {
        $this->view->leftNavPanel();
    }

    //Loads the homepage
    public function handleLoadHomepageRequest() 
    {
         $movies = $this->model->selectAllMovies();
        if (($movies != null)) 
        {
            $this->view->showHomepage($movies);
        }
        else 
        {
            $error = $this->model->getError();
            if (!empty($error))
            {
                $this->view->showError($error);
            }
        }
    }
	
    //Loads the contact page
    public function handleLoadContactPageRequest() 
    {
        $this->view->showContactpage();
    }

    //Loads the contact page
    public function handleShowAllMoviesRequest() 
    {
        $movies = $this->model->selectAllMovies();
        if (($movies != null)) 
        {
            $this->view->showAllMoviespage($movies);
        }
        else 
        {
            $error = $this->model->getError();
            if (!empty($error))
            {
                $this->view->showError($error);
            }
        }
    }

    //Loads the top navigation panel
    public function loadMoviesDropdown() 
    {
        $movies = $this->model->selectAllMovies();
        if (($movies != null)) 
        {
            $this->view->moviesDropdownLoad($movies);
        }
        else 
        {
            $error = $this->model->getError();
            if (!empty($error))
            {
                $this->view->showError($error);
            }
        }
    }    
    
    //Loads the top navigation panel actor dropdown
    public function loadActorDropdown() 
    {
        $actors = $this->model->selectAllActors();
        if (($actors != null)) 
        {
            $this->view->actorDropdownLoad($actors);
        }
        else 
        {
            $error = $this->model->getError();
            if (!empty($error))
            {
                $this->view->showError($error);
            }
        }
    }
    
    // Notifies client machine about the outcome of operations
    // This is used for M2M communication when Ajax is used.
    private function notifyClient($code) 
    {
        // simply prints out the notification code for now
        // but in the future JSON can be used to encode the
        // communication protocol between the client and server        
        print $code;
    }
    
    // Notifies client machine about the outcome of operations
    // This is used for M2M communication when Ajax is used.
    private function sendJSONData($data) 
    {
        //using JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    //Handles admin login request
    private function handleAdminLoginRequest() 
    {
        //take username and password and perform authentication
        //if successful, initialize the user session
        $keys = array('username','password');
        //retrive the submiteed data
        $user = array();
        foreach ($keys as $key) 
        {
            if (!empty($_REQUEST[$key])) 
            {
                //more server side checking can be done here
                $user[$key] = $_REQUEST[$key];
            } 
            else 
            {
                //check required field
                $this->view->showError($key.' cannot be blank');
                return;
            }
        }            
        
        $result = $this->model->adminLogin($user);
        
        if ($result) 
        {
            //authorise user with the username to access            
            $_SESSION['authorised'] = $user['username']; 
            
            // and notify the caller about the successful login
            // the notification protocol should be predefined so
            // the client and server can understand each other

            $this->notifyClient(ERR_SUCCESS); //send '_OK_' code to client
        } 
        else 
        {
            //not successful show error to user
            $error = $this->model->getError();
            if (!empty($error))
            {
                $this->view->showError($error);
            }
        }        
    }

    //Handles logout request
    private function handleAdminLogoutRequest() 
    {
        // Unset all of the session variables.
        $_SESSION = array();
        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) 
        {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        // Finally, destroy the session.
        session_destroy();
        //send '_OK_' code to client        
        $this->notifyClient(ERR_SUCCESS);
    }
    
    //Handles selected movie request.
    public function handleSelectedMovieRequest() 
    {
        $selectedMovie = array();
        if (!empty($_REQUEST['movie_id']))
        {
            $selectedMovie['movie_id'] = $_REQUEST['movie_id'];
        }
        $movie = $this->model->selectedMovie($selectedMovie);
        if ($movie != null) 
        {
            $this->view->showMovie($movie);
        } 
        else 
        {
            $error = $this->model->getError();
            if (!empty($error))
            {
                $this->view->showError($error);
            }
        }        
    }
    
    //Handles selected actor movie request.
    public function handleSelectedActorRequest() 
    {
        //print_r ($_REQUEST);
        //create an empty array
        $selectedActor = array();
        
        if (!empty($_REQUEST['actor_id']))
        {
            //fill the array
            $selectedActor['actor_id'] = $_REQUEST['actor_id'];
            $selectedActor['actor_name'] = $_REQUEST['actor_name'];
        }
        //print_r ($selectedActor);
        $actor = $this->model->selectedActor($selectedActor);
        $actor_name = $selectedActor['actor_name'];
        //print($actor_name);
        if ($actor != null) 
        {
            $this->view->showActorMovie($actor, $actor_name);
        } 
        else 
        {
            $error = $this->model->getError();
            if (!empty($error))
            {
                $this->view->showError($error);
            }
        }        
    }
    
    //Handles show join form request.
    public function handleShowJoinFormRequest() 
    {
        $this->view->showJoinForm();
    }
   
    //  Handles add new member - data has been validated
    private function handleAddMember()
    {
        //create an empty array
        $member = array();
        //fill the array will member details in the $_REQUEST array
        $member['surname'] = $_REQUEST['last_name'];
        $member['other_name'] = $_REQUEST['first_name'];
        $member['contact'] = $_REQUEST['contact'];
        $member['mobile'] = $_REQUEST['mobile'];
        $member['landline'] = $_REQUEST['landline'];
        $member['email'] = $_REQUEST['email'];
        $member['occupation'] = $_REQUEST['occupation'];
        $member['magazine'] = $_REQUEST['magazine'];
        $member['street_addr'] = $_REQUEST['street_addr'];
        $member['suburb_state'] = $_REQUEST['suburb_state'];
        $member['postcode'] = $_REQUEST['postcode'];
        $member['username'] = $_REQUEST['username'];
        $member['password'] = $_REQUEST['password'];   

        $result = $this->model->addMemberModel($member);

        if ($result != null)
        {
            $this->notifyClient(ERR_SUCCESS);       
        }
        else
        {
            $error = $this->model->getError();
            if (!empty($error))
            {
                $this->view->showError($error);
            }
        }
    }
}
?>