<?php 
  include_once("view/common/init.php");
  Actions::requireAdmin();
?>

<html>
  <?php include_once("view/common/head.php") ?>
  <body>
    <?php 
      include_once("view/common/header.php");
      include("view/laboratories/laboratories.php");
      include_once("view/common/footer.php"); 
    ?>
  </body>
</html>