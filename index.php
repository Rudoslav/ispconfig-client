<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registrácia do on-line platformy Centra ADR</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <style type="text/css">
        span.required{
            color: crimson;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h4 style="margin-left: 5%">
                    Registrácia do on-line platformy Centra ADR
                </h4>
                <?php if( empty($_SESSION['status']) ) { ?>
                    <?php if( $_SESSION['errors'] ) { ?>
                        <?php foreach ( $_SESSION['errors'] as $error) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error ?>
                            </div>
                        <?php }
                            unset( $_SESSION['errors'] );
                        ?>
                    <?php } ?>
                  <form method="POST" action="process.php">
                      <div class="form-group">
                          <label for="name">Meno<span class="required"> *</span></label>
                          <input type="text" class="form-control" name="name" id="name"
                                 value="<?php if( $_SESSION['old']['name'] ) {
                                     echo $_SESSION['old']['name'];
                                     unset( $_SESSION['old']['name'] );
                                 } ?>" required>
                      </div>
                      <div class="form-group">
                          <label for="surname">Priezvisko<span class="required"> *</span></label>
                          <input type="text" class="form-control" name="surname" id="surname" value="<?php if( $_SESSION['old']['surname'] ) {
                              echo $_SESSION['old']['surname'];
                              unset( $_SESSION['old']['surname'] );
                          } ?>" required>
                      </div>
                      <div class="form-group">
                          <label for="company_name">Obchodné meno</label>
                          <input type="text" class="form-control" name="company_name" id="company_name" value="<?php if( $_SESSION['old']['company_name'] ) {
                              echo $_SESSION['old']['company_name'];
                              unset( $_SESSION['old']['company_name'] );
                          } ?>">
                      </div>
                      <div class="form-group">
                          <label for="date_ico">Dátum narodenia/IČO<span class="required"> *</span></label>
                          <input type="text" class="form-control" name="date_ico" id="date_ico" value="<?php if( $_SESSION['old']['date_ico'] ) {
                              echo $_SESSION['old']['date_ico'];
                              unset( $_SESSION['old']['date_ico'] );
                          } ?>" required>
                      </div>
                      <div class="form-group">
                          <label for="street">Ulica<span class="required"> *</span></label>
                          <input type="text" class="form-control" name="street" id="street" value="<?php if( $_SESSION['old']['street'] ) {
                              echo $_SESSION['old']['street'];
                              unset( $_SESSION['old']['street'] );
                          } ?>" required>
                      </div>
                      <div class="form-group">
                          <label for="number">Číslo<span class="required"> *</span></label>
                          <input type="text" min="1" class="form-control" name="number" id="number" value="<?php if( $_SESSION['old']['number'] ) {
                              echo $_SESSION['old']['number'];
                              unset( $_SESSION['old']['number'] );
                          } ?>">
                      </div>
                      <div class="form-group">
                          <label for="town">Obec<span class="required"> *</span></label>
                          <input type="text" class="form-control" name="town" id="town" value="<?php if( $_SESSION['old']['town'] ) {
                              echo $_SESSION['old']['town'];
                              unset( $_SESSION['old']['town'] );
                          } ?>" required>
                      </div>
                      <div class="form-group">
                          <label for="psc">PSČ<span class="required"> *</span></label>
                          <input type="number" min="1" class="form-control" name="psc" id="psc" value="<?php if( $_SESSION['old']['psc'] ) {
                              echo $_SESSION['old']['psc'];
                              unset( $_SESSION['old']['psc'] );
                          } ?>" required>
                      </div>
                      <div class="form-group">
                          <label for="state">Štát<span class="required"> *</span></label>
                          <input type="text" class="form-control" name="state" id="state" value="<?php if( $_SESSION['old']['state'] ) {
                              echo $_SESSION['old']['state'];
                              unset( $_SESSION['old']['state'] );
                          } ?>" required>
                      </div>
                      <div class="form-group">
                          <label for="email">Email<span class="required"> *</span></label>
                          <input type="email" class="form-control" name="email" id="email" value="<?php if( $_SESSION['old']['email'] ) {
                              echo $_SESSION['old']['email'];
                              unset( $_SESSION['old']['email'] );
                          } ?>" required>
                      </div>
                      <div class="form-group">
                          <label for="telephone">Tel. č.</label>
                          <input type="tel" class="form-control" name="telephone" id="telephone" value="<?php if( $_SESSION['old']['telephone'] ) {
                              echo $_SESSION['old']['telephone'];
                              unset( $_SESSION['old']['telephone'] );
                          } ?>">
                      </div>
                      <div class="form-group">
                          <label for="username">Prihlasovacie meno<span class="required"> *</span></label>
                          <input type="text" class="form-control" name="username" id="username" value="<?php if( $_SESSION['old']['username'] ) {
                              echo $_SESSION['old']['username'];
                              unset( $_SESSION['old']['username'] );
                          } ?>" required>
                      </div>
                      <div class="form-group">
                          <label for="password">Heslo<span class="required"> *</span></label>
                          <input type="password" class="form-control" name="password" id="password" value="<?php if( $_SESSION['old']['password'] ) {
                              echo $_SESSION['old']['password'];
                              unset( $_SESSION['old']['password'] );
                          } ?>" required>
                      </div>
                      <div class="form-check">
                          <label class="form-check-label">
                              <input type="checkbox" name="agreement" class="form-check-input" value="<?php if( $_SESSION['old']['agreement'] ) {
                                  echo $_SESSION['old']['agreement'];
                                  unset( $_SESSION['old']['agreement'] );
                              } ?>">
                              Súhlasím so spracovaním osobných údajov<span class="required"> *</span>
                          </label>
                      </div>
                      <button type="submit" class="btn btn-primary">Odoslať</button>
                  </form>
                <?php } ?>
                <?php if( !empty( $_SESSION['status'] ) ) { ?>
                    <div style="vertical-align: middle">
                    <?php if( $_SESSION['status'] == false ) { ?>
                        <div class="alert alert-danger" role="alert">
                            <h5>Nastala vnútorná chyba servera. Ak problém pretrváva, kontaktujte prosím správcu servera.</h5>
                        </div>
                    <?php } ?>
                    <?php if( $_SESSION['status'] == true ) { ?>
                        <div class="alert alert-success" role="alert">
                            <h5>Registrácia prebehla úspešne. Teraz sa môžete prostredníctvom prideleného prihlasovacieho mena a zadaného hesla prihlásiť do on-line platformy.</h5>
                        </div>
                    <?php }
                    unset( $_SESSION['status'] );
                    ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>