<?php
    $machineDao = new MachineDao();
    $machines = $machineDao->getMachines();
?>

<div class="container">
  <?php if(isset($_GET["d"])){ 
    $messageType = $_GET["d"] == 1 ? "alert-success" : "alert-danger";
    $message = $_GET["d"] == 1 ? "Màquina eliminada correctament" : "No s'ha pogut eliminar la màquina. Comprova que no te reserves actives";
  ?>
    <div class="alert <?php echo $messageType; ?> alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $message; ?>
    </div>
  <?php } ?>  

  <?php if(isset($_GET["c"])){ 
    $messageType = $_GET["c"] >= 1 ? "alert-success" : "alert-danger";
    $message = $_GET["c"] >= 1 ? "Màquina creada correctament" : "S'ha produit un error a l'intentar crear una màquina";
  ?>
  <div class="alert <?php echo $messageType; ?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php echo $message; ?>
  </div>
  <?php } ?>
  <h1 class = "display-5">MÀQUINES</h1>
  

  
  <br>
  <a href="editMachine.php" class="btn btn-info btn-sm">CREAR MÀQUINA</a>
  <br><br>
  <table class = "table table-striped" >
    <thead>
      <tr class = "info">
        <th style='text-align: center' >Id</th>
        <th style='text-align: center' >Nom</th>
        <th style='text-align: center' >Descripció</th>
        <th style='text-align: center' >Laboratori</th>
        <th style='text-align: center' >Estat</th>
        <th style='text-align: center' ></th>
      </tr>
    </thead>
    <?php
        $laboratoryDao = new LaboratoryDao();
        $i=0;
        foreach($machines as $machine){

          if($machine->getLaboratoryId() != null){
            $laboratory = $laboratoryDao->getLaboratory($machine->getLaboratoryId());
            $laboratoryName = $laboratory->getName();
          }else{
            $laboratoryName = " - ";
          }
          
          $tdClass = $i++ % 2 == 0 ? "even" : "odd";
          echo "
          <tr style='text-align: center' >
            <td class=".$tdClass.">".$machine->getId()."</td>
            <td class=".$tdClass.">".$machine->getName()."</td>
            <td class=".$tdClass.">".$machine->getDescription()."</td>
            <td class=".$tdClass.">".$laboratoryName."</td>
            <td class=".$tdClass.">".($machine->getActive() == 1 ? "<span class='active'>Actiu</span>" : "<span class='inactive'>Inactiu</div>")."</td>
            <td class=".$tdClass.">
              <button type='button' class='btn btn-danger' data-type='la màquina' data-name='".$machine->getName()."' 
              data-url='actions.php?action=deleteMachine&id=".$machine->getId()."' data-toggle='modal' data-target='#deleteModalCenter'>
                <i class='bi bi-trash'></i>
              </button>
              <button type='button' class='btn btn-primary' onclick='editItem(\"editMachine.php?id=".$machine->getId()."\")'>
                <i class='bi bi-pencil' ></i>
              </button>
            </td>
          </tr>";
        } 
    ?>

  </table>
  
</div>