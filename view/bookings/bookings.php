<div class="container">
  <?php if(isset($_GET["d"])){ 
    $messageType = $_GET["d"] == 1 ? "alert-success" : "alert-danger";
    $message = $_GET["d"] == 1 ? "Reserva anulada correctament" : "Error a l'intentar anular una reserva";
  ?>
  <div class="alert <?php echo $messageType; ?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php echo $message; ?>
  </div>
  <?php } ?>  

  <?php if(isset($_GET["c"])){ 
      $messageType = $_GET["c"] == 1 ? "alert-success" : "alert-danger";
      if($_GET["c"] == 1){
        $message = "Reserva realitzada correctament";
      }else if($_GET["c"] == 2){ //Max 3 reserves diaries
        $message = "Has superat el màxim de reserves diaries";
      }else if($_GET["c"] == 3){
        $message = "Has superat el màxim de reserves diaries";
      }
    ?>
    <div class="alert <?php echo $messageType; ?> alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $message; ?>
    </div>
    <?php } ?>  
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

  <h1 class = "display-5">RESERVES ACTIVES</h1>
  <br>
  <a href="editBooking.php" class="btn btn-info btn-sm">CREAR RESERVA</a>
  <br><br>

  <table class = "table table-striped">
    <thead>
      <tr class = 'info'>
        <th style='text-align: center' >Nº Reserva</th>
        <th style='text-align: center' >Màquina</th>
        <th style='text-align: center' >Laboratori</th>
        <th style='text-align: center' >Nom</th>
        <th style='text-align: center' >Data</th>
        <th style='text-align: center' ></th>
      </tr>
    </thead>

    <?php 
      $i = 0;
      foreach($activeBookings as $booking) { 
        $tdClass = $i++ % 2 == 0 ? "even" : "odd";
      ?>
      
      <tr style='text-align: center' >
        <td class="<?php echo $tdClass; ?>"><?php echo $booking->getId(); ?></td>
        <td class="<?php echo $tdClass; ?>"><?php echo $booking->getMachineName(); ?></td>
        <td class="<?php echo $tdClass; ?>"><?php echo $booking->getLaboratoryName(); ?></td>
        <td class="<?php echo $tdClass; ?>"><?php echo $booking->getBookingUser()->getName()." ".$booking->getBookingUser()->getSurname(); ?></td>
        <td class="<?php echo $tdClass; ?>"><?php echo $booking->getBookingDate(); ?></td>
        <td class="<?php echo $tdClass; ?>">
          <button type='button' class='btn btn-danger' data-type='la reserva del dia/hora ' data-name='<?php echo $booking->getBookingDate(); ?>' 
          data-url='actions.php?action=deleteBooking&id=<?php echo $booking->getId(); ?>' data-toggle='modal' data-target='#deleteModalCenter'>
          <i class='bi bi-trash'></i>
          </button>
        </td>
      </tr>
    <?php } ?>
  </table>
  
  <br><br>
  
  <h1 class = "display-5">HISTÒRIC DE RESERVES</h1>
  <table class = "table table-striped">
    <thead>
      <tr class = 'info'>
        <th style='text-align: center' >Nº</th>
        <th style='text-align: center' >Màquina</th>
        <th style='text-align: center' >Laboratori</th>
        <th style='text-align: center' >Nom</th>
        <th style='text-align: center' >Data</th>
        <th style='text-align: center' >Inici</th>
        <th style='text-align: center' >Final</th>
        <th style='text-align: center' >Consum</th>
        <th style='text-align: center' ></th>
      </tr>
    </thead>
    <?php 
      $i = 0;
      foreach($historyBookings as $booking) { 
        $tdClass = $i++ % 2 == 0 ? "even" : "odd";
    ?>
    <tr style='text-align: center' >
      <td class="<?php echo $tdClass; ?>"><?php echo $booking->getId(); ?></td>
      <td class="<?php echo $tdClass; ?>"><?php echo $booking->getMachineName(); ?></td>
      <td class="<?php echo $tdClass; ?>"><?php echo $booking->getLaboratoryName(); ?></td>
      <td class="<?php echo $tdClass; ?>"><?php echo $booking->getBookingUser()->getName()." ".$booking->getBookingUser()->getSurname(); ?></td>
      <td class="<?php echo $tdClass; ?>"><?php echo $booking->getBookingDate(); ?></td>
      <td class="<?php echo $tdClass; ?>"><?php echo $booking->getStartDate(); ?></td>
      <td class="<?php echo $tdClass; ?>"><?php echo $booking->getEndDate(); ?></td>
      <td class="<?php echo $tdClass; ?>"><?php echo $booking->getConsumption(); ?></td>
      <td class="<?php echo $tdClass; ?>"></td>
    </tr>
    <?php } ?>
  </table>
</div>