<?php
/*-------------------------------------------------------------------------------------------------
@Module: view.php

@Author: 
@Date: 
--------------------------------------------------------------------------------------------------*/
require_once('config.php'); 

class View {
    //Class contructor: performs any initialization
    public function __construct() {        
    }
    
    //Class destructor: performs any deinitialiation       
    public function __destruct() {        
    }
    
    //Creates left navigation panel
    public function leftNavPanel() {
        print file_get_contents('html/left_nav.html');
    }
    
    //Shows the home page
    public function showHomepage($movies) {
       
       
        //This loads the select box with movie ids and titles
       print '
            <div class="container mx-auto px-4 pt-16">
            <div class="popular-movies">
                 <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular Movies</h2>
                      
                      ';
                      foreach ($movies as $movie) 
                      
                      { 
                        $movie_id = $movie['movie_id'];
                        $title = substr($movie['title'], 0, 10);
                        $rental_period = $movie['rental_period'];
                        $year = $movie['year'];
                        $thumbpath = $movie['thumbpath'];
                        $classification = $movie['classification'];
                        $DVD_purchase_price = $movie['DVD_purchase_price'];

                        print "
                        <div class='grid grid-cols-8 sm:grid-cols-4 ' style='float:left;padding:8px;' >
                        <div class='mt-8'style='float:left;'>
                        <a href='#'>
                               <img src='img/Small/$thumbpath' alt='poster' class='hover:opacity-75 transition ease-in-out duration-150'>
                             </a>
                         <div class='mt-2'>
                       <a href='#' class='text-lg mt-2 hover:text-gray-300'> $title </a>
                       <div class='flex items-center text-gray-400 text-sm mt-1'>
                           <svg class='fill-current text-orange-500 w-4' viewBox='0 0 24 24'><g data-name='Layer 2'><path d='M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z' data-name='star'/></g></svg>
                           <span class='ml-1'>$classification</span>
                           <span class='mx-2'>|</span>
                           <span>$year</span>
                       </div>
                             <div class='text-gray-400 text-sm'>Rental: $rental_period </div>
                             <div class='text-gray-400 text-sm'>DVD_purchase_price: $DVD_purchase_price </div>
     </div>  ";

     print '
    </div>
    </div>
          ';
        }
        
    }
    
    //Shows the home page
    public function showContactpage() {
        print file_get_contents('html/contact.html');
    }

    public function showAllMoviespage($movies) {
       
        //This loads the select box with movie ids and titles
        print '

                  
                  ';
                  foreach ($movies as $movie) 
                  
                  { 
                    $movie_id = $movie['movie_id'];
                    $title = substr($movie['title'], 0, 20);
                    $rental_period = $movie['rental_period'];
                    $year = $movie['year'];
                    $thumbpath = $movie['thumbpath'];
                    $classification = $movie['classification'];
                    $DVD_purchase_price = $movie['DVD_purchase_price'];
       
                    print "
                    <div class='grid grid-cols-8 sm:grid-cols-4 ' style='float:left;padding:8px;' >
                    <div class='mt-8'style='float:left;'>
                    <a href='#'>
                           <img src='img/Small/$thumbpath' alt='poster' class='hover:opacity-75 transition ease-in-out duration-150'>
                         </a>
                     <div class='mt-2'>
                   <a href='#' class='text-lg mt-2 hover:text-gray-300'> $title </a>
                   <div class='flex items-center text-gray-400 text-sm mt-1'>
                       <svg class='fill-current text-orange-500 w-4' viewBox='0 0 24 24'><g data-name='Layer 2'><path d='M17.56 21a1 1 0 01-.46-.11L12 18.22l-5.1 2.67a1 1 0 01-1.45-1.06l1-5.63-4.12-4a1 1 0 01-.25-1 1 1 0 01.81-.68l5.7-.83 2.51-5.13a1 1 0 011.8 0l2.54 5.12 5.7.83a1 1 0 01.81.68 1 1 0 01-.25 1l-4.12 4 1 5.63a1 1 0 01-.4 1 1 1 0 01-.62.18z' data-name='star'/></g></svg>
                       <span class='ml-1'>$classification</span>
                       <span class='mx-2'>|</span>
                       <span>$year</span>
                   </div>
                         <div class='text-gray-400 text-sm'>Rental: $rental_period </div>
                         <div class='text-gray-400 text-sm'>DVD_purchase_price: $DVD_purchase_price </div>
 </div>  ";

 print '
</div>
</div>
      ';
    }
    }

    public function showJoinForm() {
        print file_get_contents('html/join_form.html');
    }
    
    //Creates the dropdown select box to select a movie   
    public function moviesDropdownLoad($movies) 
    {
        print "
        <div style='color: #0e5968; float:left;'>
            <div class='topnav'>
            <label for='movie'><b>Movies:</b></label><br>
            <select name='movie' id='id_movie' onchange='movieDropdownChanged();'>
                <option value='all'>Select all</option>
        ";
        //This loads the select box with movie ids and titles
        foreach ($movies as $movie) 
        {            
            print "<option value=".$movie['movie_id'].">".$movie['title']."</option>";
        }
        
        print "
            </select>
            </div>
        </div>
        ";
    }

    //Creates the dropdown select box to select an actor 
    public function actorDropdownLoad($actors) 
    {
        print "
        <div style='color: #0e5968; float:left;'>
            <div class='topnav'>
            <label for='actors'><b>Actors:</b></label><br>
            <select name='actors' id='id_actor' onchange='actorDropdownChanged();'>
                <option value='all'>Select all</option>
        ";
        //This loads the select box with actor ids and names
        foreach ($actors as $actor) 
        {            
            print "<option value=".$actor['actor_id'].">".$actor['actor_name']."</option>";
        }
        
        print "
            </select>
            </div>
        </div>
        ";
    }


    /*Displays error message
    */
    public function showError($error) 
    {
        print "<h3 style='color: red'>Error: $error</h3>";
    }

    //Displays an array of movies. However there will only be one movie in the array.
    public function showMovie($movie_array) 
    {
        $id = $movie_array[0]['movie_id'];
        $title = $movie_array[0]['title'];
        print "<br><br>";
        print "<h3>".$title."</h3>";
        if (!empty($movie_array)) 
        {
            
            $this->printMovieInHtmlStart();
            foreach ($movie_array as $movie) 
            {
                //print_r ($movie);
                print ('<br><br>');
                $this->printMovieInHtml($movie);
            }
            $this->printMovieInHtmlEnd();
        }
    }
    
    //Displays an array of movies associated with an actor.
    public function showActorMovie($actor_movie_array, $actor_name) 
    {
        print ("<br><br><br>");
        //print ($actor_name);
        //print_r ($actor_movie_array);
        print "<br><br>";
        if (!empty($actor_movie_array)) 
        {
            print_r ($actor_movie_array);
            print ('<h2>Movies with '.$actor_name.'</h2>');
            $this->printMovieInHtmlStart();
            foreach ($actor_movie_array as $actor_movie) 
            {
                $this->printMovieInHtml($actor_movie);
            }
            $this->printMovieInHtmlEnd();
        }
        else
        {
            print ('<h2>No movies found with '.$actor_name.'</h2>');
        }
    }
    
    public function printMovieInHtmlStart() 
    {
        print "
        <table style='border: 1px solid red; border-collapse: collapse'>
            <caption>This is simply a few of the movie items output in html table format.</caption>
            <tr>
                <th style='border: 1px solid red'>Movie Id</th>
                <th style='border: 1px solid red'>Title</th>
                <th style='border: 1px solid red'>Tagline</th>
                <th style='border: 1px solid red'>Thumbpath</th>
                <th style='border: 1px solid red'>Year</th>
            </tr>
        ";
    }        
    
    public function printMovieInHtml($movie) 
    {        
        $movie_id = $movie['movie_id'];
        $title = $movie['title'];
        $tagline = $movie['tagline'];
        $plot = $movie['plot'];
        $thumbpath = $movie['thumbpath'];
        $star1 = $movie['star1'];
        $star2 = $movie['star2'];
        $star3 = $movie['star3'];
        $costar1 = $movie['costar1'];
        $costar2 = $movie['costar2'];
        $costar3 = $movie['costar2'];
        $director = $movie['director'];
        $studio = $movie['studio'];
        $genre = $movie['genre'];
        $classification = $movie['classification'];
        $rental_period = $movie['rental_period'];
        $year = $movie['year'];
        $DVD_rental_price = $movie['DVD_rental_price'];
        $DVD_purchase_price = $movie['DVD_purchase_price'];
        $numDVD = $movie['numDVD'];
        $numDVDout = $movie['numDVDout'];
        $BluRay_rental_price = $movie['BluRay_rental_price'];
        $BluRay_purchase_price = $movie['BluRay_purchase_price'];
        $numBluRay = $movie['numBluRay'];
        $numBluRayOut = $movie['numBluRayOut'];

        print "
            <tr>
                <td style='border: 1px solid red'>$movie_id</td>
                <td style='border: 1px solid red'>$title</td>
                <td style='border: 1px solid red'>$tagline</td>
                <td style='border: 1px solid red'>$thumbpath</td>
                <td style='border: 1px solid red'>$year</td>
            </tr>
        ";
    }
    
    public function printmovieInHtmlEnd() 
    {        
        print "</table>";
    }
}

?>