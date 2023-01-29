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
                  <h4 for="url"><?= $user->i18n("change_password");?></h4>
                    <label for="url"><?= $user->i18n("new");?> <?= $user->i18n("password");?></label>
                    <input type="password" class="form-control" name="newpassword" placeholder="<?= $user->i18n("new");?> <?= $user->i18n("password");?>">
                    <div id="validationNewPassword" class="invalid-feedback"></div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="url"><?= $user->i18n("confirm");?> <?= $user->i18n("password");?></label>
                    <input type="password" class="form-control" name="cpassword" placeholder="<?= $user->i18n("confirm");?> <?= $user->i18n("new");?> <?= $user->i18n("password");?>">
                  </div>
                  <hr>
                  <?php if($user_details["password"] != null) { ?>
                    <div class="form-group mb-3">
                      <label for="url"><?= $user->i18n("current");?> <?= $user->i18n("password");?></label>
                      <input type="password" class="form-control" name="password" placeholder="<?= $user->i18n("current");?> <?= $user->i18n("password");?>" required>
                      <div id="validationPassword" class="invalid-feedback"></div>
                    </div>
                  <?php } ?>

                  <button type="submit" class="btn btn-primary pull-right mb-2 addon-btn-filters" name="commandUpdateUser" value="1"><?= $user->i18n("update");?> <?= $user->i18n("account");?> <i class="fa-regular fa-floppy-disk ms-1"></i></button>
                  <button type="button" id="deleteUserButton" class="btn btn-danger mb-2 addon-btn-filters"><?= $user->i18n("delete");?> <?= $user->i18n("account");?> <i class="fa-solid fa-trash-can ms-1"></i></button>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
    </body>
<script>

    $( document ).ready(function() {
        $("#settings").addClass('active');
        $("#settingsAccount").addClass('active');
        $("#settings-account-movile").addClass('active');
    });
    
    $("#deleteUserButton").click(function() {
      if(confirm('Are you sure you want delete your account?')) {
        $("#frm").append('<button type="submit" id="deleteUser" class="d-none" name="commandDeleteUser" value="1"></button>');
        $("#deleteUser").click();
      }
    });

    function validateForm(){
      username = $("#username").val();

      if(username.length < 4) {
        $("#username").addClass("is-invalid");
        $("#validationUsername").append("<span>Username Length must be greater than 4.</span>")
        return false;
      }

      if(username.indexOf(";") != -1 || username.indexOf("'") != -1 || username.indexOf('"') != -1 || username.indexOf(',') != -1 || username.indexOf('`') != -1 || username.indexOf('´') != -1){
        $("#username").addClass("is-invalid");
        $("#validationUsername").append("<span>Username characters not valid.</span>")
        return false;
      }

      email = $("#email").val().toLowerCase();

      if(!email.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
        $("#email").addClass("is-invalid");
        return false;
      }

      if(email.indexOf(";") != -1 || email.indexOf("'") != -1 || email.indexOf('"') != -1 || email.indexOf(',') != -1 || email.indexOf('`') != -1 || email.indexOf('´') != -1){
        $("#username").addClass("is-invalid");
        $("#validationUsername").append("<span>Username characters not valid.</span>")
        return false;
      }

      newpassword = $("#newpassword").val();
      if(newpassword.length > 0){
        
        if(newpassword.trim().length > 8){
          cpassword = $("#cpassword").val();
          if(newpassword != cpassword){
            $("#newpassword").addClass("is-invalid");
            $("#validationNewPassword").empty();
            $("#validationNewPassword").append("<span>Confirm Password is different than New Password.</span>");
            return false;
          }
        } else {
          $("#newpassword").addClass("is-invalid");
          $("#validationNewPassword").empty();
          $("#validationNewPassword").append("<span>Password Length must be greater than 8.</span>");
          return false;
        }

        $("#newpassword").addClass("is-valid");
      }

      password = $("#password").val();
      if(password.length == 0){
          $("#password").addClass("is-invalid");
          $("#validationPassword").empty();
          $("#validationPassword").append("<span>Password Required.</span>");
          return false;
      }

      $("#email").addClass("is-valid");
      $("#username").addClass("is-valid");
      return true;
    }

</script>
<script src="/cards/assets/js/headerControler.js"></script>

</body>
</html>
