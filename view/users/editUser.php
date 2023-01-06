<div class="center">
    <?php 
    $userId = isset($_GET["id"]) ? $_GET["id"] : 0;
    $userDao = new UserDao();
    // $laboratories = $laboratoryDao->getLaboratories();

    if ($userId > 0){
        echo "<h1 class = 'display-5'>EDIT</h1>";
        $userDao = new UserDao();
        $user = $userDao->getUserById($userId);
        $name = $user->getName();
        $surname = $user->getSurname();
        $email = $user->getEmail();
        $role = $user->getRole();
        $rfid = $user->getRfid();
        $active = $user->getActive();
    }else{
        echo "<h1 class = 'display-5'>CREATE</h1>";
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
        
        <table>
            <tr>
            
                <div class="form-group">
                    <td><label>Name</label></td>
                    <?php echo "<td><input name='name' placeholder='Enter users name' value='".$name."'></td>"; ?>
                </div>
            </tr>
            <tr>
                <div class="form-group">
                    <td><label>Surname</label></td>
                    <?php echo "<td><input name='surname' placeholder='Enter the user's surname' value='".$surname."'></td>"; ?>
                </div>
            </tr>
            <tr>
                <div class="form-group">
                    <td><label>Email</label></td>
                    <?php echo "<td><input name='email' placeholder='Enter the user's email' value='".$email."'></td>"; ?>
                </div>
            </tr>
            
            <?php if($userId == 0) { echo "
                <tr>
                    <div class='form-group'>
                        <td><label>Password</label></td>
                        <td><input autocomplete='false' name='password' type='password' placeholder='Enter the password' value='".$password."'></td>
                    </div>
                </tr>";}
            ?>

            <tr>
                <div class="form-group">
                    <td><label>Rfid card</label></td>
                    <?php echo "<td><input name='rfid' placeholder='Enter the user's rfid' value='".$rfid."'></td>"; ?>
                </div>
            </tr>
            <tr>
                <td><label>Role</label></td>
                <td>
                    <?php 
                    echo "<input type='radio' ".($user == null || ($user !=null && !$role == 1) ? "checked" : "")." name='role' value='2'  /> Client ";
                    echo "<input type='radio' ".($user !=null && $role == 1 ? "checked" : "")." name='role' value='1'  /> Administrator ";
                    ?>
                </td>
            </tr>
            <tr>
                <td><label>Choose Status</label></td>
                <td>
                    <?php 
                    echo "<input type='radio' ".($user == null || ($user !=null && !$user->getActive() == 1) ? "checked" : "")." name='active' value='0'  /> Inactive ";
                    echo "<input type='radio' ".($user !=null && $user->getActive() == 1 ? "checked" : "")." name='active' value='1'  /> Active";
                    ?>
                </td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">SAVE</button>
    </form>
</div>