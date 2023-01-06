<div class="container">
<?php 
    $machineId = isset($_GET["machineId"]) ? $_GET["machineId"] : 0;
    $bookingDao = new BookingDao();

    if(Utils::isAdmin()){
      // Agafem la data de avui
      $getDate = new DateTime();
      $endDate = $getDate->format('Y-m-d');
      $endDate = date("Y-m-d", strtotime($endDate . "+ 1 years"));
      //Marquem que nomes podem veure en el cas de que siguem admins 5 anys enrrera.
      $startDate = date("Y-m-d", strtotime($endDate . "- 5 years"));
      var_dump($startDate);
      var_dump($endDate);
    }else{
      // Agafem la data de avui
      $getDate = new DateTime();
      $endDate = $getDate->format('Y-m-d');
      $endDate = date("Y-m-d", strtotime($endDate . "+ 1 days"));
      //Marquem que nomes podem veure en el cas de que siguem usuaris 30 dies enrrera.
      $startDate = date("Y-m-d", strtotime($endDate . "- 30 days"));
    }

    $user = Utils::getSessionUser();
    $activeBookings = $bookingDao->getActiveBookings($machineId, $startDate, $endDate); //Only active bookings!
    $historyBookings = $bookingDao->getHistoryBookings($machineId, $startDate, $endDate); //History bookings!
?>

  <h1 class = "display-5">ACTIVE BOOKINGS</h1>
  <br>
  <a href="editBooking.php" class="btn btn-info btn-sm">Create booking</a>
  <br><br>

  <table class = "table table-striped">
    <thead>
      <?php
        if(Utils::isAdmin()) {
          echo "
          <tr class = 'info'>
            <th style='text-align: center' >Reserva</th>
            <th style='text-align: center' >IDMaquina</th>
            <th style='text-align: center' >ID Lab</th>
            <th style='text-align: center' >ID User</th>
            <th style='text-align: center' >Nom</th>
            <th style='text-align: center' >Cognom</th>
            <th style='text-align: center' >Email</th>
            <th style='text-align: center' >Data</th>
            <th style='text-align: center' >Delete</th>
          </tr>
          ";
        } else {
          echo "
          <tr class = 'info'>
            <th style='text-align: center' >Nom Maquina</th>
            <th style='text-align: center' >Nom Lab</th>
            <th style='text-align: center' >Data</th>
            <th style='text-align: center' >Delete</th>
          </tr>
          ";
        }
      ?>
    </thead>

    <?php
      if(Utils::isAdmin()) {
        foreach($activeBookings as $booking){
          echo"
          <tr style='text-align: center' >
            <td>".$booking->getId()."</td>
            <td>".$booking->getMachineId()."</td>
            <td>".$booking->getLaboratoryId()."</td>
            <td>".$booking->getBookingUser()->getUserId()."</td>
            <td>".$booking->getBookingUser()->getName()."</td>
            <td>".$booking->getBookingUser()->getSurname()."</td>
            <td>".$booking->getBookingUser()->getEmail()."</td>
            <td>".$booking->getBookingDate()."</td>
            <td>
              <a href='actions.php?action=deleteBooking&id=".$booking->getId()."'class = 'btn btn-danger'> X </a>
            </td>
          </tr>
          ";
        }
      } else {
        foreach($activeBookings as $booking){
          echo"
          <tr style='text-align: center' >
            <td>".$booking->getMachineName()."</td>
            <td>".$booking->getLaboratoryName()."</td>
            <td>".$booking->getBookingDate()."</td>
            <td>
              <a href='actions.php?action=deleteBooking&id=".$booking->getId()."'class = 'btn btn-danger'> X </a>
            </td>
          </tr>
          ";
        }
      }
    ?>
  </table>

  <h1 class = "display-5">HISTORY BOOKINGS</h1>
  <table class = "table table-striped">
  <thead>
      <?php
        if(Utils::isAdmin()) {
          echo "
          <tr class = 'info'>
            <th style='text-align: center' >Reserva</th>
            <th style='text-align: center' >IDMaquina</th>
            <th style='text-align: center' >ID Lab</th>
            <th style='text-align: center' >ID User</th>
            <th style='text-align: center' >Nom</th>
            <th style='text-align: center' >Cognom</th>
            <th style='text-align: center' >Email</th>
            <th style='text-align: center' >Data</th>
          </tr>
          ";
        } else {
          echo "
          <tr class = 'info'>
            <th style='text-align: center' >Nom Maquina</th>
            <th style='text-align: center' >Nom Lab</th>
            <th style='text-align: center' >Data</th>
          </tr>
          ";
        }
      ?>
    </thead>
    <?php
      if(Utils::isAdmin()) {
        foreach($historyBookings as $booking){
          echo"
          <tr style='text-align: center' >
            <td>".$booking->getId()."</td>
            <td>".$booking->getMachineId()."</td>
            <td>".$booking->getLaboratoryId()."</td>
            <td>".$booking->getBookingUser()->getUserId()."</td>
            <td>".$booking->getBookingUser()->getName()."</td>
            <td>".$booking->getBookingUser()->getSurname()."</td>
            <td>".$booking->getBookingUser()->getEmail()."</td>
            <td>".$booking->getBookingDate()."</td>
          </tr>
          ";
        }
      } else {
        foreach($historyBookings as $booking){
          echo"
          <tr style='text-align: center' >
            <td>".$booking->getMachineName()."</td>
            <td>".$booking->getLaboratoryName()."</td>
            <td>".$booking->getBookingDate()."</td>
          </tr>
          ";
        }
      }
    ?>
  </table>
</div>