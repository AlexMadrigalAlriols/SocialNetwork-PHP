<?php require_once('cards/www/controllers/settings.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/header.php'); ?>

<body id="body-pd" class="body-pd overflow-x-hidden">

<?php require_once('cards/www/templates/navControlPanel.php') ?>
    <body>
    <div class="row gutters-sm mb-4 margin-top">
    <?php if(isset($_GET["success"])){?>
      <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
        <div>
          <?= $user->i18n("success_configuration"); ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php } ?>
    <?php if(isset($_GET["error"])){?>
      <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
        <div>
          <?= $user->i18n("error_configuration"); ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php } ?>
    <?php require_once('settings-header.php'); ?>
        <div class="col-md-8">
          <div class="card">
            <div class="card-body tab-content">
              <div class="tab-pane active" id="profile">
                <h6><?= strtoupper($user->i18n("profile_info")); ?></h6>
                <hr>
                <form action="" class="justify-content-md-center" method="post" enctype="multipart/form-data">
                  <h6><?= $user->i18n("global_info"); ?></h6>
                  <hr>
                  <div class="form-group mb-2">
                    <label for="fullName"><?= $user->i18n("full_name"); ?> (*)</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="fullNameHelp" placeholder="<?= $user->i18n("enter_your"); ?> <?= $user->i18n("full_name"); ?>" value="<?=$user_details["name"];?>">
                    <small id="fullNameHelp" class="form-text text-muted"><?= $user->i18n("fullname_help"); ?></small>
                  </div>
                  <div class="form-group mb-2">
                    <label for="location"><?= $user->i18n("username"); ?> (*)</label>
                    <div class="input-group">
                      <span class="input-group-text" id="username_addon">@</span>
                      <input type="text" class="form-control" name="username" placeholder="<?= $user->i18n("enter_your"); ?> <?= $user->i18n("username"); ?>" aria-label="Username" aria-describedby="username_addon" value="<?=$user_details["username"];?>">
                    </div>
                  </div>
                  <div class="form-group mb-2">
                    <label for="bio"><?= $user->i18n("biography"); ?></label>
                    <div class="input-group ms-4 view-deck-card mt-1">
                      <textarea class="form-control text-area-emoji" name="biography" data-emojiable="true" data-emoji-input="unicode" placeholder="Write something about you" maxlength="255"><?=$user_details["biography"];?></textarea>
                    </div>
                    
                  </div>

                  <div class="form-group mb-3">
                    <label for="location">Website</label>
                    <input type="text" class="form-control" id="website" name="website" placeholder="<?= $user->i18n("enter_your"); ?> website" value="<?=$user_details["website"];?>">
                  </div>

                  <div class="form-group mb-3">
                    <label for="location">Cardmarket</label>
                    <input type="text" class="form-control" id="cardmarket_link" name="cardmarket_link" placeholder="<?= $user->i18n("enter_your"); ?> cardmarket link" value="<?=$user_details["cardmarket_link"];?>">
                  </div>

                  <div class="form-group mb-3">
                    <label for="location"><?= $user->i18n("ubication"); ?></label><br>
                    <small class="text-muted"><?= $user->i18n("format"); ?>: <?= $user->i18n("ubication_format"); ?></small>
                    <input type="text" class="form-control" id="cardmarket_link" name="ubication" placeholder="<?= $user->i18n("enter_your"); ?> <?= $user->i18n("ubication"); ?>" value="<?=$user_details["ubication"];?>">
                  </div>

                  <h6><?= $user->i18n("social_networks"); ?></h6>
                  <hr>
                  <div class="form-group mb-3">
                    <label for="location">Twitter</label>
                    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="<?= $user->i18n("enter_your"); ?> twitter username" value="<?=$user_details["twitter"];?>">
                  </div>
                  <div class="form-group mb-3">
                    <label for="location">Instagram</label><br>
                    <small class="text-muted"><?= $user->i18n("instagram_help"); ?></small>
                    <input type="text" class="form-control" id="instagram" name="instagram" placeholder="<?= $user->i18n("enter_your"); ?> instagram username" value="<?=$user_details["instagram"];?>">
                  </div>
                  <div class="form-group mb-3">
                    <label for="location">Discord</label><br>
                    <small class="text-muted"><?= $user->i18n("format"); ?>: example#2323</small>
                    <input type="text" class="form-control" id="discord" name="discord" placeholder="<?= $user->i18n("enter_your"); ?> discord username" value="<?=$user_details["discord"];?>">
                  </div>
                  
                  <h6><?= $user->i18n("images"); ?></h6>
                  <hr>
                  <div class="form-group mb-3">
                    <label for="location"><?= $user->i18n("profile"); ?> <?= $user->i18n("image"); ?></label><br>
                    <small class="text-muted"><?= $user->i18n("recommended_size"); ?>: 500x500px</small>
                    <input type="file" class="form-control" id="profile_image" name="settings[profile_image]" value="<?=$user_details["profile_image"];?>">
                  </div>

                  <div class="form-group mb-3">
                    <label for="location"><?= $user->i18n("cover"); ?> <?= $user->i18n("image"); ?></label><br>
                    <small class="text-muted"><?= $user->i18n("recommended_size"); ?>: 1280x920px</small>
                    <input type="file" class="form-control" id="profile_cover" name="settings[profile_cover]" value="<?=$user_details["profile_cover"];?>">
                  </div>


                  <div class="pull-right">
                    <button type="submit" class="btn btn-primary" name="commandUpdateProfile" value="1"><?= $user->i18n("update"); ?> <?= $user->i18n("profile"); ?> <i class="fa-regular fa-floppy-disk ms-1"></i></button>
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

    $(function() {
            window.emojiPicker = new EmojiPicker({
                emojiable_selector: '[data-emojiable=true]',
                assetsPath: '/cards/assets/vendor/emojilib/img/',
                popupButtonClasses: 'fa fa-smile-o emoji-right'
            });
            window.emojiPicker.discover();
        });

</script>
<script src="/cards/assets/js/headerControler.js"></script>

</body>
</html>
