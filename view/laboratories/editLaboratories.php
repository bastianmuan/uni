<div class = "container">
    <?php 
    $laboratoryId = isset($_GET["id"]) ? $_GET["id"] : 0;

    if ($laboratoryId > 0){
        echo "<h1 class = 'display-5'>EDIT</h1>";
        $laboratoryDao = new LaboratoryDao();
        $lab = $laboratoryDao->getLaboratory($laboratoryId);
        $name = $lab->getName();
        $description = $lab->getDescription();
        $active = $lab->getActive();
    }else{
        echo "<h1 class = 'display-5'>CREATE</h1>";
        $name = "Lab. ";
        $description = "";
        $active = 0;
        $lab = null;
    } ?>

    <form action="actions.php" method="POST">
        <input type="hidden" name="action" value='<?php if($laboratoryId > 0){ echo "updateLaboratory";}else{ echo "createLaboratory";} ?>'>
        <input type="hidden" name="id" value="<?php echo $laboratoryId; ?>">
        
        <table>
            <tr>
                <div class="form-group">
                    <td><label>Name</label></td>
                    <?php echo "<td><input name='name' value='".$name."'></td>"; ?>
                </div>
            </tr>
            <tr>
                <div class="form-group">
                    <td><label>Description</label></td>
                    <?php echo "<td><input name='description' value='".$description."'></td>"; ?>
                </div>
            </tr>
            <tr>
                <td><label>Choose Status</label></td>
                <td>
                    <?php 
                    echo "<input type='radio' ".($lab == null || ($lab !=null && !$lab->getActive() == 1) ? "checked" : "")." name='active' value='0'  /> Inactive ";
                    echo "<input type='radio' ".($lab != null && $lab->getActive() == 1 ? "checked" : "")." name='active' value='1'  /> Active";
                    ?>
                </td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">SAVE</button>
    </form>
</div>
