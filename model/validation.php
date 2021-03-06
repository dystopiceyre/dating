<?php

class DatingValidation
{
    /* checks to see that a string is all alphabetic
     * @param String name
     * @return boolean
     */
    function validName($name)
    {
        return !empty($name) && preg_match('/^[A-Za-z]*$/', $name);
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
    regex pattern from: http://regexlib.com/REDetails.aspx?regexp_id=21
     * @param String email
     * @return boolean
     */
    function validEmail($email)
    {
        return !empty($email) && preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $email);
    }

    function validState($selectedState, $f3) {
        return in_array($selectedState, $f3->get("states"));
    }

    /* checks each selected seeking value against a list of valid options
     * @param Array seeking
     * @return boolean
     */
    function validSeeking($seeking, $f3)
    {
        foreach ($seeking as $gender) {
            if (!in_array($gender, $f3->get("genders"))) {
                echo "false";
                return false;
            }
        }
        return true;
    }

    /* checks each selected indoor interest against a list of valid options
     * @param Array indoor
     * @return boolean
     */
    function validIndoor($indoor, $f3)
    {
        foreach ($indoor as $interest) {
            if (!in_array($interest, array_values($f3->get('indoor')))) {
                return false;
            }
        }
        return true;
    }

    /* checks each selected outdoor interest against a list of valid options
     * @param Array outdoor
     * @return boolean
     */
    function validOutdoor($outdoor, $f3)
    {
        foreach ($outdoor as $interest) {
            if (!in_array($interest, array_values($f3->get('outdoor')))) {
                return false;
            }
        }
        return true;
    }
}