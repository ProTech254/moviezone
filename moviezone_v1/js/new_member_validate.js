/* ----------------------------------------------------------------------------------------------
    Moviezone new member form validation with javascript
Author 
Date 1 Sep 2018
-----------------------------------------------------------------------------------------------*/

// changes required status when contact radion button pushed
function preferredContactClick(contact)
{
    var mobileMarker = document.getElementById('mobileMarker');
    var landlineMarker = document.getElementById('landlineMarker');
    var emailMarker = document.getElementById('emailMarker');

    // remove all contact markers
    mobileMarker.style.visibility = "hidden";
    landlineMarker.style.visibility = "hidden";
    emailMarker.style.visibility = "hidden";

    // show correct marker

    switch (contact)
    {
        case 'mobile':
            mobileMarker.style.visibility = 'visible';
            document.newMember.mobile.focus().select();
            break;
        case 'landline':
            landlineMarker.style.visibility = 'visible';
            document.newMember.landline.focus().select();
            break;
        case 'email':
            emailMarker.style.visibility = 'visible';
            document.newMember.email.focus().select();
            break;
        default:
            alert("Something went wrong. Contact value is " + contact);
            break;
    }
}

// changes required status when magazine_checkbox clicked
function magazine_checkboxClick()
{
    //I'm working here.
    var checkedvalue = document.getElementById('magazine_checkbox').checked;
    var streetMarker = document.getElementById('streetMarker');
    var suburbMarker = document.getElementById('suburbMarker');
    var postcodeMarker = document.getElementById('postcodeMarker');
      
    if (checkedvalue) // magazine_checkbox selected
    {
        //alert(checkedvalue);
        // show all address markers
        streetMarker.style.visibility = 'visible';
        suburbMarker.style.visibility = 'visible';
        postcodeMarker.style.visibility = 'visible';
        document.newMember.magazine.value = 1;
        document.newMember.street_addr.select();
    }
    else
    {
        //alert(checkedvalue);
        // hide all markers
        streetMarker.style.visibility = 'hidden';
        suburbMarker.style.visibility = 'hidden';
        postcodeMarker.style.visibility = 'hidden';
        document.newMember.magazine.value = 0;
        document.newMember.street_addr.value = null;
        document.newMember.suburb_state.value = null;
        document.newMember.postcode.value = null;
        document.newMember.street_addr.select();
    }
}

// This validates new member form before attempting to add to database
// Is called when join_button pressed
function validateMemberForm()
{
    //alert('validateMemberForm method');  // test to see if redirects here
    var test = checkForm(); // checks for empty fields and password/password2 match

    if(test)
    {
        var test2 = validateMember(); // do further testing using regex
        //alert (test2);
        if(test2)
        {
            updateFormFeedback(null);
            //alert('regex testing valid');
            var memberData = new FormData(document.newMember);
            myTest = memberData.entries();
            // Display the key/value pairs
            for(var pair of myTest) 
            {
               //alert(pair[0]+ ', '+ pair[1]); 
            }
            addNewMemberToDatabase(memberData);              
        }
    }
}

function checkForm()  // checks that all required fields are not empty
{
    if (document.newMember.last_name.value == "") 
    {
        alert("Last Name field cannot be empty.");
        updateFormFeedback("<h3 style='color: red'>Error: Last Name field cannot be empty.</h3>");
        document.newMember.last_name.focus();
        return false;
    }

    if (document.newMember.first_name.value == "") 
    {
        alert("First Name field cannot be empty.");
        updateFormFeedback("<h3 style='color: red'>Error: First Name field cannot be empty.</h3>");
        document.newMember.first_name.focus();
        return false;
   }
    
    if (document.newMember.contact.value == "") 
    {
        alert("Please select your preferred contact method.");
        updateFormFeedback("<h3 style='color: red'>Error: Please select your preferred contact method.</h3>");
        document.newMember.contact.focus();
        return false;
    }

    if ((document.newMember.contact.value == "mobile") && (document.newMember.mobile.value == "")) 
    {
        alert("Please enter a mobile number.");
        updateFormFeedback("<h3 style='color: red'>Error: Please enter a mobile number.</h3>");
        document.newMember.mobile.focus();
        return false;
    }

    if ((document.newMember.contact.value == "landline") && (document.newMember.landline.value == "")) 
    {
        alert("Please enter a landline number.");
        updateFormFeedback("<h3 style='color: red'>Error: Please enter a landline number.</h3>");
        document.newMember.landline.focus();
        return false;
    }

    if ((document.newMember.contact.value == "email") && (document.newMember.email.value == "")) 
    {
        alert("Please enter a valid email address.");
        updateFormFeedback("<h3 style='color: red'>Error: Please enter a valid email address.</h3>");
        document.newMember.email.focus();
        return false;
    }

    if (document.newMember.occupation.value == "Select your occupation")
    {
        alert("Please enter your occupation.");
        updateFormFeedback("<h3 style='color: red'>Error: Please enter your occupation.</h3>");
        document.newMember.occupation.focus();
        return false;
    }
    
    if ((document.newMember.magazine_checkbox.checked == true) && (document.newMember.street_addr.value == "")) 
    {
        alert("Please enter the house number and street address.");
        updateFormFeedback("<h3 style='color: red'>Error: Please enter the house number and street address.</h3>");
        document.newMember.street_addr.focus();
        return false;
    }

    if ((document.newMember.magazine_checkbox.checked == true) && (document.newMember.suburb_state.value == "")) 
    {
        alert("Please enter a suburb and state separated by a comma.");
        updateFormFeedback("<h3 style='color: red'>Error: Please enter a suburb and state separated by a comma.</h3>");
        document.newMember.suburb_state.focus();
        return false;
    }

    if ((document.newMember.magazine_checkbox.checked == true) && (document.newMember.postcode.value == "")) 
    {
        alert("Please enter a postcode.");
        updateFormFeedback("<h3 style='color: red'>Error: Please enter a postcode.</h3>");
        document.newMember.postcode.focus();
        return false;
    }

    if (document.newMember.username.value == "") 
    {
        alert("Please enter a username.");
        updateFormFeedback("<h3 style='color: red'>Error: Please enter a username.</h3>");
        document.newMember.username.focus();
        return false;
    }

    if (document.newMember.password.value == "") 
    {
        alert("Please enter a password.");
        updateFormFeedback("<h3 style='color: red'>Error: Please enter a password.</h3>");
        document.newMember.password.focus();
        return false;
    }
    
    if (document.newMember.password2.value == "") 
    {
        alert("Please verify that your password is correct.");
        updateFormFeedback("<h3 style='color: red'>Error: Please verify that your password is correct.</h3>");
        document.newMember.password2.focus();
        return false;
    }

    if ((document.newMember.password.value) != (document.newMember.password2.value))
    {
        alert("Password and verification do not match. Please reenter password and verification.");
        updateFormFeedback("<h3 style='color: red'>Error: Password and verification do not match. Please reenter password and verification.</h3>");
        document.newMember.password.value = "";
        document.newMember.password2.value = "";
        document.newMember.password.focus();
        return false;
    }

    return true;
}

function validateMember()
{
    //alert('start of regex validateMember function.');
    var validation = true;
    
    var regex = 
    [   
        /^[A-Z][\w\s]{2,50}$/, //  Last Name
        /^[A-Z][\w\s]{2,50}$/, //  First Name
        /^0[45]\d\d \d\d\d\ \d\d\d$/,  // Mobile number
        /^[(]0[234678][)] \d\d\d\d\ \d\d\d\d$/, // Landline
        /^[A-Za-z]+\.?\w+@[a-z0-9]+\.?[a-z0-9]{2,10}\.[a-z0-9]{2,4}$/,      // email address
        /^[A-Z]\w+\s?\w+?\s?\w+?,\s[A-Z]\w+\s?\w*$/,        // suburb, state
        /^\d{4}$/,          //postcode
        /^\w{6,10}$/,       // username
        /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?! ).\S{4,10}$/      // password
    ];

/*     
    [   
        /^04\d{2}[-\s]?\d{3}[-\s]?\d{3}$/,      // mobile number
        /^\(0[234678]\)[-\s]?\d{4}[-\s]?\d{4}$/,        // landline number
        /^[A-Za-z]+\.?\w+@[a-z0-9]+\.?[a-z0-9]{2,10}\.[a-z0-9]{2,4}$/,      // email address
        /^[A-Z]\w+\s?\w+?\s?\w+?,\s[A-Z]\w+\s?\w*$/,        // suburb, state
        /^\d{4}$/,          //postcode
        /^\w{6,10}$/,       // username
        /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?! ).\S{4,10}$/      // password
    ]; 
*/


/*         
    /[A-Z][\w\s]{2,50}/, //  Last Name
    /[A-Z][\w\s]{2,50}/, //  Other name
    /0[45]\d\d \d\d\d\ \d\d\d/,  // Mobile number
    /[(]0[234678][)] \d\d\d\d\d\d\d\d/, // Landline
    /[a-z]+\.?\w+@\w+\.?[a-z0-9]{2,10}\.[a-z]{2,4}/,  // Email
    /[0-9/]{1,10}[\s][A-Za-z][\w\s]{2,50}/, // Street Address
    /[A-Z][\w\s]{5,75}/, // Suburb and State
    /\d\d\d\d/,  // Postcode
    /[a-z A-Z 0-9\D]{6,10}/,  // Username
    /[a-z A-Z 0-9\D]{6,10}/  // Password 
*/


     var errors =
    [   
        'Last name should start with a capital.',
        'First name should start with a capital.',
        'Mobile number must start with 04 and contain only 10 digits - with no country code.<br>' + 
            '\nThe format should be:- 04XX XXX XXX where X is a digit.',
        'Landline number must start with the area code in parentheses followed by the remaining 8 digits.<br>' + 
            '\nThe format should be:- (0X) XXXX XXXX where X is a digit. ',
        'Email address is not valid.',
        'Suburb and state must both start with a capital letter and be separated by a comma.',
        'Postcode must be 4 digits.',
        'Username must be 6 to 10 characters long and no spaces or special characters.',
        'Password must include uppercase, lowercase, digit and special character with no spaces<br>' +
            '\nand a maximum of 10 characters.'
    ]

    var names = ['last_name', 'first_name', 'mobile', 'landline', 'email', 'suburb_state', 'postcode', 'username', 'password'];
    var i = null;
    for (i = 0; i < names.length; i++)
    {
        if ((document.newMember[names[i]].value) != "") // only test if not empty
        {
            if (!regex[i].test(document.newMember[names[i]].value))
            {
                alert(errors[i]);  // show error if doesn't validate
                updateFormFeedback(errors[i]);
                validation = false;
                break; // end the loop
            }
        }
    }
    
    switch (i)
    {
        case 0:
            document.newMember.last_name.select();
            break;
        case 1:
            document.newMember.first_name.select();
            break;
        case 2:
            document.newMember.mobile.select();
            break;
        case 3:
            document.newMember.landline.select();
            break;
        case 4:
            document.newMember.email.select();
            break;
        case 5:
            document.newMember.suburb_state.select();
            break;
        case 6:
            document.newMember.postcode.select();
            break;
        case 7:
            document.newMember.username.select();
            break;
        case 8:
            document.newMember.password.value = null;
            document.newMember.password2.value = null;
            document.newMember.password.focus();
            break;
    }

    return validation;
}

function populateJoinFormValid()
{
    if(document.newMember.populate_valid_button.value == "Populate the form with valid test data")
    {
        document.newMember.last_name.value = "Bloggs";
        document.newMember.first_name.value = "Joe";
        document.newMember.contact3.checked = true;
        document.newMember.mobile.value = "0477 632 268";
        document.newMember.landline.value = "(02) 6677 7383";
        document.newMember.email.value = "jbloggs@jbloggs.com";
        document.getElementById('emailMarker').style = "visibility:visible";
        document.newMember.occupation.selectedIndex = 1;
        document.newMember.magazine_checkbox.checked = true;
        document.newMember.magazine.value = 1;
        document.getElementById('streetMarker').style = "visibility:visible";
        document.getElementById('suburbMarker').style = "visibility:visible";
        document.getElementById('postcodeMarker').style = "visibility:visible";
        document.newMember.street_addr.value = "7 Somestreet Rd.";
        document.newMember.suburb_state.value = "Somesuburb, NSW";
        document.newMember.postcode.value = "2488";
        document.newMember.username.value = "test_user";
        document.newMember.password.value = "6yhnMJU&";
        document.newMember.password2.value = "6yhnMJU&";
        document.newMember.populate_valid_button.value = "Clear the form of the valid test data";
    }
    else if(document.newMember.populate_valid_button.value == "Clear the form of the valid test data")
    {
        clearFormData();
        document.newMember.populate_valid_button.value = "Populate the form with valid test data";
    }
    updateFormFeedback(null);
}

function clearFormData()
{
    document.newMember.last_name.value = null;
    document.newMember.first_name.value = null;
    document.newMember.contact3.checked = false;
    document.newMember.mobile.value = null;
    document.newMember.landline.value = null;
    document.newMember.email.value = null;
    document.getElementById('emailMarker').style = "visibility:hidden";
    document.newMember.occupation.selectedIndex = 0;
    document.newMember.magazine_checkbox.checked = false;
    document.newMember.magazine.value = null;
    document.getElementById('streetMarker').style = "visibility:hidden";
    document.getElementById('suburbMarker').style = "visibility:hidden";
    document.getElementById('postcodeMarker').style = "visibility:hidden";
    document.newMember.street_addr.value = null;
    document.newMember.suburb_state.value = null;
    document.newMember.postcode.value = null;
    document.newMember.username.value = null;
    document.newMember.password.value = null;
    document.newMember.password2.value = null;
}

/*Updates the form feedback messages area.*/
function updateFormFeedback(data) 
{
    //alert(data);
    if(data != null)
    {
        document.getElementById('join_form_feedback_messages').innerHTML = "<p>" + data + "</p>";
    }
    else
    {
        document.getElementById('join_form_feedback_messages').innerHTML = data;
    }
}
