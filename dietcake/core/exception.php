<?php
class DCException extends Exception
{
    public function __construct($err_msg)
    {
        $url = url("thread/pagenotfound", array('error_msg'=>$err_msg));
        redirect($url);
    }
}
