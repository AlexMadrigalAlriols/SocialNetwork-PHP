<?php require_once('cards/www/controllers/settings-blocked.php'); ?>
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
              <div class="tab-pane active" id="notification">
                <h6><?= strtoupper($user->i18n("blocked_users")); ?></h6>
                <hr>
                <form method="post" id="frm">
                  <?php if (count($users_blocked) <= 0) {?>
                    <h5><?= $user->i18n("no_blocked_users"); ?></h5>
                  <?php } ?>
                  <?php foreach ($users_blocked as $idx => $user_blocked) { ?>
                    <?php if(isset($user_blocked["name"])) { ?>
                    <a class="card" href="/profile/<?=$user_blocked["user_id"]; ?>">
                      <div class="card-body text-white">
                        <div class="d-inline-block">
                          <img src="/<?=$user_blocked["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                          <h6 class="d-inline-block ms-3"><?=$user_blocked["name"];?></h6>
                          <p class="d-inline-block ms-1 text-muted f-12">@<?=$user_blocked["username"];?></p>
                        </div>
                        <div class="pull-right">
                          <button class="btn btn-dark active d-inline-block text-white" type="submit" name="command_block" value="<?=$user_blocked["user_id"];?>"><?= $user->i18n("unblock_user"); ?> <i class="fa-solid fa-ban ms-2"></i></button>
                        </div>
                      </div>
                    </a>
                    <?php } ?>
                  <?php } ?>
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
            $("#settings").addClass('active');
            $("#settingsBlocked").addClass('active');
            $("#settings-blockusers-movile").addClass('active');
        });
    </script>
    <script src="/cards/assets/js/headerControler.js"></script>

</html>
