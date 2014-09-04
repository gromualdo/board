<?php
class UserController extends AppController {

    /**
     * Registration page
     */
    public function register() 
    {
        needLogoutError('user');
        $user     = new User();
        $add_user = Param::get('added', 'register');

        switch($add_user) {
        case 'register':
            break;
        case 'signupsuccess':
            $user->name      = Param::get('name');
            $user->email     = Param::get('email');
            $user->username  = Param::get('uname');
            $user->password  = Param::get('pwd1');           
            $user->password2 = Param::get('pwd2');
            try {
                $user->addUser();
            } 
            catch (ValidationException $e) {
                $add_user='register';
            }           
            break;
        default:
            throw new NotFoundException("{$adduser} is not found");
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
        $login = new User();
        $user_login = Param::get('checklogin', 'index');
        $login_error = true;
        switch($user_login) {
        case 'index':
            break;
        case '/thread/threads':
            $login->username    = Param::get('username');
            $login->password    = Param::get('password');
            try {
                $uname = $login->checklogin();
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
