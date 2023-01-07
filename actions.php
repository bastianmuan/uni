<?php 
include_once("view/common/init.php");

$action = isset($_POST["action"]) ? $_POST["action"] : (isset($_GET["action"]) ? $_GET["action"] : null);
if($action == null){
  header('Location: '.URL);
}

switch ($action) {
  case "login":
    Actions::Login($_POST);    
    break;
  
  case "createBooking":
    Actions::createBooking($_POST);
    break;

  case "deleteBooking":
    Actions::deleteBooking($_GET);
    break;

  case "createMachine":
    Actions::createMachine($_POST);
    break;

  case "updateMachine":
    Actions::updateMachine($_POST);
    break;

  case "deleteMachine":
    Actions::deleteMachine($_GET);
    break;

  case "createLaboratory":
    Actions::createLaboratory($_POST);
    break;

  case "updateLaboratory":
    Actions::updateLaboratory($_POST);
    break;

  case "deleteLaboratory":
    Actions::deleteLaboratory($_GET);
    break;

  case "createUser":
    Actions::createUser($_POST);
    break;

  case "updateUser":
    Actions::updateUser($_POST);
    break;

  case "deleteUser":
    Actions::deleteUser($_GET);
    break;

  default:
    header('Location: '.URL);
}

?>