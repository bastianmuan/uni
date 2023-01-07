<?php 
  include_once("view/common/init.php");
  $bookingDao = new BookingDao();
  $hours = $bookingDao->getAvailableHours($_GET["date"],$_GET["machineId"]);
?>
<div class="form-group">
  <label for="InputDescription">Hores disponibles</label>
  <select class="form-control" name="bookingHour">
    <?php 
      foreach($hours as $hour){ 
        echo "<option value=".$hour.">".$hour.":00 - ".($hour+1).":00</option>";
      }
    ?>
  </select>
</div>