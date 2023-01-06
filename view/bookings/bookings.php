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
      <tr class = "info">
        <th>Id</th>
        <th>MACHINE_ID</th>
        <th>MACHINE_NAME</th>
        <th>LABORATORY_ID</th>
        <th>LABORATORY_NAME</th>
        <th>USER_Id</th>
        <th>USER_NAME</th>
        <th>USER_SURNAME</th>
        <th>USER_EMAIL</th>
      </tr>
    </thead>
    <?php
        foreach($activeBookings as $booking){
          echo"
          <tr>
            <td>".$booking->getId()."</td>
            <td>".$booking->getMachineId()."</td>
            <td>".$booking->getMachineName()."</td>
            <td>".$booking->getLaboratoryId()."</td>
            <td>".$booking->getLaboratoryName()."</td>
            <td>".$booking->getBookingUser()->getUserId()."</td>
            <td>".$booking->getBookingUser()->getName()."</td>
            <td>".$booking->getBookingUser()->getSurname()."</td>
            <td>".$booking->getBookingUser()->getEmail()."</td>
          </tr>";
        }
    ?>
  </table>

  <h1 class = "display-5">HISTORY BOOKINGS</h1>
  <table class = "table table-striped">
    <thead>
      <tr class = "info">
        <th>ID</th>
        <th>MACHINE_ID</th>
        <th>MACHINE_NAME</th>
        <th>LABORATORY_ID</th>
        <th>LABORATORY_NAME</th>
        <th>USER_Id</th>
        <th>USER_NAME</th>
        <th>USER_SURNAME</th>
        <th>USER_EMAIL</th>
      </tr>
    </thread>
    <?php
        foreach($historyBookings as $booking){
          echo"
          <tr>
            <td>".$booking->getId()."</td>
            <td>".$booking->getMachineId()."</td>
            <td>".$booking->getMachineName()."</td>
            <td>".$booking->getLaboratoryId()."</td>
            <td>".$booking->getLaboratoryName()."</td>
            <td>".$booking->getBookingUser()->getUserId()."</td>
            <td>".$booking->getBookingUser()->getName()."</td>
            <td>".$booking->getBookingUser()->getSurname()."</td>
            <td>".$booking->getBookingUser()->getEmail()."</td>
          </tr>";
        }
    ?>
  </table>
</div>