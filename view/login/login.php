<div class="login">
      <h1 class="text-center">Log in</h1>
      <section id="content">
        <div class="container">
          <div class="row">
            <div class="span8">
              <img src="css/img/upc_entrada.jpeg" width="100%" height="100%">
            </div>
            <div class="span4">
              <div class="clearfix"></div>
              <aside class="right-sidebar">
                <br>
                <br>
                <form action="actions.php" class="needs-validation" method="POST">
                    <input type="hidden" name="action" value="login">
                  <div class="form-group">
                      <label class="form-label" for="email">Correu electrònic</label>
                      <input class="form-control" type="email" name="email" id="email_login" required>
                  </div>
                  <div class="form-group">
                      <label for="password">Contrasenya</label>
                      <input name="password" class="form-control" type="password" id="password_login" required>
                      <div class="invalid-feedback">Incorrecte.</div>
                  </div>
                  <input class="btn btn-primary w-100" type="submit" value="Identifica't">

                </form>
              </aside>
            </div>
          </div>
        </div>
      </section>
  </div>