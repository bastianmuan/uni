<?php 
  include_once("view/common/init.php");
  $entityBody = file_get_contents('php://input');
  $response = Actions::stopBooking($entityBody);
  echo $response;
?>