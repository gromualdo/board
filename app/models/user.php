<?php 
class User extends AppModel
{
    public $same_password = true;
    public $validation = array(
    'name' => array(
        'length' => array(
            'is_between', MAX_LENGTH, MIN_LENGTH
            ),
        'validname' => array(
            'is_name'
            ),
        ),

    'email' => array(
        'length' => array(
            'is_between', MAX_LENGTH, MIN_LENGTH
            ),
        'validemail' => array(
            'is_email'
            ),
        ),
    'username' => array(
        'length' => array(
            'is_between', MAX_LENGTH, MIN_LENGTH
            ),
        'validuname' => array(
            'is_username'),
        ),
    'password' => array(
        'length'=> array(
            'is_between', MAX_LENGTH, MIN_LENGTH
            ),
        'validpwd' => array(
            'is_password'),
        ),
    );

    /**
     * Adds new user
     */
    public function addUser()
    {
        $this->same_password = is_equal($this->password, $this->password2);
        if (!$this->validate() || !$this->same_password ) {
            throw new ValidationException('invalid name');
        }
        $db = DB::conn();
        $db->begin();
        $params = array(
            'name'          => $this->name, 
            'emailaddress'  => $this->email, 
            'username'      => $this->username, 
            'password'      => md5($this->password)
            );
        $db->insert("users", $params); 
        $db->commit();           
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
        $db->begin();
        $result = $db->rows("SELECT * FROM users WHERE 
            username = ? AND
            password = ?",
            array(
            $this->username,
            md5($this->password)
            )
        );
        if ($result) {
            return $result;
        }
    }
}