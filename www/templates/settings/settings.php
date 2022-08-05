<?php require_once('cards/www/controllers/settings.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/header.php'); ?>

<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

<?php require_once('cards/www/templates/navControlPanel.php') ?>
    <body>
    <div class="row gutters-sm mb-4" style="margin-top: 6rem;">
    <?php if(isset($_GET["success"])){?>
      <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
        <div>
          Successfully configuration saved.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php } ?>
    <?php if(isset($_GET["error"])){?>
      <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
        <div>
          Error saving profile, check the fields.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php } ?>
    <?php require_once('settings-header.php'); ?>
        <div class="col-md-8">
          <div class="card">
            <div class="card-body tab-content">
              <div class="tab-pane active" id="profile">
                <h6>YOUR PROFILE INFORMATION</h6>
                <hr>
                <form action="" class="justify-content-md-center" method="post" enctype="multipart/form-data">
                  <div class="form-group mb-2">
                    <label for="fullName">Full Name (*)</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="fullNameHelp" placeholder="Enter your fullname" value="<?=$user_details["name"];?>">
                    <small id="fullNameHelp" class="form-text text-muted">Your name may appear around here where you are mentioned. You can change it at any time.</small>
                  </div>

                  <h6>Global Info</h6>
                  <hr>
                  <div class="form-group mb-2">
                    <label for="location">Username (*)</label>
                    <div class="input-group">
                      <span class="input-group-text" id="basic-addon1">@</span>
                      <input type="text" class="form-control" name="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" value="<?=$user_details["username"];?>">
                    </div>
                  </div>
                  <div class="form-group mb-2">
                    <label for="bio">Your Bio</label>
                    <textarea class="form-control autosize" name="biography" placeholder="Write something about you" maxlength="255" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 62px;"><?=$user_details["biography"];?></textarea>
                  </div>

                  <div class="form-group mb-3">
                    <label for="location">Website</label>
                    <input type="text" class="form-control" id="website" name="website" placeholder="Enter your website" value="<?=$user_details["website"];?>">
                  </div>

                  <div class="form-group mb-3">
                    <label for="location">Cardmarket</label>
                    <input type="text" class="form-control" id="cardmarket_link" name="cardmarket_link" placeholder="Enter your cardmarket link" value="<?=$user_details["cardmarket_link"];?>">
                  </div>

                  <div class="form-group mb-3">
                    <label for="location">Ubication</label><br>
                    <small class="text-muted">Format: Street, City, State.</small>
                    <input type="text" class="form-control" id="cardmarket_link" name="ubication" placeholder="Enter your ubication" value="<?=$user_details["ubication"];?>">
                  </div>

                  <h6>Social Networks</h6>
                  <hr>
                  <div class="form-group mb-3">
                    <label for="location">Twitter</label>
                    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Enter your twitter username" value="<?=$user_details["twitter"];?>">
                  </div>
                  <div class="form-group mb-3">
                    <label for="location">Instagram</label><br>
                    <small class="text-muted">Without the @</small>
                    <input type="text" class="form-control" id="instagram" name="instagram" placeholder="Enter your instagram username" value="<?=$user_details["instagram"];?>">
                  </div>
                  <div class="form-group mb-3">
                    <label for="location">Discord</label><br>
                    <small class="text-muted">Example: example#2323</small>
                    <input type="text" class="form-control" id="discord" name="discord" placeholder="Enter your discord username" value="<?=$user_details["discord"];?>">
                  </div>
                  
                  <h6>Images</h6>
                  <hr>
                  <div class="form-group mb-3">
                    <label for="location">Profile Image</label><br>
                    <small class="text-muted">Recommended Size: 500x500px</small>
                    <input type="file" class="form-control" id="profile_image" name="settings[profile_image]" value="<?=$user_details["profile_image"];?>">
                  </div>

                  <div class="form-group mb-3">
                    <label for="location">Cover Image</label><br>
                    <small class="text-muted">Recommended Size: 1280x920px</small>
                    <input type="file" class="form-control" id="profile_cover" name="settings[profile_cover]" value="<?=$user_details["profile_cover"];?>">
                  </div>


                  <div style="float:right;">
                    <button type="reset" class="btn btn-light">Reset Changes</button>
                    <button type="submit" class="btn btn-primary" name="commandUpdateProfile" value="1">Update Profile</button>
                  </div>
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
        $("#settingsProfile").addClass('active');
    });

</script>
<script src="/cards/assets/js/headerControler.js"></script>

</body>
</html>
