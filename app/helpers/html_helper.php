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
function session_shield($string)
{
    if(!isset($string))
    {
        return true;
    }
    else
    {
        return false;
    }

}

