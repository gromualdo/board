<?php 
class User extends AppModel
{
    public static $is_blocked = false;
    public static $is_email_exists = false;
    public static $is_username_exists = false;
    public $same_password = true;
    public $validation = array(
        'name' => array(
            'length' => array(
                'is_between', MAX_LENGTH, MIN_LENGTH
                ),
            'validname' => array(
                'is_valid_name'
                ),
            ),

        'email' => array(
            'length' => array(
                'is_between', MAX_LENGTH, MIN_LENGTH
                ),
            'validemail' => array(
                'is_valid_email'
                ),
            ),
        'username' => array(
            'length' => array(
                'is_between', MAX_LENGTH, MIN_LENGTH
                ),
            'validuname' => array(
                'is_valid_username'),
            ),
        'password' => array(
            'length'=> array(
                'is_between', MAX_LENGTH, MIN_LENGTH
                ),
            'validpassword' => array(
                'is_valid_password'),
            ),
        'combined_password' => array(
            'comparison' => array(
                'is_password_same'),
            ),
        );

    /**
     * Adds new user
     */
    public function addUser()
    {
        if (!$this->validate() ) {
            throw new ValidationException('invalid name');
        }

        $db = DB::conn();

        $check_email = $db->row(
            "SELECT * FROM users WHERE email = ?",
            array($this->email)
        );
        $check_username = $db->row(
            "SELECT * FROM users WHERE username = ?",
            array($this->username)
        );

        if ($check_email) {
            self::$is_email_exists = true;
        } 
        if ($check_username) {
            self::$is_username_exists = true;
        }
        if (self::$is_email_exists || self::$is_username_exists) {
            return false;
        } else {
            $params = array(
                'name' => $this->name, 
                'email' => $this->email, 
                'grade_level' => $this->grade_level,
                'username' => $this->username, 
                'password' => md5($this->password)
                );
            $db->insert("users", $params); 
            return true;
        }
    }

    /**
     * Checks the username and password
     * @return $result
     */
    public function checkLogin()
    {
        if (!$this->validate()) {
            throw new ValidationException('invalid name');
        }
        $db = DB::conn();
        $param = array(
            $this->username,
            md5($this->password)
        );
        $row = $db->row(
            "SELECT * FROM users WHERE 
            username = ? AND
            password = ?",
            $param
        );
        return $row;
    }

    /**
     * Update user profile
     * @return $info
     */
    public function update()
    {
        if (!$this->validate()) {
            throw new ValidationException('invalid name');
        }
        $db = DB::conn();

        $check_email = $db->row(
            "SELECT * FROM users 
            WHERE email = ? AND user_id != ?",
            array($this->email, $this->id)
        );
        $check_username = $db->row(
            "SELECT * FROM users 
            WHERE username = ? AND user_id != ?",
            array($this->username, $this->id)
        );

        if ($check_email) {
            self::$is_email_exists = true;
        } 
        if ($check_username) {
            self::$is_username_exists = true;
        }
        if (self::$is_email_exists || self::$is_username_exists) {
            return false;
        } else {
            $params = array(
                'name' => $this->name,
                'email' => $this->email,
                'grade_level' => $this->grade_level,
                'username' => $this->username,
                'password' => md5($this->password)
                );
            $whereparam = array(
                'user_id' => $this->id
                );
            $db->update("users", $params, $whereparam);
            return true;
        }
        
    }

    /**
     * Get the updated User Profile
     * @param $id
     * @return $info
     */
    public function getUpdatedProfile($user_id)
    {
        $db = DB::conn();
        $info = $db->row(
            "SELECT * FROM users 
            WHERE user_id = ?", 
            array($user_id)
        );
        return new self($info);
    }

    /**
     * Count the number of Users
     * based on their status and roles
     * @param $status
     * @param $role
     * @return $result_count
     */
    public static function countUserByStatus($status, $role = false)
    {
        $db = DB::conn();
        $result_count = (int) $db->value(
            "SELECT COUNT(*) FROM users 
            WHERE role = ? AND status= ?", 
            array($role, $status)
        );
        return $result_count;
    }

    /**
     * Get All Users 
     * based on their status and roles
     * @param $currentpage
     * @param $status
     * @param $role
     * @return boolean/array
     */
    public function getUserByStatus($currentpage, $status, $role = false)
    {
        $db = DB::conn();
        $lowerlimit = ($currentpage - 1) * ROWS_PER_PAGE;
        $limit = "LIMIT $lowerlimit,".ROWS_PER_PAGE;
        $rows = $db->rows(
            "SELECT * from users 
            WHERE role = ? AND status = ? 
            $limit", 
            array($role,$status)
        );

        if (count($rows)>0) {
            foreach($rows as $row) {
                $user[] = new User($row);
            }
        return $user;
        } else {
            return false;
        }
    }

    /**
     * Block/Unblock Users
     * @param $user_id
     */
    public function changeBlockStatus($user_id)
    {
        $db = DB::conn();

        $row = $db->row(
            "SELECT * FROM users 
            WHERE user_id = ?", 
            array($user_id)
        );
        if($row['status'] == false) {
            self::$is_blocked = true;
        }
        $param = array(
            'status' => self::$is_blocked
        );
        $whereparam = array(
            'user_id' => $user_id
        );
        $db->update('users',$param, $whereparam);
    }

    /** 
     * Promote user to Admin role
     * @param $user_id
     */
    public function promoteToAdmin($user_id)
    {
        $db = DB::conn();

        $param = array(
            'role' => true
            );

        $whereparam = array(
            'user_id' => $user_id
        );
        $db->update('users', $param, $whereparam);
    }
}