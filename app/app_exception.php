<?php
class AppException extends Exception
{
}
class ValidationException extends AppException
{
}
class PageNotFoundException 
{
    public function __construct($err_msg)
    {
        redirect(url("topic/pagenotfound", array("error_msg"=>$err_msg)));
    }
}
class NotFoundException extends AppException
{
}