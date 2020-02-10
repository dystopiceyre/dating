<?php
/* Validate the form
 * @return boolean
 */
function validForm()
{
    global $f3;
    $isValid = true;
    return $isValid;
}

//checks to see that a string is all alphabetic
function validName($name)
{
    return !empty($name) && ctype_alpha($name);
}

//checks to see that an age is numeric and between 18 and 118
function validAge($age)
{
    return !empty($age) && ctype_digit($age) && $age >= 18 && $age <= 118;
}

//checks to see that a phone number is valid
function validPhone($phone)
{
    return !empty($phone) && preg_match('\/^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/',
            $phone);
}

//checks to see that an email address is valid
//regex pattern from: https://www.regular-expressions.info/email.html
function validEmail($email)
{
    return !empty($email) && preg_match('[a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@(?:
[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?', $email);
}

//checks each selected seeking value against a list of valid options
function validateSeeking($seeking)
{
    global $f3;
    return in_array($seeking, $f3->get('seeking'));
}

//checks each selected indoor interest against a list of valid options
function validIndoor($indoor)
{
    global $f3;
    return in_array($indoor, $f3->get('indoor'));
}

//checks each selected outdoor interest against a list of valid options
function validOutdoor($outdoor)
{
    global $f3;
    return in_array($outdoor, $f3->get('outdoor'));
}