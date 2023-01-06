<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);

  include_once "daos/dao.php";
  foreach (glob("models/*.php") as $filename) { include_once $filename; }
  foreach (glob("daos/*.php") as $filename) { include_once $filename; }
  include_once("utils/utils.php");
  include_once("utils/actions.php");
  session_start();
  define('URL', 'http://localhost/uni');
  define('URL_USERS', URL.'/users.php');
  define('URL_LABORATORIES', URL.'/laboratories.php');
  define('URL_MACHINES', URL.'/machines.php');
  define('URL_BOOKINGS', URL.'/bookings.php');
?>