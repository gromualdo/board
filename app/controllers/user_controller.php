<?php
class UserController extends AppController {

    /**
     * Registration page
     */
    public function userSignup() 
    {
        needLogoutError('user_session');
        $title = "Signup";
        $register = new user();
        $add_user = Param::get('added', 'usersignup');

        switch($add_user) {
        case 'usersignup':
            break;
        case 'signupsuccess':
            $register->name     = Param::get('name');
            $register->email    = Param::get('email');
            $register->uname    = Param::get('uname');
            $register->pwd1     = Param::get('pwd1');           
            $register->pwd2     = Param::get('pwd2');
            try {
                $register->addUser();
            } 
            catch (ValidationException $e) {
                $adduser='usersignup';
            }           
            break;
        default:
            throw new NotFoundException("{$add_user} is not found");
            break;
        }
        $this->set(get_defined_vars());
        $this->render($add_user);
    }

    /**
     * Login page
     */
    public function index() 
    {
        needLogoutError('user_session');
        $title = "Login";
        $login = new user();
        $user_login = Param::get('checklogin', 'index');
        $login_error = false;
        switch($user_login) {
        case 'index':
            break;
        case '/thread/threads':
            $login->username    = Param::get('username');
            $login->password    = Param::get('password');
            try {
                $uname =$login->checkLogin();
                if ($uname) {
                    $_SESSION['user_session'] = $uname;
                    redirect('/thread/threads');
                } else {
                    $login_error = true;
                }
            } 
            catch (ValidationException $e) {
                $user_login="index";
            }
            break;
        default:
            throw new NotFoundException("{$user_login}login error");
            break;
        }
       $this->set(get_defined_vars());
    }

    /**
     * Logout function,
     * will be redirected to homepage afterwards
     */
    public function logout() 
    {
        session_destroy();
        header("location: /");
    }

}             
