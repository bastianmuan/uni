<div class = "container">
    <i class="back bi bi-arrow-left-circle-fill" onclick="location.href='machines.php'">Tornar enrere</i>
    <?php 
    $machineId = isset($_GET["id"]) ? $_GET["id"] : 0;
    $laboratoryDao = new LaboratoryDao();
    $laboratories = $laboratoryDao->getLaboratories();

    if ($machineId > 0){
        $machineDao = new MachineDao();
        $machine = $machineDao->getMachine($machineId);
        $name = $machine->getName();
        $description = $machine->getDescription();
        echo "<h1 class = 'display-5'>EDITAR MÀQUINA <b>".$name."</b></h1>";
    }else{
        echo "<h1 class = 'display-5'>CREAR MÀQUINA</h1>";
        $name = "";
        $description = "";
        $machine = null;
    } ?>

    <form action="actions.php" method="POST">
      <input type="hidden" name="action" value='<?php if($machineId > 0){ echo "updateMachine";}else{ echo "createMachine";} ?>'>
      <input type="hidden" name="id" value="<?php echo $machineId; ?>">

      <div class="form-group">
          <label for="InputName">Nom</label>
          <input name="name" type="input" required class="form-control" id="InputName" aria-describedby="emailHelp" value='<?php echo $name; ?>'>
      </div>
      <div class="form-group">
          <label for="InputDescription">Descripció</label>
          <textarea name="description" required class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $description; ?></textarea>
      </div>
      <?php 
            $checkedInactive = $machine == null || ($machine !=null && !$machine->getActive() == 1) ? "checked" : "";
            $checkedActive = $checkedInactive == "" ? "checked" : "";
        ?>
      
      <div class="form-group">
        <label for="InputDescription">Laboratori</label>
        <select class="form-control" name="laboratoryId">
          <option value="NULL"></option>
          <?php 
          foreach($laboratories as $laboratory){
              $selected = "";
              if($machine !=null && $machine->getLaboratoryId() == $laboratory->getId()){
                  $selected = "selected";
              }
              echo "<option ".$selected." value=".$laboratory->getId().">".$laboratory->getName()."</option>";
          } ?>
        </select>
      </div>
      <div class="form-group">
          <label for="InputDescription">Estat</label>
          <div class="form-check form-check-inline" style="padding-left:15px">
              <input <?php echo $checkedInactive; ?> class="form-check-input" type="radio" name="active" id="inlineRadio1" value="0">
              <label class="form-check-label" for="inlineRadio1">Inactiu</label>
          </div>
          <div class="form-check form-check-inline">
              <input <?php echo $checkedActive; ?> class="form-check-input" type="radio" name="active" id="inlineRadio2" value="1">
              <label class="form-check-label" for="inlineRadio2">Actiu</label>
          </div>
      </div>
      <button type="submit" class="btn btn-primary">GUARDAR</button>
    </form>

    <?php 
        if($machineId > 0){ 
        $consumptionDao = new ConsumptionDao(); 
        $consumptions = $consumptionDao->getWeeklyConsumption($machineId);
        $totals = [];
        $days = [];
        foreach($consumptions as $consumption){
            array_push($totals,$consumption["total"]);
            array_push($days,"'".$consumption["name"]."'");
        }
        
        ?>
    <br />
    <br />
    <h3>Gràfica amb el consum dels últims 7 dies</h3>
    <br />
    <canvas id="myChart"></canvas>


    <script>

        var ctx = document.getElementById("myChart").getContext("2d");
        var myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [<?php echo implode(",", $days); ?>],
            datasets: [
            {
                label: "Consum en (Kw)",
                data: [<?php echo implode(",", $totals); ?>],
                backgroundColor: "rgba(153,205,1,0.6)",
            }
            ],
        },
        });
    </script>

    <?php } ?>
</div>