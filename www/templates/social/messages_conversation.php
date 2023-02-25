<?php require_once('cards/www/controllers/message_conver.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/social/header.php'); ?>
<body>
<?php require_once('cards/www/templates/social/home_navbar.php'); ?>

<div class="container mb-4">
    <div class="row">
        <div class="col-md-8">
            <div class="mt-3 p-4 bg-dark text-white rounded container">
                <div class="card-header">
                    <div class="d-inline-block">
                        <a href="/messages" class="text-white d-inline-block me-4"><i class="fa-solid fa-chevron-left"></i></a>                                 
                        <div class="d-inline-block">
                            <a href="/profile/@<?=$user_chat["username"];?>" class="text-decoration-none text-white">
                                <img src="<?=$user_chat["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px" referrerpolicy="no-referrer">
                                <h6 class="d-inline-block ms-2"><?=$user_chat["name"];?></h6>
                                <p class="d-inline-block ms-1 text-muted f-12">@<?=$user_chat["username"];?></p>
                            </a>
                        </div>
                    </div>

                    <div class="pull-right d-inline-block">
                        <div class="dropdown">
                            <h5 data-bs-toggle="dropdown" aria-expanded="false"><a href="#" role="button" class="text-white"><i class="fa-solid fa-gear"></i></a></h5>
                            <ul class="dropdown-menu">
                                <form action="" method="post">
                                    <li><button class="dropdown-item mt-1 text-red" role="button" name="commandReport" value="1" type="submit"><i class="fa-regular fa-flag"></i> <?=$user->i18n("report_conver");?></button></li>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>     
                <div class="card-body">
                    <div class="messages-container" id="messages-container">

                    <?php foreach ($chat_messages as $idx => $message) { ?>
                        <?php if($message["id_user"] != $user->get("id_user")) { ?>
                            <div class="container w-100">
                                <div class="row mt-2">
                                    <span class="text-muted mb-1 ms-3 message-user"><?=$user_chat["name"];?></span>
                                    <div class="d-inline-block w-auto message-user">
                                        <img src="<?=$user_chat["profile_image"];?>" class="rounded-circle message-user" width="40px" height="40px" referrerpolicy="no-referrer">
                                    </div>
                                    <div class="message-box d-inline-block w-100">
                                        <p><?=(isset($message["message_text"]) ? $message["message_text"] : "");?></p>
                                        <?php if(isset($message["message_img"])) { ?>
                                            <a href="/cards/uploads/<?=$message["message_img"];?>" data-lightbox="conver-image" data-title="<?=$message["message_text"];?>">
                                                <img src="/cards/uploads/<?=$message["message_img"];?>" alt="" width="100%" class="mb-4 conver_image img-fluid mg-thumbnail">
                                            </a>
                                        <?php } ?>
                                        <?php if(isset($message["message_publication"])) { ?>
                                            <div class="card mt-2 bg-dark publication-card p-3">
                                                <div class="card-body">
                                                    <a href="/profile/@<?= $message["message_publication"]["username"]; ?>" class="text-decoration-none">
                                                        <div class="col-md-2 d-inline-block">
                                                            <img src="<?=$message["message_publication"]["profile_image"];?>" class="rounded-circle" width="50px" height="50px" referrerpolicy="no-referrer">
                                                        </div>
                                                    </a>
                                                    <a href="/profile/@<?= $message["message_publication"]["username"]; ?>" class="d-inline-block ms-1 text-decoration-none">
                                                        <span class="d-inline-block text-white f-14"><b><?=$message["message_publication"]["name"];?> <?php if(userService::checkIfAccountVerified($message["message_publication"]["id_user"])) { ?> <i class="fa-solid fa-certificate text-purple"></i> <?php } ?> </b></span></br> 
                                                        <span class="text-muted d-inline-block f-12">@<?=$message["message_publication"]["username"];?> - </span>
                                                        <span class="text-muted d-inline-block f-12"><?=fwTime::getPassedTime($message["message_publication"]["publication_date"]);?></span>
                                                    </a>

                                                    <div class="col-md-10 d-inline-block align-top">
                                                        <a href="/publication/<?=$message["message_publication"]["id_publication"];?>" class="text-white text-decoration-none">
                                                        <div class="mt-3">
                                                            <p><?=$message["message_publication"]["publication_message"];?></p>
                                                            <?php if($message["message_publication"]["publication_img"] != "none") {?><a href="/publication/<?=$message["message_publication"]["id_publication"];?>"><img src="/cards/uploads/<?=$message["message_publication"]["publication_img"];?>" class="rounded publication-img"></a><?php } ?>
                                                        </div></a>
                                                        <?php if($message["message_publication"]["publication_deck"]) { ?>
                                                            <div class="inserted-deck-box" id="insert-deck-box">
                                                                <img class="d-inline-block m-2" width="100px" src="<?= $message["message_publication"]["deck_img"]; ?>" alt="">
                                                                <div class="d-inline-block align-top m-2">
                                                                    <span><b><?= $message["message_publication"]["deck_name"]; ?></b></span>                                    
                                                                    <?php if($message["message_publication"]["colors"]) { ?>
                                                                        <?php foreach (json_decode($message["message_publication"]["colors"], true) as $idx => $color) { ?>
                                                                            <img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/<?=$color;?>.svg" alt="" class="d-inline-block" width="20px">
                                                                        <?php } ?>
                                                                    <?php } ?><br>
                                                                    <span><?= $message["message_publication"]["format"]; ?></span><br>
                                                                    <span><?= $message["message_publication"]["totalPrice"]; ?> $ // <?= $message["message_publication"]["priceTix"]; ?> tix</span>
                                                                </div>
                                                                <a href="/deck/<?=$message["message_publication"]["publication_deck"];?>" class="btn btn-dark-primary active text-white m-3 btn-view-deck">
                                                                    <i class="fa-regular fa-eye me-2"></i> <?=$user->i18n("view_deck");?>
                                                                </a>
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <p class="text-muted pull-right"><?=fwTime::getPassedTime($message["date_sent"], true);?> ago</p>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="container w-100 d-flex justify-content-end">
                                <div class="row mt-2">
                                    <div class="message-box-right">
                                        <p><?=(isset($message["message_text"]) ? $message["message_text"] : "");?></p>
                                        <?php if(isset($message["message_img"])) { ?>
                                            <a href="/cards/uploads/<?=$message["message_img"];?>" data-lightbox="conver-image" data-title="<?=(isset($message["message_text"]) ? $message["message_text"] : "");?>">
                                                <img src="/cards/uploads/<?=$message["message_img"];?>" alt="" class="mb-4 conver_image img-fluid">
                                            </a>
                                        <?php } ?>
                                        <?php if(isset($message["message_publication"])) { ?>
                                            <div class="card mt-2 bg-dark publication-card p-3">
                                                <div class="card-body">
                                                    <a href="/profile/@<?= $message["message_publication"]["username"]; ?>" class="text-decoration-none">
                                                        <div class="col-md-2 d-inline-block">
                                                            <img src="<?=$message["message_publication"]["profile_image"];?>" class="rounded-circle" width="50px" height="50px" referrerpolicy="no-referrer">
                                                        </div>
                                                    </a>
                                                    <a href="/profile/@<?= $message["message_publication"]["username"]; ?>" class="d-inline-block ms-1 text-decoration-none">
                                                        <span class="d-inline-block text-white f-14"><b><?=$message["message_publication"]["name"];?> <?php if(userService::checkIfAccountVerified($message["message_publication"]["id_user"])) { ?> <i class="fa-solid fa-certificate text-purple"></i> <?php } ?> </b></span></br> 
                                                        <span class="text-muted d-inline-block f-12">@<?=$message["message_publication"]["username"];?> - </span>
                                                        <span class="text-muted d-inline-block f-12"><?=fwTime::getPassedTime($message["message_publication"]["publication_date"]);?></span>
                                                    </a>

                                                    <div class="col-md-10 d-inline-block align-top">
                                                        <a href="/publication/<?=$message["message_publication"]["id_publication"];?>" class="text-white text-decoration-none">
                                                        <div class="mt-3">
                                                            <p><?=$message["message_publication"]["publication_message"];?></p>
                                                            <?php if($message["message_publication"]["publication_img"] != "none") {?><a href="/publication/<?=$message["message_publication"]["id_publication"];?>"><img src="/cards/uploads/<?=$message["message_publication"]["publication_img"];?>" class="rounded publication-img"></a><?php } ?>
                                                        </div></a>
                                                        <?php if($message["message_publication"]["publication_deck"]) { ?>
                                                            <div class="inserted-deck-box" id="insert-deck-box">
                                                                <img class="d-inline-block m-2" width="100px" src="<?= $message["message_publication"]["deck_img"]; ?>" alt="">
                                                                <div class="d-inline-block align-top m-2">
                                                                    <span><b><?= $message["message_publication"]["deck_name"]; ?></b></span>                                    
                                                                    <?php if($message["message_publication"]["colors"]) { ?>
                                                                        <?php foreach (json_decode($message["message_publication"]["colors"], true) as $idx => $color) { ?>
                                                                            <img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/<?=$color;?>.svg" alt="" class="d-inline-block" width="20px">
                                                                        <?php } ?>
                                                                    <?php } ?><br>
                                                                    <span><?= $message["message_publication"]["format"]; ?></span><br>
                                                                    <span><?= $message["message_publication"]["totalPrice"]; ?> $ // <?= $message["message_publication"]["priceTix"]; ?> tix</span>
                                                                </div>
                                                                <a href="/deck/<?=$message["message_publication"]["publication_deck"];?>" class="btn btn-dark-primary active text-white m-3 btn-view-deck">
                                                                    <i class="fa-regular fa-eye me-2"></i> <?=$user->i18n("view_deck");?>
                                                                </a>
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <p class="text-muted pull-right"><?=fwTime::getPassedTime($message["date_sent"], true);?> ago</p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="input-group mt-5" id="message_box">
                            <button class="input-group-text btn-input-group" type="button" name="buttonImages" id="buttonImages" type="button"><i class="fa-solid fa-paperclip"></i></button>
                            <input type="text" data-emojiable="true" data-emoji-input="unicode" class="form-control" placeholder="<?=$user->i18n("message_to");?> <?=$user_chat["name"];?>..." name="message_text">
                            <input type="file" class="d-none" name="message[message_img]" id="message_img" value="none" onchange="loadFile(event)">
                            <button class="input-group-text btn-dark-primary active" type="submit" name="command_send" value="1"><i class="fa-regular fa-paper-plane me-2"></i> <?=$user->i18n("send");?></button>
                        </div>
                    </form>
                    <div id="imgContainer" class="d-none">
                        <button type="button" class="close-button-preview" onclick="removeFile()" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                        <img id="output" src="" class="mt-3 preview-img">
                    </div>
                </div>    
            </div>
        </div>
        <div class="col-md-4">
            <?php require_once('_suggested_users.php') ?>
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
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>
