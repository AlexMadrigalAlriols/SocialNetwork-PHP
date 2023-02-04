<?php require_once('cards/www/controllers/notifications.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/social/header.php'); ?>
<body>
<?php require_once('cards/www/templates/social/home_navbar.php'); ?>

<div class="container mt-3 mb-4">
<?php require_once('cards/www/templates/_toast.php') ?>

    <div class="row">
        <div class="col-md-8">
            <div class="mt-3 p-4 bg-dark text-white rounded container-fluid">
                <div class="card-header">
                    <h4 class="d-inline-block"><i class="fa-regular fa-bell me-2"></i> <?=$user->i18n("notifications");?></h4>
                </div>

                <?php foreach ($notifications as $idx => $noti) { ?>
                    <a class="text-decoration-none text-white card message-card bg-dark <?=($noti["already_read"] ? '' : 'no-read')?> mb-2" href="<?= $noti["notification_url"]; ?>">
                        <div class="mt-1 p-2 ms-3">
                            <img src="<?=$noti["profile_image"];?>" class="rounded-circle d-inline-block me-3" width="50px" height="50px" referrerpolicy="no-referrer">
                            <div class="d-inline-block">
                                <span class="ms-1 d-inline-block"><b>@<?=$noti["username"]?></b></span>
                                <span><?=$user->i18n($noti["notification_type"]);?></span>
                            </div>
                            <div class="d-inline-block pull-right me-1">
                                <span class="text-muted f-12"><?=fwTime::getPassedTime($noti["notification_date"]);?></span>
                            </div>
                            
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php require_once('_suggested_users.php') ?>
        </div>
    </div>
</div>

<script src="/cards/assets/js/globalController.js"></script>
<script>
    $( document ).ready(function() {
        $("#Notifications").addClass('active');

        <?php if(isset($_GET["error"])) { ?>
            $('#errorOnAccess').toast('show');
        <?php } ?>
    }); 
</script>
</body>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>
