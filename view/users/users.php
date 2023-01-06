<?php
    $userDao = new UserDao();
    $users = $userDao->getUsers();
?>

<div class="container">
  <h1>USERS</h1>
  <br>
  <a href="editUser.php" class="btn btn-info btn-sm">Crete New User</a>
  <br><br>
  <table class = "table table-striped" >
  <thead>
      <tr class = "info">
        <th style='text-align: center' >Id</th>
        <th style='text-align: center' >Name</th>
        <th style='text-align: center' >Surname</th>
        <th style='text-align: center' >Email</th>
        <th style='text-align: center' >Role</th>
        <th style='text-align: center' >RFID</th>
        <th style='text-align: center' >Status</th>
        <th style='text-align: center' >Delete</th>
        <th style='text-align: center' >Edit</th>
      </tr>
    </thead>
    <?php
    //TODO NO mostra el id com toca
        foreach($users as $user){
          echo "
          <tr style='text-align: center' >
            <td>".$user->getId()."</td>
            <td>".$user->getName()."</td>
            <td>".$user->getSurname()."</td>
            <td>".$user->getEmail()."</td>
            <td>".($user->getRole() == 1 ? "Admin" : "Client")."</td>
            <td>".$user->getRfId()."</td>
            
            <td>".($user->getActive() == 1 ? "Active" : "Inactive")."</td>
            <td>
              <a href='actions.php?action=deleteUser&id=".$user->getId()."'class = 'btn btn-danger'> X </a>
            </td>
            <td>
              <a href='editUser.php?id=".$user->getId()."'class = 'btn btn-warning'> E </a>
            </td>
          </tr>";
        }
    ?>
  </table>
</div>