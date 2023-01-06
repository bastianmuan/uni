<div class="container">
<?php 
    $machineId = isset($_GET["machineId"]) ? $_GET["machineId"] : 0;
    $bookingDao = new BookingDao();

    /*** Possible filtre de dates a aplicar en un futur ***/
    if(Utils::isAdmin()){
      $startDate = "1900-01-01";
      $endDate = "2024-01-01";
    }else{
      //TODO Actualitzar 30 dies enrere!
      $startDate = "2022-12-02";
      $endDate = "2023-01-02";
      // Seria algo semblant a:
      // $startDate = new DateTime().diff('d',30).format("Y-m-d");
      // $endDate = new DateTime().format("Y-m-d");
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