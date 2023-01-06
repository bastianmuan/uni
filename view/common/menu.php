<nav class="navbar navbar-expand-lg navbar-light bg-light p-4">
  <div class="container-fluid">
    <a href="index.php" class="navbar-brand text-primary fs-5 fw-bold">TechLab</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div  class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if(Utils::isLogged()){ ?>
        <li class="nav-item">
          <a class="nav-link" href="bookings.php">Reserves</a>
        </li>
        <?php } ?>
        <?php if(Utils::isAdmin()){ ?>
        <li class="nav-item">
          <a class="nav-link" href="laboratories.php">Laboratoris</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="machines.php">Màquines</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="users.php">Usuaris</a>
        </li>
        
        <?php } ?>


        <?php if(Utils::isLogged()){ ?>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="logout.php">Tancar sessió</a>
        </li>
        <?php }else{ ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="login.php">Identifica't</a>
          </li>
        <?php } ?>
        </ul>
    </div>
    <div>
      <?php 
        if(Utils::isLogged()){ 
          $userName = Utils::getSessionUser()->getName();
          echo "Hola, $userName";
        } ?>
    </div>
  </div>
</nav>