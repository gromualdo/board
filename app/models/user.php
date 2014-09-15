<?php 
class User extends AppModel
{
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
}