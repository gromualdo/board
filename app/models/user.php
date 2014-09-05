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
        $db->begin();
        $params = array(
            'name' => $this->name, 
            'emailaddress' => $this->email, 
            'username' => $this->username, 
            'password' => md5($this->password)
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
        $row = $db->row("SELECT * FROM users WHERE 
            username = ? AND
            password = ?",
            array(
            $this->username,
            md5($this->password)
            )
        );
        if ($row) {
            return $row;
        }

    }
}