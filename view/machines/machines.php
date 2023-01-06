<?php
    $machineDao = new MachineDao();
    $machines = $machineDao->getMachines();
?>

<div class="container">
  <h1 class = "display-5">MACHINES</h1>
  <br>
  <a href="editMachine.php" class="btn btn-info btn-sm">Crete New Machine</a>
  <br><br>
  <table class = "table table-striped" >
    <thead>
      <tr class = "info">
        <th>Id</th>
        <th>Name</th>
        <th>Description</th>
        <th>Lab_Id</th>
        <th>Status</th>
        <th>Delete</th>
        <th>Edit</th>
      </tr>
    </thead>
    <?php
        $laboratoryDao = new LaboratoryDao();
        foreach($machines as $machine){

          if($machine->getLaboratoryId() != null){
            $laboratory = $laboratoryDao->getLaboratory($machine->getLaboratoryId());
            $laboratoryName = $laboratory->getName();
          }else{
            $laboratoryName = " - ";
          }
          
          echo "
          <tr>
            <td>".$machine->getId()."</td>
            <td>".$machine->getName()."</td>
            <td>".$machine->getDescription()."</td>
            <td>".$laboratoryName."</td>
            <td>".($machine->getActive() == 1 ? "Active" : "Inactive")."</td>
            <td>
              <a href='actions.php?action=deleteMachine&id=".$machine->getId()."'class = 'btn btn-danger'> X </a>
            </td>
            <td>
              <a href='editMachine.php?id=".$machine->getId()."'class = 'btn btn-warning'> E </a>
            </td>
          </tr>";
        } 
    ?>
  </table>
</div>