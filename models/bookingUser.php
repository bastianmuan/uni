<?php
class BookingUser
{
    
    private $userId;

    private $name;

    private $surname;

    private $email;
        
    public function __construct($bbddBookingUser) {
        $this->userId = $bbddBookingUser["user_id"];
        $this->name = $bbddBookingUser["name"];
        $this->surname = $bbddBookingUser["surname"];
        $this->email = $bbddBookingUser["email"];
    }

    public function getUserId(){
        return $this->userId;
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
}

?>