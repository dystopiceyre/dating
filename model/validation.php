<?php

class DatingValidation
{
    /* Validate the form
     * @return boolean
     */
    function validForm()
    {
        global $f3;
        $isValid = true;

        if (!validFirstName($f3->get('firstName'))) {
            $isValid = false;
            $f3->set("errors['firstName']", "Please enter a first name");
        }

        if (!validLastName($f3->get('lastName'))) {
            $isValid = false;
            $f3->set("errors['lastName']", "Please enter a last name");
        }

        if (!validAge($f3->get('age'))) {
            $isValid = false;
            $f3->set("errors['age']", "Please enter an age between 18 and 118");
        }

        if (!validPhone($f3->get('phoneNumber'))) {
            $isValid = false;
            $f3->set("errors['phoneNumber']", "Please enter a phone number");
        }

        if (!validEmail($f3->get('email'))) {
            $isValid = false;
            $f3->set("errors['email']", "Please enter a valid email address");
        }

        if (!validSeeking($f3->get('seeking'))) {
            $isValid = false;
            $f3->set("errors['seeking']", "Invalid selection");
        }

        if (!validIndoor($f3->get('indoorInterests'))) {
            $isValid = false;
            $f3->set("errors['indoorInterests']", "Invalid selection");
        }

        if (!validOutdoor($f3->get('outdoorInterests'))) {
            $isValid = false;
            $f3->set("errors['outdoorInterests']", "Invalid selection");
        }

        return $isValid;
    }

    /* checks to see that a string is all alphabetic
     * @param String first
     * @return boolean
     */
    function validFirstName($first)
    {
        return !empty($first) && ctype_alpha($first);
    }

    /* checks to see that a string is all alphabetic
     * @param String last
     * @return boolean
     */
    function validLastName($last)
    {
        return !empty($last) && ctype_alpha($last);
    }

    /* checks to see that an age is numeric and between 18 and 118
     * @param Integer age
     * @return boolean
     */
    function validAge($age)
    {
        return !empty($age) && ctype_digit($age) && $age >= 18 && $age <= 118;
    }

    /* checks to see that a phone number is valid
    regex pattern from http://regexlib.com/REDetails.aspx?regexp_id=607
     * @param String phone
     * @return boolean
     */
    function validPhone($phone)
    {
        return !empty($phone) && preg_match('/^[2-9]\d{2}-?\d{3}-?\d{4}$/', $phone);
    }

    /* checks to see that an email address is valid
    regex pattern from: https://www.regular-expressions.info/email.html
     * @param String email
     * @return boolean
     */
    function validEmail($email)
    {
        return !empty($email) && preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b/', $email);
    }

    /* checks each selected seeking value against a list of valid options
     * @param Array seeking
     * @return boolean
     */
    function validSeeking($seeking)
    {
        global $f3;
        return in_array($seeking, $f3->get('seeking'));
    }

    /* checks each selected indoor interest against a list of valid options
     * @param Array indoor
     * @return boolean
     */
    function validIndoor($indoor)
    {
        global $f3;
        return in_array($indoor, $f3->get('indoor'));
    }

    /* checks each selected outdoor interest against a list of valid options
     * @param Array outdoor
     * @return boolean
     */
    function validOutdoor($outdoor)
    {
        global $f3;
        return in_array($outdoor, $f3->get('outdoor'));
    }
}