<?php
class UserController extends AppController {
    public function userSignup() 
    {
        logouterror('user');
        $title = "Signup";
        $register = new user();
        $adduser = Param::get('added', 'usersignup');

        switch($adduser) {
        case 'usersignup':
            break;
        case 'signupsuccess':
            $register->name     = Param::get('name');
            $register->email    = Param::get('email');
            $register->uname    = Param::get('uname');
            $register->pwd1     = Param::get('pwd1');           
            $register->pwd2     = Param::get('pwd2');
            try {
                $register->adduser();
            } 
            catch (ValidationException $e) {
                $adduser='usersignup';
            }           
            break;
        default:
            throw new NotFoundException("{$adduser} is not found");
            break;
        }
        $this->set(get_defined_vars());
        $this->render($adduser);
    }

    public function index() 
    {
        logouterror('user');
        $title = "Login";
        $login = new user();
        $userlogin = Param::get('checklogin', 'index');
        $errmsg = 0;
        switch($userlogin) {
        case 'index':
            break;
        case '/thread/threads':
            $login->username    = Param::get('uname');
            $login->password    = Param::get('pwd');
            try {
                $vname =$login->checklogin();
                if ($vname) {
                    $_SESSION['user'] = $vname;
                    redirect('/thread/threads');
                } else {
                    $errmsg = "1";
                }
            } 
            catch (ValidationException $e) {
                $userlogin="index";
            }
            break;
        default:
            throw new NotFoundException("{$userlogin}login error");
            break;
        }
       $this->set(get_defined_vars());
    }

    public function logout() 
    {
        session_destroy();
        header("location: /");
    }

}             
