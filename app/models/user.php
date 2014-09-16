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

        $check_email = $db->row("SELECT * FROM users WHERE email = ?",
            array($this->email));
        $check_username = $db->row("SELECT * FROM users WHERE username = ?",
            array($this->username));

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
        $row = $db->row("SELECT * FROM users WHERE 
            username = ? AND
            password = ?",
            array(
            $this->username,
            md5($this->password)
            )
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
    }

    public function getProfile($string)
    {
        $db = DB::conn();
        $info = $db->row("SELECT * FROM users WHERE user_id = ?", array($string));
        return $info;
    }

    public static function countUserByStatus($string, $string2)
    {
        $db = DB::conn();
        $result_count = (int) $db->value("SELECT COUNT(*) FROM users WHERE role = 0 AND status= ?", array("0"));
        return $result_count;
    }

    public function getUserByStatus($currentpage, $string)
    {
        $db = DB::conn();
        $lowerlimit = ($currentpage - 1) * ROWS_PER_PAGE;
        $limit = "LIMIT $lowerlimit,".ROWS_PER_PAGE;
        $rows = $db->rows("SELECT * from users WHERE role = ? AND status = ? $limit", array("0",$string));
        if (count($rows)>0) {
            foreach($rows as $row) {
                $user[] = new User($row);
            }
        return $user;
        } else {
            return false;
        }
    }

    public function changeBlockStatus($user_id)
    {
        $db = DB::conn();

        $row = $db->row("SELECT * FROM users WHERE user_id = ?", array($string));
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