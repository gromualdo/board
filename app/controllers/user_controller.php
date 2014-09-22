<?php
class UserController extends AppController 
{
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
        $blocked_error = false;
        $user_login = Param::get('checklogin', 'index');
        switch ($user_login) {
            case 'index':
                break;
            case '/topic/topics':
                $login->username = Param::get('username');
                $login->password = Param::get('password');
                try {
                    $uname = $login->checkLogin();
                    if ($uname) {
                        if ($uname['status'] == true) {
                            $blocked_error = true;
                        } else {
                            $_SESSION['user_session'] = $uname;
                            redirect('/topic/topics');
                        }
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
                    if ($user->update()) {
                        $success_message = "Profile Successfully Updated";
                        redirect("/user/updateprofile?m=$success_message");
                    } else {
                        $add_user = 'updateprofile';
                    }

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

    /**
     * Display all users
     */
    public function users()
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        } 
        is_not_admin('user_session');
        $user_id = base64_decode(Param::get('u'));

        //controls the set of user to be displayed
        if (isset($_GET['r'])) {
            $header = "Admins";
            $query_string1 = null;
            $link1 = "Show all Cleared Users";
            $query_string2 = "?c=blocked";
            $link2 = "Show all Blocked Users";
            $alert = "alert-info";
            $option = null;
            $hide_btn1 = "display:none;";
            $hide_btn2 = "display:none;";
        } elseif (isset($_GET['c'])) {
            $header = "Blocked Users";
            $query_string1 = "?r=admin";
            $link1 = "Show all Admins";
            $query_string2 = null;
            $link2 = "Show all Cleared Users";
            $alert = "alert-error";
            $option = "Option";
            $hide_btn1 = "display:none;";
            $hide_btn2 = null;
            $btn2 = "Unblock";
        } else {
            $header = "Cleared Users";
            $query_string1 = "?r=admin";
            $link1 = "Show all Admins";
            $query_string2 = "?c=blocked";
            $link2 = "Show all Blocked Users";
            $alert = "alert-success";
            $option = "Options";
            $btn2 = "Block";
        }

        $users = new User();
        if (isset($_GET['c'])) {
            User::$is_blocked = true;
        }
        if (Param::get('r')) {
            $is_admin = true;
            $total_rows = User::countUserByStatus(User::$is_blocked, $is_admin);
            $page = Pagination::pageValidator($total_rows);
            $all_users = $users->getUserByStatus($page, User::$is_blocked, $is_admin);
            $paged = new Pagination($total_rows, $page, array("r=admin"));
        } else {
            $total_rows = User::countUserByStatus(User::$is_blocked);
            $page = Pagination::pageValidator($total_rows);
            $all_users = $users->getUserByStatus($page,User::$is_blocked);
            $paged = new Pagination($total_rows, $page); 
        }
        $this->set(get_defined_vars());        
    }

    /**
     * Block/Unblock User
     */
    public function changeBlockStatus()
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        } 
        is_not_admin('user_session');
        $user_id = base64_decode(Param::get('u'));

        $users = new User();
        $users->changeBlockStatus($user_id);

        $success_message = "Changed User ID {$user_id}'s status";
        redirect("/user/users?m=$success_message");
    }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   


    /**
     * Calls the notallowed.php view
     * Displays an access denied error 
     * for non Admin users
     */
    public function notAllowed()
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        } 
    }

    /**
     * Promote the User to Admin Role
     */
    public function promoteToAdmin()
    {
        if (!isset($_SESSION['user_session'])) {
            redirect('/');
        } 
        is_not_admin('user_session');
        $user_id = base64_decode(Param::get('u'));

        $users = new User();
        $users->promoteToAdmin($user_id);

        $success_message = "Promoted User {$user_id} to Admin";
        redirect("/user/users?m=$success_message");
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
