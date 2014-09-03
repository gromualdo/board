<?php 
/**
 * Validates the length of the inputted string
 * @param $check
 * @param $min
 * @param $max
 * @return bool
 */
function validateBetween($check, $min, $max)
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
function emailFormat($string)
{
    return (preg_match('/[\w._]+@[A-z]+.[A-z]{3}$/', $string) ||        
       preg_match('/[\w._]+@[A-z]+.[A-z]{3}.?[A-z]{2}?$/', $string));   
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
function nameFormat($string)
{
    return (preg_match('/^[A-z]+[A-z  -]+[A-z]+$/', $string));  //should start and end with a letter, accepts hyphen and spaces
}

/**
 * Validates the username
 * will only accept numbers
 * and letters
 * without spaces
 * @param $string
 */
function unameFormat($string)
{
    return (ctype_alnum($string));
}

/**
 * Checks if two inputted strings are equal
 * @param $string1
 * @param $string2
 * @return bool
 */
function isEqual($string1, $string2)
{
  return ($string1 === $string2);
}

/**
 * Checks if the password contains spaces
 * return false if it has any
 * @param $string
 * @return bool
 */
function pwdFormat($string)
{
    return (preg_match('/^[^ ]+$/', $string)); 
}
