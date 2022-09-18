<?php require_once('cards/www/controllers/message_conver.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/social/header.php'); ?>
<body>
<?php require_once('cards/www/templates/social/home_navbar.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="mt-3 p-4 bg-dark text-white rounded container">
                <div class="card-header">
                    <div class="d-inline-block">
                        <a href="/messages" class="text-white d-inline-block me-4"><i class="fa-solid fa-chevron-left"></i></a>                                 <div class="d-inline-block">
                        <a href="/profile/@<?=$user_chat["username"];?>" class="text-decoration-none text-white">
                            <img src="/<?=$user_chat["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                            <h6 class="d-inline-block ms-2"><?=$user_chat["name"];?></h6>
                            <p class="d-inline-block ms-1 text-muted" style="font-size: 12px;">@<?=$user_chat["username"];?></p>
                        </a>
                        </div>
                    </div>

                    <div class="pull-right d-inline-block">
                        <div class="dropdown">
                            <h5 data-bs-toggle="dropdown" aria-expanded="false"><a href="#" role="button" class="text-white"><i class="fa-solid fa-gear"></i></a></h5>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item mt-1" role="button"><i class="fa-solid fa-link"></i> Denunciar Conversacion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>     
                <div class="card-body">
                    <div class="messages-container" id="messages-container" style="min-height: 40vh; max-height: 50vh; overflow-y: auto; overflow-x: hidden;">

                    <?php foreach ($chat_messages as $idx => $message) { ?>
                        <?php if($message["id_user"] != $user->get("id_user")) { ?>
                            <div class="container w-100">
                                <div class="row mt-2">
                                    <span style="margin-left: 65px;" class="text-muted mb-1"><?=$user_chat["name"];?></span>
                                    <div class="d-inline-block w-auto">
                                        <img src="/<?=$user_chat["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                                    </div>
                                    <div class="message-box d-inline-block w-100">
                                        <p><?=$message["message_text"];?></p>
                                        <?php if(isset($message["message_img"])) { ?>
                                            <a href="<?=$message["message_img"];?>" data-lightbox="conver-image" data-title="<?=$message["message_text"];?>">
                                                <img src="/cards/uploads/<?=$message["message_img"];?>" alt="" width="100%" class="mb-4" style="max-height: 300px;">
                                            </a>
                                        <?php } ?>
                                        <p class="text-muted pull-right">Hace <?=fwTime::getPassedTime($message["date_sent"], true);?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="container w-100 d-flex justify-content-end">
                                <div class="row mt-2">
                                    <div class="message-box-right">
                                        <p><?=$message["message_text"];?></p>
                                        <?php if(isset($message["message_img"])) { ?>
                                            <a href="<?=$message["message_img"];?>" data-lightbox="conver-image" data-title="<?=$message["message_text"];?>">
                                                <img src="/cards/uploads/<?=$message["message_img"];?>" alt="" width="100%" class="mb-4" style="max-height: 300px;">
                                            </a>
                                        <?php } ?>
                                        <p class="text-muted pull-right">Hace <?=fwTime::getPassedTime($message["date_sent"], true);?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="input-group mt-5" id="message_box">
                            <button class="input-group-text btn-input-group" type="button" name="buttonImages" id="buttonImages" type="button"><i class="fa-solid fa-paperclip"></i></button>
                            <input type="text" data-emojiable="true" data-emoji-input="unicode" class="form-control" placeholder="Message to <?=$user_chat["name"];?>..." name="message_text">
                            <input type="file" class="d-none" name="message[message_img]" id="message_img" value="none" onchange="loadFile(event)">
                            <button class="input-group-text btn-dark-primary active" type="submit" name="command_send" value="1">Send</button>
                        </div>
                    </form>
                    <div id="imgContainer" class="d-none">
                        <button type="button" onclick="removeFile()" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent; color:white; border-style: none; position:relative;"><i class="fa-solid fa-xmark"></i></button>
                        <img id="output" src="" class="mt-3" style="width:10%; height:10%; border-radius: 15%;">
                    </div>
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
                            <p class="f-13"><b>New Accounts</b></p>
                            <?php foreach ($suggested_users as $idx => $user_sugg) { ?>
                                <?php if(!in_array($user_sugg["user_id"], json_decode($user_details["followed"],true)) && $user_sugg["user_id"] != $user->get("id_user") && !userService::isUserBlocked($user->get("id_user"), $user_sugg["user_id"]) && !userService::isUserBlocked($user_sugg["user_id"], $user->get("id_user"))) {?>
                                    
                                    <div class="mt-1 p-2">
                                        <a href="/profile/@<?=$user_sugg["username"];?>" class="text-decoration-none">
                                            <img src="/<?=$user_sugg["profile_image"]?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                                            <span class="d-inline-block ms-2 text-white f-13"><b>@<?=$user_sugg["username"]?></b></span>
                                        </a>
                                        <button class="mt-2 btn btn-dark btn-follow-suggest" name="commandFollowSuggested" type="submit" value="<?=$user_sugg["user_id"];?>"><b>Follow</b></button>
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

<script>
    $( document ).ready(function() {
        $("#Messages").addClass('active');
        $('#buttonImages').click(function(){ $('#message_img').trigger('click'); });
    }); 
    var element = document.getElementById("messages-container");
    element.scrollTop = element.scrollHeight;

    var loadFile = function(event) {
        var output = document.getElementById('output');
        $("#imgContainer").removeClass("d-none");
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };

    $(function() {
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '/cards/assets/vendor/emojilib/img/',
            popupButtonClasses: 'fa fa-smile-o emoji-left'
        });
        window.emojiPicker.discover();
    });
    
    function removeFile(){
        $("#imgContainer").addClass("d-none");
        const file = document.querySelector('#message_img');
        file.value = '';
    }
</script>
<script src="/cards/assets/js/globalController.js"></script>
<script src="/cards/assets/vendor/lightbox/js/lightbox.js"></script>
</body>
</html>
