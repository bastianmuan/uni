<?php
class User
{
    private $id;

    private $name;

    private $surname;

    private $email;
    
    private $password;
    
    private $role;

    private $rfid;

    private $active;
        
    public function __construct($bbddUser) {
        $this->id = $bbddUser["id"];
        $this->name = $bbddUser["name"];
        $this->surname = $bbddUser["surname"];
        $this->email = $bbddUser["email"];
        $this->role = $bbddUser["role"];
        $this->rfid = $bbddUser["rfid"];
        $this->active = $bbddUser["active"];
    }

    public function isAdmin(){
        return $this->role == 1;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getSurname(){
        return $this->surname;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getRole(){
        return $this->role;
    }

    public function getRfid(){
        return $this->rfid;
    }
    
    public function getActive(){
        return $this->active;
    }
}
?>