/*-------------------------------------------------------------------------------------------------
@Module: template.js

@Author: 
@Date: 
--------------------------------------------------------------------------------------------------*/

//global variable if we are in editing mode. (Not used in this app) 
var editing_mode; 

//Use the onload event to load the default page
window.addEventListener("load", function() 
{
    makeAjaxGetRequest('main.php','cmd_load_homepage', null, updateContent);
    editing_mode = false; //default when loaded
});

//Updates the content area if successful
function updateContent(data) 
{
    document.getElementById('id_content').innerHTML = data;
}

//Updates the top navigation panel in the content area
function updateTopNav(data=null) 
{
    var topnav = document.getElementById('id_topnav');
    if (data != null) 
    {
        topnav.innerHTML = data;
        topnav.style.display = "inherit";
    } 
    else 
    {
        topnav.innerHTML = '';
        topnav.style.display = "none";        
    }
}

//Loads the home page into the content area.
function homePageClick() 
{
    makeAjaxGetRequest('main.php','cmd_load_homepage', null, function(data) 
    {        
        updateTopNav(); //resets and hides the search box    
        updateContent(data); //loads the home page to the content area
    });        
}

//Loads the home page into the content area.
function selectContactBtnClick() 
{
    makeAjaxGetRequest('main.php','cmd_load_contact', null, function(data) 
    {        
        updateTopNav(); //resets and hides the search box    
        updateContent(data); //loads the home page to the content area
    });  
       
}

//Loads the selectct a movie content into the main content area.
function selectMovieBtnClick() 
{
    makeAjaxGetRequest('main.php', 'cmd_show_movies_dropdown', null, function(data) 
    {        
        updateTopNav(); //reset and hide the search box    
        updateContent(data); //load the Upload Student List form to the content area
    });        
}

function allMoviesBtnClick() 
{
    makeAjaxGetRequest('main.php', 'cmd_show_all_movies', null, function(data) 
    {        
        updateTopNav(); //reset and hide the search box    
        updateContent(data); //load the Upload Student List form to the content area
    });        
}



function searchByActorBtnClick() 
{
    //alert ("searchByActorBtnClick");
    makeAjaxGetRequest('main.php', 'cmd_search_by_actor_dropdown', null, function(data) 
    {        
        updateTopNav(); //reset and hide the search box    
        updateContent(data); //load the Upload Student List form to the content area
    });        
}

function joinBtnClick() 
{
    //alert ("joinBtnClick");
    makeAjaxGetRequest('main.php', 'cmd_show_join_form', null, function(data) 
    {        
        updateTopNav(); //reset and hide the search box    
        updateContent(data); //load the join form
    });        
}

//exit to the main app
function exitClick() 
{
    if (editing_mode)
    {
        if (confirm("Data is not saved. Are you sure you want to exit?") == false)
        {
            return;  
        }
    }
    //Logs out the user
    makeAjaxGetRequest('main.php','cmd_logout', null, function(data) 
    {
        if (data == '_OK_') 
        {
            editing_mode = false;
            window.location.replace('index.php');
        }        
    });    
}

//Handles the onchange event when an item in the dropdown box is selected
function movieDropdownChanged() 
{
    var movie_id = document.getElementById('id_movie').value;
    var params = '';
    if (movie_id != 'all')
    {
        params += '&movie_id=' + movie_id;
    }
    makeAjaxGetRequest('main.php', 'cmd_movie_dropdown_select', params, updateContent);
}

//Handles the onchange event when an item in the dropdown box is selected
function actorDropdownChanged() 
{
    var actor = document.getElementById('id_actor');
    var actor_id = actor.options[actor.selectedIndex].value;
    var actor_name = actor.options[actor.selectedIndex].text;
    var params = '';
    if (actor_id != 'all')
    {
        params += '&actor_id=' + actor_id;
        params += '&actor_name=' + actor_name;
    }
    //alert (params);
    makeAjaxGetRequest('main.php', 'cmd_search_by_actor_dropdown_select', params, updateContent);
}

// Write the member details to the database
function addNewMemberToDatabase(memberData)
{
    //alert('template.js - about to call ajax post');
    makeAjaxPostRequest('main.php','cmd_add_member', memberData, function(data) 
    {
        //get the username from the formdata i.e. memberData
        var username = memberData.get('username');
        //trim any white space
        data = data.trim();
        if (data == '_OK_')
        {
            var str = 'The username entered has been added to the database.';
            var str = str.replace("entered", "'" + username + "'");
            alert(str);
            str = "<h3 style='color: red'>Success: " + str + "</h3>";
            updateFormFeedback(str);
            document.newMember.reset();  //reset form
        }
        else
        {
            var str = data;
            str = str.replace("<h3 style='color: red'>", "");
            str = str.replace("</h3>", "");
            str = str.replace("entered", "'" + username + "'");
            alert(str);
            data = data.replace("entered", "'" + username + "'");
            updateFormFeedback(data);
            document.newMember.username.select();
        }
    });   
}
