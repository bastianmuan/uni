<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <!-- Required meta tags -->
    <title> TechlabHubs - Registra a un usuari </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<script>
function check_pwd(input) {
if (input.value != document.getElementById('password').value) {
    input.setCustomValidity('Les contrasenyes no coincideixen!');
    }
    else{
// input is valid -- reset the error message
    input.setCustomValidity('');
    }
    }
</script>
<script>
  function check_email(input) {
  if (input.value != document.getElementById('correu_new_user').value) {
      input.setCustomValidity('Els correus no coincideixen');
      }
      else{
  // input is valid -- reset the error message
      input.setCustomValidity('');
      }
      }
  </script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <title>TechLabHubs</title>

  </head>
  <body>
    
    <?php
    $title="Home";
    $page="home";
    include_once ("public-navbar.php");

  
    ?>
    

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
    <script src="./js/main.js"></script>
    <script src="/css/main3.css"></script>

  </body>
</html>

<!---- INTRO --->
<section name="new_user">
  <div class="container-md">
    <div class="text-center">
      <h2 class="text-primary mt-3">Registra a un nou usuari</h2>
      <p class="mt-4">En aquesta pàgina pots registrar a un usuari, definint així el seu rol.</p>
      <p> Si la teva intenció es canviar a un usuari existent d'usuari a administrador, has d' eliminar el seu compte actual i torna-ho a crear amb el rol corresponent.</p>
    </div>
<div class="row justify-content-center mt-2 mb-5">
  <div class="col-lg-6">

<form name="form" action="../porj_node/db/db_usuaris.php" method="post">
  <div class="mb-2">
    <label for="email_new_user" class="form-label">Correu electrònic:</label>
    <div class="mb-2 input-group">
      <span class="input-group-text">
        <i class="bi bi-person-circle"></i>
              </span>
      <input required ="required" maxlength="50" type="email" class="form-control" name="correu_new_user" placeholder="Exemple: pau@estudiantat.upc.edu">
    </div>
    <div id="emailHelp" class="form-text">Totes les dades demanades es corresponen a l'estudiant</div>
  </div>

  <div class="mb-2">
    <label for="email_new_user" class="form-label">Confirma correu electrònic:</label>
    <div class="mb-2 input-group">
      <span class="input-group-text">
        <i class="bi bi-person-circle"></i>
              </span>
      <input required ="required" oninput="check_email(this)" class="form-control" name="conf_correu_new_user">
      
    </div>
  </div>

  <div class="mb-2">
    <label for="name_new_user" class="form-label">Nom:</label>
    <div class="mb-2 input-group">
      <span class="input-group-text">
        <i class="bi bi-0-circle"></i>
              </span>
      <input required ="required" maxlength="29" class="form-control" name="name_new_user">
    </div>
  </div>

  <div class="mb-2">
    <label for ="surname_new_user" class="form-label">Primer cognom:</label>
    <div class="mb-2 input-group">
      <span class="input-group-text">
        <i class="bi bi-1-circle"></i>
              </span>
      <input required ="required"  class="form-control" maxlength="29" name="surname_new_user">
    </div>

    <div class="mb-2">
      <label for="second_surname_new_user" class="form-label">Segon cognom:</label>
      <div class="mb-2 input-group">
        <span class="input-group-text">
          <i class="bi bi-2-circle"></i>
                </span>
        <input required ="required"  class="form-control" maxlength="29" name="second_surname_new_user">
      </div>

  </div>

  <div class="mb-2">
    <label for="InputPassword1" class="form-label" placeholder = "Nom d'usuari" required="required">
      Contrasenya</label>
    <div class="mb-2 input-group">
      <span class="input-group-text">
      <i class="bi bi-lock"></i>
    </span>
    <input required ="required" pattern="[a-zA-Z\d.]{5,100}" maxlength="30" title="La contrasenya ha de ser de mínim 5 caràcters i pot tenir lletres, números o punts." 
    type="password" class="form-control" name="password">
    </div>
  </div>

  <div class="mb-3">
    <label for="InputPassword2" class="form-label">Repeteix contrasenya</label>
    <div class="mb-2 input-group">
      <span class="input-group-text">
      <i class="bi bi-lock"></i>
      </span>
    <input required="required" type="password" maxlength="30" class="form-control" 
    name="password_confirm" oninput="check_pwd(this)">
    </div>
  </div>

  <label for ="rol" class="form-label">Rol de l'usuari</label>
  <div class="mb-2 input-group">
    <span class="input-group-text">
    <i class="bi bi-question-circle"></i>
    </span>
  <select class="form-select" name="rol">
    <option value="administrator" selected> Administrador </option>
    <option value="user" selected> Usuari </option>
  </select>
  </div>

  <div class="mb-2">
    <label class="form-label">Valor de la targeta</label>
    <div class="mb-2 input-group">
      <span class="input-group-text">
      <i class="bi bi-credit-card"></i>
      </span>
    <input required="required" name="rfid_value" class="form-control" minlength ="8" maxlength="8">
    </div>
  </div>
  <button type="submit" value="enviar" class="mt-4 btn btn-secondary">Registra</button>
  <button type="reset" value="Borrar" class="mt-4 btn btn-secondary">Esborra</button>

</form>
  </div>
</div>
</div>
</section>
<!---- MAPA --->


<footer class="container-fluid bg-primary d-flex justify-content-center">
  <p class="text-light mt-2 mb-2">Tens alguna incidència? Contacta amb nosaltres! <a class = "text-white" href="https://wa.me/34666666666">+34 666 666 666</a></p>
</footer>

