<?php require_once('cards/www/controllers/publication.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/social/header.php'); ?>
<body>
<?php require_once('cards/www/templates/social/home_navbar.php'); ?>

<div class="container mt-3 mb-5">
<?php require_once('cards/www/templates/_toast.php') ?>
    <div class="row">
        <div class="col-md-8">
            <div class="mt-3 p-4 bg-dark text-white rounded container">
                <div class="mb-3">
                    <a class="fa-solid fa-arrow-left d-inline-block me-2 text-white text-decoration-none" href="/"></a>
                    <div class="vr"></div>
                    <h5 class="d-inline-block"><?=$user->i18n("publication");?></h5>
                </div>
                <a href="/profile/@<?= $publication["username"]; ?>" class="text-decoration-none">
                    <div class="col-md-1 d-inline-block">
                        <img src="<?=$publication["profile_image"];?>" class="rounded-circle" width="50px" height="50px" referrerpolicy="no-referrer">
                    </div>
                </a>

                <div class="col-md-10 d-inline-block align-top">
                    <div>
                        <a href="/profile/@<?= $publication["username"]; ?>" class="d-inline-block text-decoration-none">
                            <span class="d-inline-block text-white f-14"><b><?=$publication["name"];?></b></span> 
                            <span class="text-muted d-inline-block f-12">@<?=$publication["username"];?> - </span>
                            <span class="text-muted d-inline-block f-12"><?=fwTime::getPassedTime($publication["publication_date"]);?></span>
                        </a>
                        <div class="dropdown">
                            <a class="d-inline-block mt-2 f-18 text-white pull-right" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item mt-1" role="button" onclick="sharePublication(<?=$publication['id_publication'];?>, '<?= gc::getSetting('site.url'); ?>')"><i class="fa-solid fa-link"></i> <?=$user->i18n("copy_link");?></a></li>
                                    <form action="" method="post">
                                        <?php if($user->get("id_user") == $publication["id_user"] || $user_details["admin"]) { ?>
                                            <li><button class="dropdown-item mt-1 text-red" name="commandDelete" type="submit" value="<?=$publication["id_publication"];?>"><i class="fa-regular fa-trash-can"></i> <?=$user->i18n("delete_publication");?></button></li>
                                        <?php } ?>
                                        <li><button class="dropdown-item mt-1 text-red" name="commandReport" type="submit" value="<?=$publication["id_publication"];?>"><i class="fa-regular fa-flag"></i> <?=$user->i18n("report_publication");?></button></li>
                                    </form>
                                </ul>
                        </div>
                    </div>
                            
                    <div class="mt-3">
                        <p><?=$publication["publication_message"];?></p>
                        <?php if($publication["publication_img"] != "none") {?>
                            <a href="/cards/uploads/<?=$publication["publication_img"];?>" data-lightbox="conver-image">
                                <img src="/cards/uploads/<?=$publication["publication_img"];?>" class="rounded app-open-publication publication-img">
                            </a>
                        <?php } ?>
                    </div>
                    <?php if($publication["publication_deck"]) { ?>
                        <div class="inserted-deck-box" id="insert-deck-box">
                            <img class="d-inline-block m-2" width="100px" src="<?= $publication["deck_img"]; ?>" alt="">
                            <div class="d-inline-block align-top">
                                <span><b><?= $publication["deck_name"]; ?></b></span>                                    
                                <?php if($publication["colors"]) { ?>
                                    <?php foreach (json_decode($publication["colors"], true) as $idx => $color) { ?>
                                        <img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/<?=$color;?>.svg" alt="" class="d-inline-block" width="20px">
                                    <?php } ?>
                                <?php } ?><br>
                                <span><?= $publication["format"]; ?></span><br>
                                <span><?= $publication["totalPrice"]; ?> $ // <?= $publication["priceTix"]; ?> tix</span>
                            </div>
                            <a href="/deck/<?=$publication["publication_deck"];?>" class="btn btn-dark-primary active d-inline-block text-white m-4 pull-right"><?=$user->i18n("view_deck");?></a>
                        </div>
                    <?php } ?>

                    <div class="mt-3 ms-1 opacity-75">
                        <div class="d-inline-block me-1">
                            <button class="btn btn-dark <?php if(in_array($user->get("id_user"),json_decode($publication["publication_likes"],true))){?>active<?php } ?>" onclick='publicationLike(<?= $publication["id_publication"]; ?>)' id="like---<?=$publication["id_publication"];?>">
                                <?php if(in_array($user->get("id_user"),json_decode($publication["publication_likes"],true))){?>
                                    <i class="fa-solid fa-heart d-inline-block" id="like-icon2---<?= $publication["id_publication"]; ?>"></i>
                                <?php } else { ?>
                                    <i class="fa-regular fa-heart d-inline-block" id="like-icon---<?= $publication["id_publication"]; ?>"></i>
                                <?php } ?>
                                <span class="d-inline-bloc ms-2" id="likes-txt---<?=$publication["id_publication"]; ?>"><?=count(json_decode($publication["publication_likes"], true));?></span>
                            </button>
                        </div>
                        <div class="d-inline-block me-1">
                            <button class="btn btn-dark">
                                <i class="fa-regular fa-comment d-inline-block"></i>
                                <span class="d-inline-bloc ms-2"><?= publicationCommentService::getCommentCount($publication["id_publication"]); ?></span>
                            </button>
                        </div>
                        <div class="d-inline-block pull-right">
                            <button class="btn btn-dark" onclick="sharePublication(<?=$publication['id_publication'];?>, '<?= gc::getSetting('site.url'); ?>')">
                                <i class="fa-solid fa-share d-inline-block"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <hr>
                <h5 class="p-2"><?=$user->i18n("comments");?></h5>
                <form action="" class="justify-content-md-center px-4" method="post">
                    <div class="input-group ms-3">   
                        <textarea class="form-control bg-dark text-white" data-emojiable="true" data-emoji-input="unicode" name="comment_message" id="comment_message" rows="2" placeholder="<?=$user->i18n("comment_message");?>"></textarea>
                    </div>
                    <button class="btn btn-dark-primary active ms-3 mt-3" name="commandCommentPublish" type="submit" value="1" <?=($user_details ? "" : "disabled")?>><?=$user->i18n("publish");?></button>
                </form>
                <?php foreach ($comments as $idx => $comment) { ?>
                    <div class="card bg-dark mt-3 comment-card">
                        <div class="card-body">
                            <a href="/profile/@<?= $comment["username"]; ?>" class="text-decoration-none">
                                <div class="col-md-1 d-inline-block">
                                    <img src="<?=$comment["profile_image"];?>" class="rounded-circle" width="50px" height="50px" referrerpolicy="no-referrer">
                                </div>
                            </a>

                            <div class="col-md-10 d-inline-block align-top">
                                <div>
                                    <a href="/profile/@<?= $comment["username"]; ?>" class="d-inline-block text-decoration-none">
                                        <span class="d-inline-block f-14 text-white"><b><?=$comment["name"];?></b></span> 
                                        <span class="text-muted d-inline-block f-12">@<?=$comment["username"];?> - </span>
                                        <span class="text-muted d-inline-block f-12"><?=fwTime::getPassedTime($comment["comment_date"]);?></span>
                                    </a>
                                    <div class="dropdown">
                                        <a class="d-inline-block mt-2 f-18 pull-right text-white" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                        <ul class="dropdown-menu">
                                            <form action="" method="post">
                                                <?php if($user->get("id_user") == $comment["id_user"] || $user->get("id_user") == $publication["id_user"] || $user_details["admin"]) { ?>
                                                    <li><button class="dropdown-item mt-1 text-red" name="commandCommentDelete" type="submit" value="<?=$comment["id_comment"];?>"><i class="fa-regular fa-trash-can"></i> <?=$user->i18n("delete_comment");?></button></li>
                                                <?php } ?>
                                                <li><button class="dropdown-item mt-1 text-red" name="commandReport" type="submit" value="<?=$publication["id_publication"];?>"><i class="fa-regular fa-flag"></i> <?=$user->i18n("report_comment");?></button></li>
                                            </form>
                                        </ul>
                                    </div>
                                </div>
                                        
                                <div class="mt-3">
                                    <p><?=$comment["comment_message"];?></p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-4">
            <?php require_once('_suggested_users.php') ?>
        </div>
    </div>
</div>

<script src="/cards/assets/vendor/lightbox/js/lightbox.js"></script>
<script src="/cards/assets/js/globalController.js"></script>
<script>
    $( document ).ready(function() {
        $(function() {
            window.emojiPicker = new EmojiPicker({
                emojiable_selector: '[data-emojiable=true]',
                assetsPath: '/cards/assets/vendor/emojilib/img/',
                popupButtonClasses: 'fa fa-smile-o emoji-right'
            });
            window.emojiPicker.discover();
        });

        <?php if(isset($_GET["reported"])) { ?>
            $('#reported').toast('show');
        <?php } ?>

        <?php if(isset($_GET["deleted"])) { ?>
            $('#deleted').toast('show');
        <?php } ?> 
        
        <?php if(isset($_GET["success"])) { ?>
            $('#commented').toast('show');
        <?php } ?> 

        <?php if(isset($_GET["commentDeleted"])) { ?>
            $('#commentDeleted').toast('show');
        <?php } ?> 
    });  

</script>
</body>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>
