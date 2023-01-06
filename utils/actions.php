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
    $dao->createMachine($params);
    header('Location: '.URL_MACHINES);
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
    $dao->deleteMachine($params["id"]);
    header('Location: '.URL_MACHINES);
  }

  public static function createLaboratory($params){
    Actions::requireAdmin();
    $dao = new LaboratoryDao();
    $dao->createLaboratory($params);
    header('Location: '.URL_LABORATORIES);
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
    $dao->deleteLaboratory($params["id"]);
    header('Location: '.URL_LABORATORIES);
  }

  public static function createUser($params){
    Actions::requireAdmin();
    $dao = new UserDao();
    $dao->createUser($params);
    header('Location: '.URL_USERS);
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
    header('Location: '.URL_USERS);
  }

  public static function createBooking($params){
    Actions::requireLogin();
    $dao = new BookingDao();
    $dao->createBooking($params);
    header('Location: '.URL_BOOKINGS);
  }

  public static function startBooking($param){
    $dao = new BookingDao();
    return $dao->startBooking($param);
  }

  public static function stopBooking($param){
    $dao = new BookingDao();
    return $dao->endBooking($param);
  }
}
?>