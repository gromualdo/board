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
function need_logout_error($string)
{
    if (isset($_SESSION[$string])) {
        $logout_error ="You need to logout first"; 
        redirect(url("topic/topics", array('m'=>$logout_error)));        
    }
}

function is_not_admin($string)
{
    if ($_SESSION[$string]['role'] == 0) {
        redirect("/user/notallowed");
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

function is_logged_in($string)
{
    if (!isset($_SESSION[$string])) {
        redirect('/');
    }
}