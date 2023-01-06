<?php 
  include_once("view/common/init.php");
  Actions::requireLogin();
?>

<html>
  <?php include_once("view/common/head.php") ?>
  <body>
    <?php 
      include_once("view/common/header.php");
      include("view/bookings/editBooking.php");
      include_once("view/common/footer.php"); 
    ?>
  </body>
</html>