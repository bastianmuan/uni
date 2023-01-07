<?php
    $userDao = new UserDao();
    $users = $userDao->getUsers();
?>

<div class="container">
  <?php if(isset($_GET["d"])){ 
    $messageType = $_GET["d"] == 1 ? "alert-success" : "alert-danger";
    $message = $_GET["d"] == 1 ? "Usuari eliminat correctament" : "No s'ha pogut eliminar l'usuari.";
  ?>
  <div class="alert <?php echo $messageType; ?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php echo $message; ?>
  </div>
  <?php } ?>

  <?php if(isset($_GET["c"])){ 
    $messageType = $_GET["c"] >= 1 ? "alert-success" : "alert-danger";
    $message = $_GET["c"] >= 1 ? "Usuari creat correctament" : "S'ha produit un error a l'intentar crear un usuari";
  ?>
  <div class="alert <?php echo $messageType; ?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php echo $message; ?>
  </div>
  <?php } ?>

  <h1>USUARIS</h1>
  <br>
  <a href="editUser.php" class="btn btn-info btn-sm">CREAR USUARI</a>
  <br><br>
  <table class = "table table-striped" >
  <thead>
      <tr class = "info">
        <th style='text-align: center' >Id</th>
        <th style='text-align: center' >Nom</th>
        <th style='text-align: center' >Cognoms</th>
        <th style='text-align: center' >Correu electrònic</th>
        <th style='text-align: center' >Rol</th>
        <th style='text-align: center' >RFID</th>
        <th style='text-align: center' >Estat</th>
        <th style='text-align: center' ></th>
      </tr>
    </thead>
    <?php
      $i = 0;
      foreach($users as $user){
        $tdClass = $i++ % 2 == 0 ? "even" : "odd";
        echo "
        <tr style='text-align: center' >
          <td class=".$tdClass.">".$user->getId()."</td>
          <td class=".$tdClass.">".$user->getName()."</td>
          <td class=".$tdClass.">".$user->getSurname()."</td>
          <td class=".$tdClass.">".$user->getEmail()."</td>
          <td class=".$tdClass.">".($user->getRole() == 1 ? "Admin" : "Client")."</td>
          <td class=".$tdClass.">".$user->getRfId()."</td>
          <td class=".$tdClass.">".($user->getActive() == 1 ? "<span class='active'>Actiu</span>" : "<span class='inactive'>Inactiu</div>")."</td>
          <td class=".$tdClass.">
            <button type='button' class='btn btn-danger' data-type=\"l'usuari\" data-name='".$user->getName()." ".$user->getSurname()."' 
            data-url='actions.php?action=deleteUser&id=".$user->getId()."' data-toggle='modal' data-target='#deleteModalCenter'>
              <i class='bi bi-trash'></i>
            </button>
            <button type='button' class='btn btn-primary' onclick='editItem(\"editUser.php?id=".$user->getId()."\")'>
              <i class='bi bi-pencil' ></i>
            </button>
          </td>
        </tr>";
      }
    ?>
  </table>
</div>