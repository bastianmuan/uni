<div class = "container">
<i class="back bi bi-arrow-left-circle-fill" onclick="location.href='bookings.php'">Tornar enrere</i>
<?php 

  $laboratoryDao = new LaboratoryDao();
  $machineDao = new MachineDao();
  $laboratories = $laboratoryDao->getLaboratories();

?>
  <h1 class = 'display-5'>CREAR RESERVA</h1>
  <br>
  <form action="actions.php" method="POST">
    <input type="hidden" name="action" value='createBooking'>
    <div class="form-group">
        <label for="InputName">Seleccionar màquina</label>
        <select class="form-control __machineId__" name="machineId">
        <?php 
          foreach($laboratories as $laboratory){
            $machines = $machineDao->getMachines(1, $laboratory->getId());
            if(count($machines) > 0){
              
              echo "<optgroup label='".$laboratory->getName()."'>";
              foreach($machines as $machine){
                echo "<option value='".$machine->getId()."'>".$machine->getName()."</option>";
              }
              echo "</optgroup>";
            } 
          }
        ?>
      </select>
    </div>

    <div class="form-group">
        <label for="InputDescription">Seleccionar data</label>
        <?php
          $date = new DateTime();
          $dateStr = $date->format('Y-m-d');
          echo "<input type='date' name='bookingDate' required min='".$dateStr."' max='2023-12-31' onChange='changeBookingDate(this);'>";
        ?>
    </div>
    <div class="__booking_hour__">

        </div>

    <button type="submit" class="btn btn-primary">GUARDAR</button>
  </form>
</div>