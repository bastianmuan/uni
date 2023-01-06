<?php
    $laboratoryDao = new LaboratoryDao();
    $laboratories = $laboratoryDao->getLaboratories();
?>

<div class="container">
  <h1 class = "display-5">LABORATORIES</h1>
  <br>
  <a href="editLaboratory.php" class="btn btn-info btn-sm">Create New Lab</a>
  <br><br>
  <table class = "table table-striped">
    <thead>
      <tr class = "info" style='text-align: center' >
        <th style='text-align: center' >Id</th>
        <th style='text-align: center' >Name</th>
        <th style='text-align: center' >Description</th>
        <th style='text-align: center' >Status</th>
        <th style='text-align: center' >Delete</th>
        <th style='text-align: center' >Edit</th>
      </tr>
    </thead>
    <?php
        foreach($laboratories as $laboratory){
          echo "
          <tr style='text-align: center' >
            <td>".$laboratory->getId()."</td>
            <td>".$laboratory->getName()."</td>
            <td>".$laboratory->getDescription()."</td>
            <td>".($laboratory->getActive() == 1 ? "Active" : "Inactive")."</td>
            <td>
              <a href='actions.php?action=deleteLaboratory&id=".$laboratory->getId()."'class = 'btn btn-danger'> X </a>
            </td>
            <td>
              <a href='editLaboratory.php?id=".$laboratory->getId()."'class = 'btn btn-warning'> E </a>
            </td>
          </tr>";
        }
    ?>
  </table>
</div>