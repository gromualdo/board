<?php 
class User extends AppModel
{
    public $same_password = true;
    public $validation = array(
    'name' => array(
        'length' => array(
            'validateBetween', MAX_LENGTH, MIN_LENGTH
            ),
        'validname' => array(
            'nameFormat'
            ),
        ),

    'email' => array(
        'length' => array(
            'validateBetween', MAX_LENGTH, MIN_LENGTH
            ),
        'validemail' => array(
            'emailFormat'
            ),
        ),
    'uname' => array(
        'length' => array(
            'validateBetween', MAX_LENGTH, MIN_LENGTH
            ),
        'validuname' => array(
            'unameFormat'),
        ),
    'pwd1' => array(
        'length'=> array(
            'validateBetween', MAX_LENGTH, MIN_LENGTH
            ),
        'validpwd' => array(
            'pwdFormat'),
        ),
    );

    /**
     * Adds new user
     */
    public function addUser()
    {
        $this->same_password = isEqual($this->pwd1, $this->pwd2);
        if (!$this->validate() || !$this->same_password ) {
            throw new ValidationException('invalid name');
        }
        $db = DB::conn();
        $db->begin();
        $db->query("INSERT INTO users SET 
            name = ?, 
            emailaddress = ?, 
            username = ?, 
            password = ?, 
            created=NOW()", 
            array(
                $this->name, 
                $this->email, 
                $this->uname, 
                md5($this->pwd1)
            )
        );
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
        $db->commit();
    }
}