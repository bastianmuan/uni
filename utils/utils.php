<?php
class Utils
{
    public static function isLogged(){
        return isset($_SESSION["user"]);
    }

    public static function isAdmin(){
       
        return isset($_SESSION["user"]) && $_SESSION["user"] -> isAdmin();
    }

    public static function logout(){
        unset($_SESSION["user"]);
    }

    public static function login($email, $password){
        $userDao = new UserDao();
        $response = $userDao->getUser($email,$password);
        if($response == null){
            return false;
        }
        $_SESSION["user"] = $response;
        return true;
    }

    public static function getSessionUser(){
        return isset($_SESSION["user"]) ? $_SESSION["user"] : null;
    }
}
?>