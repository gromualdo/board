<?php
function output($string) 
{
    if (!isset($string)) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

function readable_text($s) 
{ 
    $s = htmlspecialchars($s, ENT_QUOTES);
    $s = nl2br($s);
    return $s;
}

function is_logged($string) 
{
    return(isset($_SESSION[$string]));
}
function logoutError($string)
{
    if(is_logged($string)) {
        $logouterror ="You need to logout first"; 
        $url = url("thread/threads", array('m'=>$logouterror));
        echo $url;
        redirect($url);        
    }
}

function redirect($url)
{
    header("location:".$url);
}