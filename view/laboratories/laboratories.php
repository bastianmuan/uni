<?php
    $laboratoryDao = new LaboratoryDao();
    $laboratories = $laboratoryDao->getLaboratories();
?>

<div class="container">
  <?php if(isset($_GET["d"])){ 
    $messageType = $_GET["d"] == 1 ? "alert-success" : "alert-danger";
    $message = $_GET["d"] == 1 ? "Laboratori eliminat correctament" : "No s'ha pogut eliminar el laboratori. Comprova que no te reserves actives";
  ?>
  <div class="alert <?php echo $messageType; ?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php echo $message; ?>
  </div>
  <?php } ?>

  <?php if(isset($_GET["c"])){ 
    $messageType = $_GET["c"] >= 1 ? "alert-success" : "alert-danger";
    $message = $_GET["c"] >= 1 ? "Laboratori creat correctament" : "S'ha produit un error a l'intentar crear un laboratori";
  ?>
  <div class="alert <?php echo $messageType; ?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php echo $message; ?>
  </div>
  <?php } ?>

  <h1 class = "display-5">LABORATORIS</h1>
  <br>
  <a href="editLaboratory.php" class="btn btn-info btn-sm">CREAR LABORATORI</a>
  <br><br>
  <table class = "table table-striped">
    <thead>
      <tr class = "info" style='text-align: center' >
        <th style='text-align: center' >Id</th>
        <th style='text-align: center' >Nom </th>
        <th style='text-align: center' >Descripció</th>
        <th style='text-align: center' >Estat</th>
        <th style='text-align: center' ></th>
      </tr>
    </thead>
    <?php
      $i=0;
        foreach($laboratories as $laboratory){
          $tdClass = $i++ % 2 == 0 ? "even" : "odd";
          echo "
          <tr style='text-align: center' >
            <td class=".$tdClass.">".$laboratory->getId()."</td>
            <td class=".$tdClass.">".$laboratory->getName()."</td>
            <td class=".$tdClass.">".$laboratory->getDescription()."</td>
            <td class=".$tdClass.">".($laboratory->getActive() == 1 ? "<span class='active'>Actiu</span>" : "<span class='inactive'>Inactiu</div>")."</td>
            
            <td class=".$tdClass.">
              <button type='button' class='btn btn-danger' data-type='el laboratori' data-name='".$laboratory->getName()."' 
              data-url='actions.php?action=deleteLaboratory&id=".$laboratory->getId()."' data-toggle='modal' data-target='#deleteModalCenter'>
                <i class='bi bi-trash'></i>
              </button>
              <button type='button' class='btn btn-primary' onclick='editItem(\"editLaboratory.php?id=".$laboratory->getId()."\")'>
                <i class='bi bi-pencil' ></i>
              </button>
            </td>
          </tr>";
        }
    ?>
  </table>
</div>