<?php require_once('cards/www/controllers/settings.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/header.php'); ?>

<body id="body-pd" class="body-pd overflow-x-hidden">

<?php require_once('cards/www/templates/navControlPanel.php') ?>
    <body>
    <div class="row gutters-sm settings-header margin-top">
    <?php require_once('settings-header.php'); ?>
        <div class="col-md-8">
          <div class="card">
            <?php require_once('settings-header-movile.php'); ?>
            <div class="card-body tab-content">
              <div class="tab-pane active" id="profile">
                <h6><?= strtoupper($user->i18n("account_settings")); ?></h6>
                <hr>
                <form id="frm" method="POST">
                  <div class="form-group mb-3">
                    <label for="email"><?= $user->i18n("email");?></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?=$user_details["email"];?>">
                    <div id="validationEmail" class="invalid-feedback">
                      <?= $user->i18n("email_error");?>
                    </div>
                  </div>
                  <div class="form-group mb-3">
                  <h4><?= $user->i18n("change_password");?></h4>
                    <label for="newpassword"><?= $user->i18n("new");?> <?= $user->i18n("password");?></label>
                    <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="<?= $user->i18n("new");?> <?= $user->i18n("password");?>">
                    <div id="validationNewPassword" class="invalid-feedback"><?= $user->i18n("password.validation.msg");?></div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="cpassword"><?= $user->i18n("confirm");?> <?= $user->i18n("password");?></label>
                    <input type="password" class="form-control" name="cpassword" placeholder="<?= $user->i18n("confirm");?> <?= $user->i18n("new");?> <?= $user->i18n("password");?>">
                  </div>
                  <hr>
                  <?php if($user_details["password"] != null) { ?>
                    <div class="form-group mb-3">
                      <label for="password"><?= $user->i18n("current");?> <?= $user->i18n("password");?></label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="<?= $user->i18n("current");?> <?= $user->i18n("password");?>" required>
                      <div id="validationPassword" class="invalid-feedback">Invalid Password</div>
                    </div>
                  <?php } ?>

                  <button type="submit" class="btn btn-primary pull-right mb-2 addon-btn-filters" name="commandUpdateUser" id="commandUpdateUser" value="1" disabled><?= $user->i18n("update");?> <?= $user->i18n("account");?> <i class="fa-regular fa-floppy-disk ms-1"></i></button>
                  <button type="button" id="deleteUserButton" class="btn btn-danger mb-2 addon-btn-filters"><?= $user->i18n("delete");?> <?= $user->i18n("account");?> <i class="fa-solid fa-trash-can ms-1"></i></button>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
    </body>
    <?php require_once('cards/www/templates/_footer.php'); ?>
  <script>
    $( document ).ready(function() {
        error = 0;
        $("#settings").addClass('active');
        $("#settingsAccount").addClass('active');
        $("#settings-account-movile").addClass('active');
        <?php if(isset($_GET["error"])) { ?>
          $("#<?=$_GET["error"];?>").addClass("is-invalid");
        <?php } ?>

        $("#password").keyup(function() {
            password = $(this).val();

            if(password.length < <?=gc::getSetting("validators.password_length");?>) {
                $("#commandUpdateUser").attr("disabled", true);
            } else {
                $("#commandUpdateUser").attr("disabled", false);
            }
        });
        
    });
    
    $("#deleteUserButton").click(function() {
      if(confirm('Are you sure you want delete your account?')) {
        $("#frm").append('<button type="submit" id="deleteUser" class="d-none" name="commandDeleteUser" value="1"></button>');
        $("#deleteUser").click();
      }
    });
</script>
<script src="/cards/assets/js/headerControler.js"></script>

</body>
</html>
