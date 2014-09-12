<?php
/**
 * Renamed DietCake's eh() function
 */
function clean_output($string) 
{
    if (!($string)) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

/**
 * Formats the text to include enter (nextline)
 */
function readable_text($string) 
{ 
    $string = htmlspecialchars($string, ENT_QUOTES);
    $string = nl2br($string);
    return $string;
}

/**
 * @param $string
 * Blocks user from accessing
 * login page and registration page
 * while logged in
 */
function needLogoutError($string)
{
    if(isset($_SESSION[$string])) {
        $logout_error ="You need to logout first"; 
        redirect(url("topic/topics", array('m'=>$logout_error)));        
    }
}

/**
 * @param $url
 * redirect to $url page
 */
function redirect($url)
{
    header("location: {$url} ");
}