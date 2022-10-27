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
                  <div class="form-group mb-3">
                    <label for="url"><?= $user->i18n("current");?> <?= $user->i18n("password");?></label>
                    <input type="password" class="form-control" name="password" placeholder="<?= $user->i18n("current");?> <?= $user->i18n("password");?>" required>
                    <div id="validationPassword" class="invalid-feedback"></div>
                  </div>

                  <button type="submit" class="btn btn-primary pull-right mb-2 addon-btn-filters" name="commandUpdateUser" value="1"><?= $user->i18n("update");?> <?= $user->i18n("account");?> <i class="fa-regular fa-floppy-disk ms-1"></i></button>
                  <button type="button" id="delteUserButton" class="btn btn-danger mb-2 addon-btn-filters"><?= $user->i18n("delete");?> <?= $user->i18n("account");?> <i class="fa-solid fa-trash-can ms-1"></i></button>
                </form>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
    </body>

    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalAddLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="card-name-add">Confirmation Code</span>
          </div>
          <div class="modal-body">
            <h6 class="text-dark">Put the confirmation code we send it to your Email:</h6>
            <form>
                <input type="text" name="codeEmail" class="form-control" id="codeEmail" required>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="deleteUser">Delete Account</button>
            <button type="button" class="btn btn-primary d-none mb-2" id="updateUser">Update Account </button>
          </div>
        </div>
      </div>
    </div>

<script>

    $( document ).ready(function() {
        $("#settings").addClass('active');
        $("#settingsAccount").addClass('active');
        $("#settings-account-movile").addClass('active');
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
