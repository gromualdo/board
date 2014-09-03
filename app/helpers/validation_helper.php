<?php 
function validate_between($check, $min, $max)
{
    $n = mb_strlen($check);
    return $min <= $n && $n <= $max;
}

function email_format($string)
{
    return (preg_match('/[\w._]+@[A-z]+.[A-z]{3}$/', $string) ||        //me@facebook.com
       preg_match('/[\w._]+@[A-z]+.[A-z]{3}.?[A-z]{2}?$/', $string));   //me@yahoo.com.ph
}

function not_empty($string)
{
    return (isset($string));
}

function name_format($string)
{
    return (preg_match('/^[A-z]+[A-z  -]+[A-z]+$/', $string));  //should start and end with a letter, accepts hyphen and spaces
}

function uname_format($string)
{
    return (ctype_alnum($string));
}

function is_equal($string1, $string2)
{
  return ($string1 === $string2);
}
function pwd_format($string)
{
    return (preg_match('/^[^ ]+$/', $string)); //will reject spaces
}
