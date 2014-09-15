<?php
class UserController extends AppController 
{
    public static $is_blocked = false;
    /**
     * Registration page
     */
    public function register() 
    {
        needLogoutError('user_session');
        $user = new User();
        $add_user = Param::get('added', 'register');

        switch ($add_user) {
            case 'register':
                break;
            case 'signupsuccess':
                $user->name = Param::get('name');
                $user->email = Param::get('email');
                $user->grade_level = Param::get('gradelevel');
                $user->username = Param::get('username');
                $user->password = Param::get('password');           
                $user->password2 = Param::get('password2');
                $user->combined_password = $user->password." ".$user->password2;
                try {
                    if (!$user->addUser()) {
                        $add_user = 'register';
                    }
                } catch (ValidationException $e) {
                    $add_user = 'register';
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
        $login_error = false;
        $user_login = Param::get('checklogin', 'index');
        switch ($user_login) {
            case 'index':
                break;
            case '/topic/topics':
                $login->username = Param::get('username');
                $login->password = Param::get('password');
                try {
                    $uname = $login->checkLogin();
                    echo $uname;
                    if ($uname) {
                        $_SESSION['user_session'] = $uname;
                        redirect('/topic/topics');
                     } else {
                        $login_error = true;
                     }
                } catch (ValidationException $e) {
                    $login_error = true;
                    $user_login = "index";
                }
                break;
            default:
                throw new NotFoundException("{$user_login}login error");
                break;
        }
       $this->set(get_defined_vars());
    }

    /**
     * Update user profile
     */
    public function updateProfile()
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        }
        $session = $_SESSION['user_session'];

        $user_id = $session['user_id'];
        $user = new User();
        $infos = $user->getProfile($user_id);


        $name = $infos['name'];
        $email = $infos['email'];
        $grade_level = $infos['grade_level'];
        $username = $infos['username'];
        $user = new User();
        $add_user = Param::get('update', 'updateprofile');

        switch ($add_user) {
            case 'updateprofile':
                break;
            case 'updatesuccess':
                $user->id = $session['user_id'];
                $user->name = Param::get('name');
                $user->email = Param::get('email');
                $user->grade_level = Param::get('gradelevel');
                $user->username = Param::get('username');
                $user->password = Param::get('password');           
                $user->password2 = Param::get('password2');
                $user->combined_password = $user->password." ".$user->password2;
                try {
                    $user->update();
                    session_regenerate_id();
                    $success_message = "Profile Successfully Updated";
                    redirect("/user/updateprofile?m=$success_message");
                } catch (ValidationException $e) {
                    $add_user = 'updateprofile';
                }           
                break;
            default:
                throw new NotFoundException("{$adduser} is not found");
                break;
        }
        $this->set(get_defined_vars());
    }

    public function users()
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        } 
        is_not_admin('user_session');

        if (isset($_GET['c'])) {
            self::$is_blocked = true;
        }
        $total_rows = User::countAll(self::$is_blocked);
        $page = Pagination::pageValidator($total_rows);
        $users = new User();
        $all_users = $users->getAll($page,self::$is_blocked);
        $paged = new Pagination($total_rows, $page);
        $this->set(get_defined_vars());        
    }

    public function notAllowed()
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        } 
    }

    public function unblock()
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        } 
        is_not_admin('user_session');
        $user_id = base64_decode(Param::get('u'));

        $users = new User();
        $users->unblock($user_id, $is_blocked);

        $success_message = "User Successfully Unblocked";
        redirect('/user/users?c=blocked&m=$success_message');
    }

    /**
     * Logout function,
     * will be redirected to homepage afterwards
     */
    public function logout() 
    {
        session_destroy();
        redirect("/");
    }

}             
