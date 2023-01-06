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
        <th>Id</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Email</th>
        <th>Role</th>
        <th>RFID</th>
        <th>Status</th>
        <th>Delete</th>
        <th>Edit</th>
      </tr>
    </thead>
    <?php
    //TODO NO mostra el id com toca
        foreach($users as $user){
          echo "
          <tr>
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