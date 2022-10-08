<?php require_once('cards/www/controllers/settings.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/header.php'); ?>

<body id="body-pd" class="body-pd overflow-x-hidden">

<?php require_once('cards/www/templates/navControlPanel.php') ?>
    <body>
    <div class="row gutters-sm settings-header">
    <?php require_once('settings-header.php'); ?>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header border-bottom mb-3 d-inline-block d-md-none">
              <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                <li class="nav-item">
                  <a href="#profile" data-toggle="tab" class="nav-link has-icon active"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></a>
                </li>
                <li class="nav-item">
                  <a href="#account" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></a>
                </li>
                <li class="nav-item">
                  <a href="#security" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg></a>
                </li>
                <li class="nav-item">
                  <a href="#notification" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></a>
                </li>
                <li class="nav-item">
                  <a href="#billing" data-toggle="tab" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg></a>
                </li>
              </ul>
            </div>
            <div class="card-body tab-content">
              <div class="tab-pane active" id="profile">
                <h6>YOUR ACCOUNT SETTINGS</h6>
                <hr>
                <form id="frm" method="POST">
                  <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?=$user_details["email"];?>">
                    <div id="validationEmail" class="invalid-feedback">
                      Email isn't valid.
                    </div>
                  </div>
                  <div class="form-group mb-3">
                  <h4 for="url">Change Password</h4>
                    <label for="url">New Password</label>
                    <input type="password" class="form-control" name="newpassword" placeholder="New Password">
                    <div id="validationNewPassword" class="invalid-feedback"></div>
                  </div>
                  <div class="form-group mb-3">
                    <label for="url">Confirm Password</label>
                    <input type="password" class="form-control" name="cpassword" placeholder="Confirm New Password">
                  </div>
                  <hr>
                  <div class="form-group mb-3">
                    <label for="url">Current Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Current Password" required>
                    <div id="validationPassword" class="invalid-feedback"></div>
                  </div>

                  <button type="submit" class="btn btn-primary pull-right" name="commandUpdateUser" value="1">Update Account <i class="fa-regular fa-floppy-disk ms-1"></i></button>
                  <button type="button" id="delteUserButton" class="btn btn-danger">Delete Account <i class="fa-solid fa-trash-can ms-1"></i></button>
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
            <button type="button" class="btn btn-primary d-none" id="updateUser">Update Account </button>
          </div>
        </div>
      </div>
    </div>

<script>

    $( document ).ready(function() {
        $("#settings").addClass('active');
        $("#settingsAccount").addClass('active');
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
