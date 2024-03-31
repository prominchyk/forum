<?php
class User {
    private $login;
    private $password;
    private $status;
    private $date;

    public function __construct($login, $password, $status, $date) {
        $this->login = $login;
        $this->password = $password;
        $this->status = $status;
        $this->date = $date;
    }

    public function __get($property) {
        return $this->$property;
    }

    public static function checkLogin($login) {
        $validlogin = '#^\w{4,10}$#';
        return preg_match($validlogin, $login);
    }

    public static function checkPassword($password) {
        $validPassword = '#^\w{6,12}$#';
        return preg_match($validPassword, $password);
    }

}
?>