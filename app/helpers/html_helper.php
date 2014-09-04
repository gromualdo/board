<?php
/**
 * Renamed DietCake's eh() function
 */
function output($string) 
{
    if (!($string)) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

/**
 * Formats the text to include enter (nextline)
 */
function readable_text($s) 
{ 
    $s = htmlspecialchars($s, ENT_QUOTES);
    $s = nl2br($s);
    return $s;
}

/**
 * @param $string
 * Checks if there is an existing Session
 */
function is_logged($string) 
{
    return(isset($_SESSION[$string]));
}

/**
 * @param $string
 * Blocks user from accessing
 * login page and registration page
 * while logged in
 */
function needLogoutError($string)
{
    if(is_logged($string)) {
        $logout_error ="You need to logout first"; 
        $url = url("thread/threads", array('m'=>$logout_error));
        redirect($url);        
    }
}

/**
 * @param $url
 * redirect to $url page
 */
function redirect($url)
{
    header("location:".$url);
}