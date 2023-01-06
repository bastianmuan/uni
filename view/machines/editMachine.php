<div class = "container">
    <?php 
    $machineId = isset($_GET["id"]) ? $_GET["id"] : 0;
    $laboratoryDao = new LaboratoryDao();
    $laboratories = $laboratoryDao->getLaboratories();

    if ($machineId > 0){
        echo "<h1 class = 'display-5'>EDIT</h1>";
        $machineDao = new MachineDao();
        $machine = $machineDao->getMachine($machineId);
        $name = $machine->getName();
        $description = $machine->getDescription();
    }else{
        echo "<h1 class = 'display-5'>CREATE</h1>";
        $name = "";
        $description = "";
        $machine = null;
    } ?>

    <form action="actions.php" method="POST">
        <input type="hidden" name="action" value='<?php if($machineId > 0){ echo "updateMachine";}else{ echo "createMachine";} ?>'>
        <input type="hidden" name="id" value="<?php echo $machineId; ?>">
        
        <table>
            <tr>
                <div class="form-group">
                    <td><label>Name</label></td>
                    <?php echo "<td><input name='name' placeholder='Enter the name' value='".$name."'></td>"; ?>
                </div>
            </tr>
            <tr>
            </tr>
            <tr>
                <div class="form-group">
                    <td><label>Description</label></td>
                    <?php echo "<td><input name='description' placeholder='Enter the description' value='".$description."'></td>"; ?>
                </div>
            </tr>
            <tr>
                <div class="form-group">
                    <td><label>Laboratory</label></td>
                    <td>
                        <select name="laboratoryId">
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
                    </td>
                </div>
            </tr>
            <tr>
                <td><label>Activo</label></td>
                <td>
                    <?php 
                    echo "<input type='radio' ".($machine == null || ($machine !=null && !$machine->getActive() == 1) ? "checked" : "")." name='active' value='0'  /> No ";
                    echo "<input type='radio' ".($machine !=null && $machine->getActive() == 1 ? "checked" : "")." name='active' value='1'  /> Si";
                    ?>
                </td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">SAVE</button>
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