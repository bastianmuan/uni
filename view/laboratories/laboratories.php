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
      <tr class = "info">
        <th>Id</th>
        <th>Name</th>
        <th>Description</th>
        <th>Status</th>
        <th>Delete</th>
        <th>Edit</th>
      </tr>
    </thead>
    <?php
        foreach($laboratories as $laboratory){
          echo "
          <tr>
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