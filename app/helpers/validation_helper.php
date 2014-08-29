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

function same_password($pwd1, $pwd2)
{
    if($pwd1 == $pwd2){
        return 1;
    }
}
