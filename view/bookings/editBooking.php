<div class = "container">
<?php 

  $laboratoryDao = new LaboratoryDao();
  $machineDao = new MachineDao();
  $laboratories = $laboratoryDao->getLaboratories();

?>

<form action="actions.php" method="POST">
  <input type="hidden" name="action" value='createBooking'>
  
  <table>
    <tr>
      <td><label>Seleccionar màquina:</label></td>
      <td>
        <select name="machineId">
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
      </td>
    </tr>
    <tr>
        <td><label>Seleccionar data:</label></td>
        <td>
          <?php
            $date = new DateTime();
            $dateStr = $date->format('Y-m-d');
            echo "
            <input type='date' name='dia' value='".$dateStr."' min='".$dateStr."' max='2023-12-31'>
            "
          ?>
      </td>
    </tr>
    <tr>
      <td><label>Seleccionar data:</label></td>
      <td><input name="bookingDate" type="text" /></td>
    </tr>
  </table>
  <button type="submit" class="btn btn-primary">SAVE</button>
</form>
</div>