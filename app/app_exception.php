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
        redirect(url("topic/page_not_found", array("error_msg"=>$err_msg)));
    }
}
class NotFoundException extends AppException
{
}