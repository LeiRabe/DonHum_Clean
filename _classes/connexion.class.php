<?php

class Connexion{
    public $userMail;
    public $userPass;

    function __construct($userMail, $userPass) {
        $this->userMail = $userMail;
        $this->userPass = $userPass;
    }

    function Login($type){
        if($type == TYPE_ASSOCIATION){
            $loginUser = DBConnect::getInstance()->prepare('SELECT * FROM association WHERE emailAsso = ? AND mdpAsso = ? LIMIT 1');
            $loginUser->execute(array($this->userMail, md5($this->userPass)));
        }
        elseif ($type == TYPE_PARTICULIER){
            $loginUser = DBConnect::getInstance()->prepare('SELECT * FROM particulier WHERE emailPar = ? AND mdpPar = ? LIMIT 1');
            $loginUser->execute(array($this->userMail, md5($this->userPass)));
        }
        return ($loginUser->rowCount() != 0);
    }



}