<div class = "container">
    <i class="back bi bi-arrow-left-circle-fill" onclick="location.href='users.php'">Tornar enrere</i>
    <?php 
    $userId = isset($_GET["id"]) ? $_GET["id"] : 0;
    $userDao = new UserDao();

    if ($userId > 0){
        $userDao = new UserDao();
        $user = $userDao->getUserById($userId);
        $name = $user->getName();
        $surname = $user->getSurname();
        $email = $user->getEmail();
        $role = $user->getRole();
        $rfid = $user->getRfid();
        $active = $user->getActive();
        echo "<h1 class = 'display-5'>EDITAR USUARI <b>".$name." ".$surname."</b></h1>";
    }else{
        echo "<h1 class = 'display-5'>CREAR USUARI</h1>";
        $name = "";
        $surname = "";
        $email = "";
        $password = "";
        $rfid = "";
        $role = 1;
        $active = 1;
        $user = null;
    } ?>

    <form action="actions.php" method="POST">
        <input type="hidden" name="action" value='<?php if($userId > 0){ echo "updateUser";}else{ echo "createUser";} ?>'>
        <input type="hidden" name="id" value="<?php echo $userId; ?>">
        
        <div class="form-group">
            <label for="InputName">Nom</label>
            <input name="name" type="input" required class="form-control" id="InputName" value='<?php echo $name; ?>' placeholder='Introdueixi un nom'>
        </div>
        <div class="form-group">
            <label for="InputName">Cognoms</label>
            <input name="surname" type="input" required class="form-control" id="InputName" value='<?php echo $surname; ?>' placeholder='Introdueixi els cognoms'>
        </div>
        <div class="form-group">
            <label for="InputName">Correu electrònic</label>
            <input name="email" <?php if($userId > 0){ echo "readonly"; } ?> type="input" required class="form-control" id="InputName" value='<?php echo $email; ?>' placeholder='Introdueixi un correu electrònic'>
        </div>
        <?php if($userId == 0) { ?>
          <div class="form-group">
          <label for="InputName">Contrasenya</label>
          <input autocomplete='false' name="password" type="password" required class="form-control" id="InputName" value='<?php echo $password; ?>' placeholder='Introdueixi una contrasenya'>
          </div>
        <?php } ?>
        
        <div class="form-group">
            <label for="InputName">Tarjeta RFID</label>
            <input name="rfid" type="input" required class="form-control" id="InputName" value='<?php echo $rfid; ?>' placeholder='Introdueixi el codi RFID de l\"usuari'>
        </div>


        <?php 
            $checkedInactive = $user == null || ($user !=null && !$role == 1) ? "checked" : "";
            $checkedActive = $checkedInactive == "" ? "checked" : "";
        ?>
        <div class="form-group">
            <label for="InputDescription">Rol</label>
            <div class="form-check form-check-inline" style="padding-left:15px">
                <input <?php echo $checkedInactive; ?> class="form-check-input" type="radio" name="role" id="inlineRadio1" value="2">
                <label class="form-check-label" for="inlineRadio1">Client</label>
            </div>
            <div class="form-check form-check-inline">
                <input <?php echo $checkedActive; ?> class="form-check-input" type="radio" name="role" id="inlineRadio2" value="1">
                <label class="form-check-label" for="inlineRadio2">Administrador</label>
            </div>
        </div>
       
        <?php 
            $checkedInactive = $user == null || ($user !=null && !$user->getActive()) == 1 ? "checked" : "";
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