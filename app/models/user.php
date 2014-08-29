<?php 
class User extends AppModel
{
    public $validation = array(
    'name' => array(
        'length' => array(
            'validate_between', 5, 30,
            ),
        'validname' => array(
            'name_format'
            ),
        ),

    'email' => array(
        'length' => array(
            'validate_between', 7, 30,
            ),
        'validemail' => array(
            'email_format'),
        ),
    'uname' => array(
        'length' => array(
            'validate_between', 6, 20,
            ),
        'validuname' => array(
            'uname_format'),
        ),
    'pwd' => array(
        'length'=> array(
            'validate_between', 5,30,
            ),
        // 'pwd_match' => array(
        //  'same_password', '',
        //  ),
        ),
    );
    public function adduser()
    {
        if(!$this->validate())
        {
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
                md5($this->pwd)
            )
        );
        $db->commit();
    }
    public function checklogin()
    {
        if(!$this->validate())
        {
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
        if($result){
            return $result;
        }
        $db->commit();
    }

}