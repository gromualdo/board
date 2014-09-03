<?php 
class User extends AppModel
{
    public $same_password = true;
    public $validation = array(
    'name' => array(
        'length' => array(
            'validate_between', MAX_LENGTH, MIN_LENGTH
            ),
        'validname' => array(
            'name_format'
            ),
        ),

    'email' => array(
        'length' => array(
            'validate_between', MAX_LENGTH, MIN_LENGTH
            ),
        'validemail' => array(
            'email_format'),
        ),
    'uname' => array(
        'length' => array(
            'validate_between', MAX_LENGTH, MIN_LENGTH
            ),
        'validuname' => array(
            'uname_format'),
        ),
    'pwd1' => array(
        'length'=> array(
            'validate_between', MAX_LENGTH, MIN_LENGTH
            ),
        'validpwd' => array(
            'pwd_format'),
        ),
    );
    public function adduser()
    {
        $this->same_password = is_equal($this->pwd1, $this->pwd2);
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
    public function checklogin()
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