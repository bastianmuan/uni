<?php 
  include_once("view/common/init.php");
  if(Utils::isLogged()){
    header('Location: '.URL);
  }
?>
<html>
  <?php include_once("view/common/head-login.php") ?>
  <body>
    <?php 
      #include_once("view/common/header.php");
      include("view/login/login.php");
      #include_once("view/common/footer.php"); 
    ?>
  </body>
</html>