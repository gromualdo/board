<?php 
function validate_between($check, $min, $max)
{
    $n = mb_strlen($check);
    return $min <= $n && $n <= $max;
}

function email_format($string)
{
    return (preg_match('/[\w._]+@[A-z]+.[A-z]{3}$/', $string) ||
       preg_match('/[\w._]+@[A-z]+.[A-z]{3}.?[A-z]{2}?$/', $string));
}

function not_empty($string)
{
    return (isset($string));
}

function name_format($string)
{
    return (preg_match('/^[A-z]+[A-z  -]+[A-z]+$/', $string));
}

function uname_format($string)
{
    return (ctype_alnum($string));
}

function same_password($string)
{
    $exploded = explode(" ", $string);
    if($exploded[0] === $exploded[1])
    {
        return 1; 
    } 
}
function pwd_format($string)
{
    return (preg_match('/^[^ ]+$/', $string));
}
