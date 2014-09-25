<?php 
/**
 * Validates the length of the inputted string
 * @param $check
 * @param $min
 * @param $max
 * @return bool
 */
function is_between($check, $min, $max)
{
    $n = mb_strlen($check);
    return $min <= $n && $n <= $max;
}

/**
 * Validates the format of email
 * will only accept formats:
 * me@facebook.com and
 * me@yahoo.com.ph
 * @param $string
 * @return bool
 */
function is_valid_email($string)
{
    return (preg_match('/^([\w]+[\._]?)+@[A-z]+\.[A-z]{3}$/', $string) ||        
       preg_match('/^([\w]+[\._]?)+@[A-z]+\.[A-z]{3}$\.?[A-z]{2}?$/', $string));   
}

/**
 * Validates the inputted name
 * will only accept string that
 * begins with a char,
 * accepts spaces and hyphen in the middle
 * and ends with a char
 * @param $string
 * @return bool
 */
function is_valid_name($string)
{
    return (preg_match('/^([A-z]+[ -]?){4,7}$/', $string)); 
}

/**
 * Validates the username
 * will only accept numbers
 * and letters
 * without spaces
 * @param $string
 */
function is_valid_username($string)
{
    return (ctype_alnum($string));
}

/**
 * Checks if two password and re-typed password are equal
 * @param $string1
 * @return bool
 */
function is_password_same($string)
{
    $split = explode(" ", $string);
    return ($split[0] === $split[1]);
}
/**
 * Checks if the password contains spaces
 * return false if it has any
 * @param $string
 * @return bool
 */
function is_valid_password($string)
{
    return (preg_match('/^[^\s]+$/', $string)); 
}

/**
 * Validates the inputted topic,
 * will reject string if it begins with
 * space/spaces
 * @param $string
 * @return bool
 */
function has_space_at_beginning($string)
{
    return (preg_match('/^[^\s]/', $string)); 
}