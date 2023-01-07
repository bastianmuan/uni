<?php
class Actions{

  public static function login($params){
    if(!isset($params["email"]) && !isset($params["password"])){
      header('Location: '.URL.'/login.php?e=1');
    }
    
    $response = Utils::login($params["email"],$params["password"]);
    var_dump($response);

    if($response){
      header('Location: '.URL);
    }else{
      header('Location: '.URL.'/login.php?e=2');
    }
  }

  public static function requireAdmin(){
    if(!Utils::isAdmin()){
      header('Location: '.URL);
    }
  }

  public static function requireLogin(){
    if(!Utils::isLogged()){
      header('Location: '.URL);
    }
  }

  public static function createMachine($params){
    Actions::requireAdmin();
    $dao = new MachineDao();
    $response = $dao->createMachine($params);
    header('Location: '.URL_MACHINES."?c=".$response);
  }

  public static function updateMachine($params){
    Actions::requireAdmin();
    $dao = new MachineDao();
    $dao->updateMachine($params);
    header('Location: '.URL_MACHINES);
  }

  public static function deleteMachine($params){
    Actions::requireAdmin();
    $dao = new MachineDao();
    $response = $dao->deleteMachine($params["id"]);
    header('Location: '.URL_MACHINES.'?d='.$response);
  }

  public static function createLaboratory($params){
    Actions::requireAdmin();
    $dao = new LaboratoryDao();
    $response = $dao->createLaboratory($params);
    header('Location: '.URL_LABORATORIES."?c=".$response);
  }

  public static function updateLaboratory($params){
    Actions::requireAdmin();
    $dao = new LaboratoryDao();
    $dao->updateLaboratory($params);
    header('Location: '.URL_LABORATORIES);
  }

  public static function deleteLaboratory($params){
    Actions::requireAdmin();
    $dao = new LaboratoryDao();
    $response = $dao->deleteLaboratory($params["id"]);
    header('Location: '.URL_LABORATORIES."?d=".$response);
  }

  public static function createUser($params){
    Actions::requireAdmin();
    $dao = new UserDao();
    $response = $dao->createUser($params);
    header('Location: '.URL_USERS."?c=".$response);
  }

  public static function updateUser($params){
    Actions::requireAdmin();
    $dao = new UserDao();
    $dao->updateUser($params);
    header('Location: '.URL_USERS);
  }

  public static function deleteUser($params){
    Actions::requireAdmin();
    $dao = new UserDao();
    $dao->deleteUser($params["id"]);

    //Si l'usuari que s'elimina és ell mateix. Fem logout.
    if(Utils::getSessionUser()->getId() == $params["id"]){
      Utils::logout();
    }
    header('Location: '.URL_USERS);
  }

  public static function createBooking($params){
    Actions::requireLogin();
    $dao = new BookingDao();
    $response = $dao->createBooking($params);
    header('Location: '.URL_BOOKINGS."?c=".$response);
  }

  public static function startBooking($param){
    $dao = new BookingDao();
    return $dao->startBooking($param);
  }

  public static function stopBooking($param){
    $dao = new BookingDao();
    return $dao->endBooking($param);
  }

  public static function deleteBooking($params){
    Actions::requireLogin();
    $dao = new BookingDao();
    $response = $dao->deleteBooking($params["id"]);
    header('Location: '.URL_BOOKINGS."?d=".$response);
  }
}
?>