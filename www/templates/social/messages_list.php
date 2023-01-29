<?php require_once('cards/www/controllers/messages.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/social/header.php'); ?>
<body>
<?php require_once('cards/www/templates/social/home_navbar.php'); ?>

<div class="container mt-3 mb-4">
<?php require_once('cards/www/templates/_toast.php') ?>

    <div class="row">
        <div class="col-md-8">
            <div class="mt-3 p-4 bg-dark text-white rounded container">
                <div class="card-header">
                    <h4 class="d-inline-block"><?=$user->i18n("messages");?></h4>
                </div>

                <?php foreach ($messages_list as $idx => $message) { ?>
                    <a href="/messages/@<?=$message["username"];?>">
                        <div class="card bg-dark text-white mt-3 message-card <?php if(!$message["message_readed"]) { ?> no-read <?php } ?>">
                            <div class="card-body text-white">
                                <div class="d-inline-block">
                                    <img src="<?=$message["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px" referrerpolicy="no-referrer">
                                    <h6 class="d-inline-block ms-3"><?=$message["name"];?></h6>
                                    <p class="d-inline-block ms-1 text-muted f-12">@<?=$message["username"];?></p>
                                    <p class="ms-5 text-muted"><?=$message["message_text"];?></p>
                                </div>
                                <div class="pull-right">
                                    <span class="text-muted"><?=$user->i18n("last_message");?> <?=fwTime::getPassedTime($message["date_sent"]);?> ago</span>
                                    <?php if(!$message["message_readed"]) { ?>
                                        <br><p class="pull-right mx-3 message-read-point mt-3"><i class="fa-solid fa-circle"></i></p>
                                    <?php } ?>
                                </div>
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
        $("#Messages").addClass('active');

        <?php if(isset($_GET["error"])) { ?>
            $('#errorOnAccess').toast('show');
        <?php } ?>
    }); 
</script>
</body>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>
