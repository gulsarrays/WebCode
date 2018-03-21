/*
 Project                     : Oriole
 Module                      : Utils
 File name                   : signin.js
 Description                 : Javascript file used  for form validation
 Copyright                   : Copyright © 2014, Audvisor Inc.
 Written under contract by Robosoft Technologies Pvt. Ltd.
 History                     :
 */

/*
 Function              : showAlert()
 Brief                 : showAlert this function displays a div section.
 Detail                : This function this function displays a div section.
 Input param           : Nil
 Input/output param    : Nil
 Return                : Returns void.
 */
function showAlert()
{
    document.getElementById("alertMsg").style.display = "block";
}

/*
 Function              : showAlert()
 Brief                 : showAlert this function hides a div section.
 Detail                : This function this function hides a div section.
 Input param           : Nil
 Input/output param    : Nil
 Return                : Returns void.
 */

function cshowAlert()
{
    document.getElementById("calertMsg").style.display = "block";
}

/*
 Function              : hideAlert()
 Brief                 : hideAlert hides a div section.
 Detail                : This function hides the Admin login Warning div section.
 Input param           : Nil
 Input/output param    : Nil
 Return                : Returns void.
 */
function hideAlert()
{
    document.getElementById("alertMsg").style.display = "none";
}
function chideAlert()
{
    document.getElementById("calertMsg").style.display = "none";
}

/*
 Function              : hideCredentialErrorAlert()
 Brief                 : hideCredentialErrorAlert hides a div section.
 Detail                : This function hides the Admin login credentials Warning div section.
 Input param           : Nil
 Input/output param    : Nil
 Return                : Returns void.
 */
function hideCredentialErrorAlert()
{
    if(document.getElementById("loginCredentialsError"))
    {
        document.getElementById("loginCredentialsError").style.display = "none";
    }
}

/*
 Function              : validateLoginForm()
 Brief                 : validateLoginForm validates from.
 Detail                : This function validates the Admin login form.
 Input param           : Nil
 Input/output param    : Nil
 Return                : Returns a boolean value.
 */

function validateLoginForm()
{

    var sUsernameField = document.forms["loginForm"]["txtuserName"].value.trim();
    var sPasswordField = document.forms["loginForm"]["txtpassword"].value.trim();
    var flagVal = isValidEmail(sUsernameField);

    if(sUsernameField == null || sUsernameField == "")
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter User Name";

        return false;
    }
    else if(!flagVal)
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Incorrect User Name";

        return false;
    }
    else if(sPasswordField == null || sPasswordField == "")
    {
        showAlert();
        document.getElementById("alertMsg").innerHTML = "Enter password";

        return false;
    }
}
