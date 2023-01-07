<div class = "container">
    <i class="back bi bi-arrow-left-circle-fill" onclick="location.href='laboratories.php'">Tornar enrere</i>
    <?php 
    $laboratoryId = isset($_GET["id"]) ? $_GET["id"] : 0;

    if ($laboratoryId > 0){
        $laboratoryDao = new LaboratoryDao();
        $lab = $laboratoryDao->getLaboratory($laboratoryId);
        $name = $lab->getName();
        $description = $lab->getDescription();
        $active = $lab->getActive();
        echo "<h1 class = 'display-5'>EDITAR LABORATORI <b>".$name."</b></h1>";
    }else{
        echo "<h1 class = 'display-5'>CREAR LABORATORI</h1>";
        $name = "";
        $description = "";
        $active = 0;
        $lab = null;
    } ?>


    <form action="actions.php" method="POST">
        <input type="hidden" name="action" value='<?php if($laboratoryId > 0){ echo "updateLaboratory";}else{ echo "createLaboratory";} ?>'>
        <input type="hidden" name="id" value="<?php echo $laboratoryId; ?>">
        <div class="form-group">
            <label for="InputName">Nom</label>
            <input name="name" type="input" required class="form-control" id="InputName" aria-describedby="emailHelp" value='<?php echo $name; ?>'>
        </div>
        <div class="form-group">
            <label for="InputDescription">Descripció</label>
            <textarea name="description" required class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $description; ?></textarea>
        </div>
        <?php 
            $checkedInactive = $lab == null || ($lab !=null && !$lab->getActive() == 1) ? "checked" : "";
            $checkedActive = $checkedInactive == "" ? "checked" : "";
        ?>
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
</div>
