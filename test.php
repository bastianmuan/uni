<?php 
  include_once("view/common/init.php");
include_once("view/common/head.php");

   
  
  /*********** USERS ***************/
    $userDao = new UserDao();
  
    $email = "bastian.muñoz@gmail.com";
    $password = "1234";
    
  //   $user = $userDao->getUser($email, $password);
  //   $userDao->deleteUser($user->getId());
  // die;

  
    $userDao->emailExists($email);
    
    $postUser = array(
      'name' => 'Bastian',
      'surname' => 'Muñoz',
      'email' => $email,
      'password' => $password,
      'role' => 0,
      'rfid' => 'ffffffff'
    );
    $createUserId = $userDao->createUser($postUser);
    
    // Utils::login($email,$password);

    // $user = $userDao->getUser($email, $password);
    
    // $putUser = array(
    //   'id' => $user->getId(),
    //   'name' => 'Jordi',
    //   'surname' => 'Valls',
    //   'role' => 1,
    //   'rfid' => 'AAAWWW',
    //   'active' => 0,

    // );

    // $userDao->updateUser($putUser);
       
    // $user = $userDao->getUser($email, $password);
    
    // $users = $userDao->getUsers();
    //$userDao->deleteUser($user->getId());

?>

<h1>USERS</h1>
<table border="1">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>SURNAME</td>
    <td>EMAIL</td>
    <td>ROLE</td>
    <td>RFID</td>
  </tr>
  <?php
      foreach($users as $user){
        echo "<tr><td>".$user->getId()."</td><td>".$user->getName()."</td><td>".$user->getSurname()."</td><td>".$user->getEmail()."</td><td>".$user->getRole()."</td><td>".$user->getRfId()."</td></tr>";
      }
  ?>
</table>


<?php

  /*********** LABORATORIES ********/
  $laboratoryDao = new LaboratoryDao();

  $postLaboratory = array(
    'name' => 'LAB 1',
    'description' => 'Descripcion Lab 1',
    'active' => 1,
  );
  $laboratoryIdCreated = $laboratoryDao->createLaboratory($postLaboratory);

  $putLaboratory = array(
    'id' => $laboratoryIdCreated,
    'name' => 'LAB 1 CHANGE',
    'description' => 'Descripcion Lab 1 CHANGE',
    'active' => 1,
  );
  $laboratoryDao->updateLaboratory($putLaboratory);
  
  $laboratoryDao->getLaboratories(); //All Machines!
  $laboratories = $laboratoryDao->getLaboratories($active = 1); //Only active machines!

  //$laboratoryDao->deleteLaboratory($laboratoryIdCreated);

?>

<h1>LABORATORIS</h1>
<table border="1">
  <tr>
    <td>ID</td><td>NAME</td><td>DESCRIPTION</td><td>ACTIVE</td>
  </tr>
  <?php
      foreach($laboratories as $laboratory){
        echo "<tr><td>".$laboratory->getId()."</td><td>".$laboratory->getName()."</td><td>".$laboratory->getDescription()."</td><td>".$laboratory->getActive()."</td></tr>";
      }
  ?>
</table>

<?php

  /*********** MACHINES *************/
  $laboratoryId = NULL;
  $laboratoryIdChange = $laboratories[0]->getId();
  $machineDao = new MachineDao();

  $postMachine = array(
    'name' => 'Máquina AAAAA',
    'description' => 'Descripcion de la máquina',
    'laboratoryId' => $laboratoryId,
    'active' => 1,
  );
  $machineIdcreated = $machineDao->createMachine($postMachine);
  
  $putMachine = array(
    'id' => $machineIdcreated,
    'name' => 'Máquina AAAAA Change',
    'description' => 'Descripcion de la máquina change',
    'laboratoryId' => $laboratoryIdChange,
    'active' => 1,
  );
  $machineDao->updateMachine($putMachine);


  $machineDao->getMachines($active = 1); //Only active machines!
  $machines = $machineDao->getMachines(); //All Machines!
  
  ?>

<h1>MACHINES</h1>
<table border="1">
  <tr>
    <td>ID</td><td>NAME</td><td>DESCRIPTION</td><td>LABORATORY_ID</td><td>ACTIVE</td>
  </tr>
  <?php
      foreach($machines as $machine){
        echo "<tr><td>".$machine->getId()."</td><td>".$machine->getName()."</td><td>".$machine->getDescription()."</td><td>".$machine->getLaboratoryId()."</td><td>".$machine->getActive()."</td></tr>";
      }
  ?>
</table>

<?php
  //$machineDao->deleteMachine($machineIdcreated);
  
  
?>


<?php

  /*********** BOOKINGS *************/
  
  
  $bookingDao = new BookingDao();

  $postBooking = array(
    'machineId' => $machines[0]->getId(),
    'bookingDate' => "2022-12-30 05:02:12",
  );

  $bookingIdCreated = $bookingDao->createBooking($postBooking);
  

  $activeBookings = $bookingDao->getActiveBookings(); //Only active bookings!
  $historyBookings = $bookingDao->getHistoryBookings(); //History bookings!
    
  ?>

<h1>ACTIVE BOOKINGS</h1>
<table border="1">
  <tr>
    <td>ID</td>
    <td>MACHINE_ID</td>
    <td>MACHINE_NAME</td>
    <td>LABORATORY_ID</td>
    <td>LABORATORY_NAME</td>
    <td>USER_Id</td>
    <td>USER_NAME</td>
    <td>USER_SURNAME</td>
    <td>USER_EMAIL</td>
  </tr>
  <?php
      foreach($activeBookings as $booking){
        echo "<tr><td>".$booking->getId()."</td><td>".$booking->getMachineId()."</td><td>".$booking->getMachineName()."</td>";
        echo "<td>".$booking->getLaboratoryId()."</td><td>".$booking->getLaboratoryName()."</td>";
        echo "<td>".$booking->getBookingUser()->getUserId()."</td><td>".$booking->getBookingUser()->getName()."</td>";
        echo "<td>".$booking->getBookingUser()->getSurname()."</td><td>".$booking->getBookingUser()->getEmail()."</td>";
        echo "</tr>";
      }
  ?>
</table>

<h1>HISTORY BOOKINGS</h1>
<table border="1">
  <tr>
    <td>ID</td>
    <td>MACHINE_ID</td>
    <td>MACHINE_NAME</td>
    <td>LABORATORY_ID</td>
    <td>LABORATORY_NAME</td>
    <td>USER_Id</td>
    <td>USER_NAME</td>
    <td>USER_SURNAME</td>
    <td>USER_EMAIL</td>
  </tr>
  <?php
      foreach($historyBookings as $booking){
        echo "<tr><td>".$booking->getId()."</td><td>".$booking->getMachineId()."</td><td>".$booking->getMachineName()."</td>";
        echo "<td>".$booking->getLaboratoryId()."</td><td>".$booking->getLaboratoryName()."</td>";
        echo "<td>".$booking->getBookingUser()->getUserId()."</td><td>".$booking->getBookingUser()->getName()."</td>";
        echo "<td>".$booking->getBookingUser()->getSurname()."</td><td>".$booking->getBookingUser()->getEmail()."</td>";
        echo "</tr>";
      }
  ?>
</table>


<?php
//  $bookingDao->deleteBooking($activeBookings[0]->getId());
//  $bookingDao->deleteBooking($historyBookings[0]->getId()); //No es borrarà!
?> 