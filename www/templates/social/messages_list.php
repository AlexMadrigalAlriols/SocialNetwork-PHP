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
                                    <img src="/<?=$message["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px">
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
            <div class="mt-4 bg-dark text-white rounded container suggested-users-container">
                <div class="p-3">
                    <img src="/<?=$user_details["profile_image"];?>" class="rounded-circle d-inline-block" width="50px" height="50px">
                    <div class="d-inline-block p-1">
                            <h6 class="f-14"><b><?=$user_details["name"];?></b></h6>
                            <p class="text-muted ms-1 f-12">@<?=$user_details["username"];?></p>
                    </div>
                    <div class="text-center">
                        <a class="btn btn-dark active w-100 mt-3" href="/profile/<?=$user->get("id_user");?>"><?=$user->i18n("view_profile");?></a>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <form method="post" id="frm">
                            <p class="f-13"><b><?=$user->i18n("new_accounts");?></b></p>
                            <?php foreach ($suggested_users as $idx => $user_sugg) { ?>
                                <?php if(!in_array($user_sugg["user_id"], json_decode($user_details["followed"],true)) && $user_sugg["user_id"] != $user->get("id_user") && !userService::isUserBlocked($user->get("id_user"), $user_sugg["user_id"]) && !userService::isUserBlocked($user_sugg["user_id"], $user->get("id_user"))) {?>
                                    
                                    <div class="mt-1 p-2">
                                        <a href="/profile/@<?=$user_sugg["username"];?>" class="text-decoration-none">
                                            <img src="/<?=$user_sugg["profile_image"]?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                                            <span class="d-inline-block ms-2 text-white f-13"><b>@<?=$user_sugg["username"]?></b></span>
                                        </a>
                                        <button class="mt-2 btn btn-dark btn-follow-suggest" name="commandFollowSuggested" type="submit" value="<?=$user_sugg["user_id"];?>"><b><?=$user->i18n("follow");?></b></button>
                                    </div>
                                <?php } ?> 
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
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
</html>
