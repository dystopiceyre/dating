<?php
/*
Make name, age, phone, and email required fields
Gender, bio, and interests are optional.
In your controller, require the validation file. When each form is submitted, validate the
data in that form using the appropriate functions. If there are no errors, then store the
data in session variables and display the next form
 */

//checks to see that a string is all alphabetic
function validName()
{

}

//checks to see that an age is numeric and between 18 and 118
function validAge($age)
{
   return !empty($age) && ctype_digit($age) && $age >= 18 && $age <= 118;
}

//checks to see that a phone number is valid
function validPhone()
{

}

//checks to see that an email address is valid
function validEmail()
{

}

//checks each selected indoor interest against a list of valid options
function validIndoor()
{

}

//checks each selected outdoor interest against a list of valid options
function validOutdoor()
{

}