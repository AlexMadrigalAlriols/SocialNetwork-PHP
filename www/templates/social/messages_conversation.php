<?php require_once('cards/www/controllers/message_conver.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/social/header.php'); ?>
<body>
<?php require_once('cards/www/templates/social/home_navbar.php'); ?>

<div class="container mt-3">
    <div class="row">
        <div class="col-md-8">
            <div class="mt-3 p-4 bg-dark text-white rounded container">
                <div class="card-header">
                    <div class="d-inline-block">
                        <a href="/messages" class="text-white d-inline-block me-4"><i class="fa-solid fa-chevron-left"></i></a>                                 <div class="d-inline-block">
                        <img src="/<?=$user_chat["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                        <h6 class="d-inline-block ms-3"><?=$user_chat["name"];?></h6>
                        <p class="d-inline-block ms-1 text-muted" style="font-size: 12px;">@<?=$user_chat["username"];?></p>
                        </div>
                    </div>

                    <div class="pull-right d-inline-block">
                        <h5>
                            <a href="#" class="text-white"><i class="fa-solid fa-gear"></i></a>
                        </h5>
                    </div>
                </div>     
                <div class="card-body">
                    <div class="messages-container" style="min-height: 40vh;">
                        <div class="row mt-3">
                            <span style="margin-left: 65px;" class="text-muted mb-1"><?=$user_chat["name"];?></span>
                            <div class="d-inline-block" style="width: auto;">
                                <img src="/<?=$user_chat["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                            </div>
                            <div class="message-box d-inline-block w-100">
                                <p>lorem20</p>
                                <p class="text-muted pull-right">14.09.2022 08:35</p>
                            </div>
                        </div>

                        <div class="row mt-3 pull-right">
                            <div class="d-inline-block" style="width: auto;">
                                <img src="/<?=$user_chat["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                            </div>
                            <div class="message-box d-inline-block w-100">
                                <p>lorem20</p>
                                <p class="text-muted pull-right">14.09.2022 08:35</p>
                            </div>
                        </div>

                    </div>
                    <form action="" method="POST">
                        <div class="input-group">
                            <button class="input-group-text" type="button"><i class="fa-solid fa-paperclip"></i></button>
                            <input type="text" class="form-control" placeholder="Message to <?=$user_chat["name"];?>...">
                            <button class="input-group-text btn-dark-primary active" type="submit">Send</button>
                        </div>
                    </form>
                    
                </div>    
            </div>
        </div>
        <div class="col-md-4">
            <div class="mt-4 bg-dark text-white rounded container">
                <div class="p-3">
                    <img src="/<?=$user_details["profile_image"];?>" class="rounded-circle d-inline-block" width="50px" height="50px">
                    <div class="d-inline-block p-1">
                            <h6 style="font-size: 14px;"><b><?=$user_details["name"];?></b></h6>
                            <p class="text-muted ms-1" style="font-size: 12px;">@<?=$user_details["username"];?></p>
                    </div>
                    <div class="text-center">
                        <a class="btn btn-dark active w-100 mt-3" href="/profile/<?=$user->get("id_user");?>">Ver perfil</a>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <form method="post" id="frm">
                            <p style="font-size:13px;"><b>New Accounts</b></p>
                            <?php foreach ($suggested_users as $idx => $user_sugg) { ?>
                                <?php if(!in_array($user_sugg["user_id"], json_decode($user_details["followed"],true)) && $user_sugg["user_id"] != $user->get("id_user") && !userService::isUserBlocked($user->get("id_user"), $user_sugg["user_id"]) && !userService::isUserBlocked($user_sugg["user_id"], $user->get("id_user"))) {?>
                                    
                                    <div class="mt-1 p-2">
                                        <a href="/profile/<?=$user_sugg["user_id"];?>">
                                            <img src="/<?=$user_sugg["profile_image"]?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                                            <span class="d-inline-block ms-2" style="font-size: 13px; color:white;"><b>@<?=$user_sugg["username"]?></b></span>
                                        </a>
                                        <button class="mt-2 btn btn-dark" style="font-size: 12px; float:right; background-color: #141414;" name="commandFollowSuggested" type="submit" value="<?=$user_sugg["user_id"];?>"><b>Follow</b></button>
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

    }); 
</script>
</body>
</html>
