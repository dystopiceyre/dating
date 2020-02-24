<?php

class DatingValidation
{
    /* checks to see that a string is all alphabetic
     * @param String first
     * @return boolean
     */
    function validFirstName($first)
    {
        return ctype_alpha($first);
    }

    /* checks to see that a string is all alphabetic
     * @param String last
     * @return boolean
     */
    function validLastName($last)
    {
        return ctype_alpha($last);
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
}