<?php require_once('cards/www/controllers/home.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/social/header.php'); ?>
<body>
<?php require_once('cards/www/templates/social/home_navbar.php'); ?>

<div class="container mt-3 mb-5">
    <div class="row">
        <div class="col-md-8">
            <div class="mt-3 bg-dark text-white rounded container">
                <h5 class="p-2 pt-4"><?=$user->i18n("publicate_text");?></h5>
                <form action="" class="justify-content-md-center px-4 py-2" method="post" enctype="multipart/form-data">
                    <div class="input-group ms-3">   
                        <textarea class="form-control bg-dark text-white" data-emojiable="true" data-emoji-input="unicode" name="publication[publication_message]" id="publication_message" cols="2" rows="2" placeholder="<?= $user->i18n("publication_help");?>"></textarea>
                    </div>
                    <div id="imgContainer" class="d-none">
                        <button type="button" onclick="removeFile()" data-bs-dismiss="modal" aria-label="Close" class="close-button-preview"><i class="fa-solid fa-xmark"></i></button>
                        <img id="output" src="" class="mt-3 preview-img">
                    </div>
                    <div class="inserted-deck-box d-none" id="insert-deck-box">
                        <button type="button" onclick="removeDeck()" class="close-button-preview pull-right"><i class="fa-solid fa-xmark"></i></button>
                        <img class="d-inline-block m-2" width="100px" id="deckImg" src="" alt="">
                        <div class="d-inline-block align-top">
                            <span><b id="deckName"></b></span> <br>
                            <span id="deckFormat"></span><br>
                            <span id="prices"></span>
                        </div>
                    </div>

                    <input type="hidden" name="publication[id_user]" value="<?=$user->get("id_user");?>">
                    <input type="file" class="d-none" name="publication[publication_img]" id="publication_img" value="none" onchange="loadFile(event)">
                    <input type="hidden" name="publication[publication_deck]" value="0" id="publication_deck">
                    <div class="buttons my-3">
                        <span><?= $user->i18n("insert");?>:</span>
                        <button class="btn btn-dark-primary m-1 mb-2 d-inline-block" name="buttonImages" id="buttonImages" type="button"><i class="fa-regular fa-images"></i></button>
                        <button class="btn btn-dark-primary m-1 mb-2 d-inline-block" type="button" data-bs-toggle="modal" data-bs-target="#deckModal"><i class="fa-solid fa-box"></i></button>
                        <button class="btn btn-dark-primary active mt-2 d-inline-block pull-right" name="command_publish" type="submit" value="1"><?= $user->i18n("publish");?></button>
                    </div>
                </form>
            </div>
            <div id="frm-publications" class="mb-4">
            <?php foreach ($publications as $idx => $publication) { ?>
                <div class="card mt-2 bg-dark publication-card">
                    <div class="card-body">
                        <a href="/profile/@<?= $publication["username"]; ?>" class="text-decoration-none">
                            <div class="col-md-1 d-inline-block">
                                <img src="/<?=$publication["profile_image"];?>" class="rounded-circle" width="50px" height="50px">
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
                                    <a class="d-inline-block mt-2 pull-right text-white f-18" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
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
                            
                            <a href="/publication/<?=$publication["id_publication"];?>" class="text-white text-decoration-none">
                            <div class="mt-3">
                                <p><?=$publication["publication_message"];?></p>
                                <?php if($publication["publication_img"] != "none") {?><a href="/publication/<?=$publication["id_publication"];?>"><img src="/cards/uploads/<?=$publication["publication_img"];?>" class="rounded publication-img"></a><?php } ?>
                            </div></a>
                            <?php if($publication["publication_deck"]) { ?>
                                <div class="inserted-deck-box" id="insert-deck-box">
                                    <img class="d-inline-block m-2" width="100px" src="<?= $publication["deck_img"]; ?>" alt="">
                                    <div class="d-inline-block align-top m-2">
                                        <span><b><?= $publication["deck_name"]; ?></b></span>                                    
                                        <?php if($publication["colors"]) { ?>
                                            <?php foreach (json_decode($publication["colors"], true) as $idx => $color) { ?>
                                                <img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/<?=$color;?>.svg" alt="" class="d-inline-block" width="20px">
                                            <?php } ?>
                                        <?php } ?><br>
                                        <span><?= $publication["format"]; ?></span><br>
                                        <span><?= $publication["totalPrice"]; ?> $ // <?= $publication["priceTix"]; ?> tix</span>
                                    </div>
                                    <a href="/deck/<?=$publication["publication_deck"];?>" class="btn btn-dark-primary active text-white m-3 btn-view-deck">
                                        <?=$user->i18n("view_deck");?>
                                    </a>
                                </div>
                            <?php } ?>

                            <div class="mt-2 ms-3 opacity-75">
                                <div class="d-inline-block me-5">
                                    <button class="btn btn-dark <?php if(in_array($user->get("id_user") , json_decode($publication["publication_likes"],true))){?>active<?php } ?>" onclick='publicationLike(<?= $publication["id_publication"]; ?>)' id="like---<?=$publication["id_publication"];?>">
                                        <?php if(in_array($user->get("id_user"),json_decode($publication["publication_likes"],true))){?>
                                            <i class="fa-solid fa-heart d-inline-block" id="like-icon2---<?= $publication["id_publication"]; ?>"></i>
                                        <?php } else { ?>
                                            <i class="fa-regular fa-heart d-inline-block" id="like-icon---<?= $publication["id_publication"]; ?>"></i>
                                        <?php } ?>
                                        <span class="d-inline-bloc ms-2" id="likes-txt---<?=$publication["id_publication"]; ?>"><?=count(json_decode($publication["publication_likes"], true));?></span>
                                    </button>
                                </div>

                                <div class="d-inline-block me-5">
                                    <a class="btn btn-dark" href="/publication/<?=$publication["id_publication"];?>">
                                        <i class="fa-regular fa-comment d-inline-block"></i>
                                        <span class="d-inline-bloc ms-2"><?= publicationCommentService::getCommentCount($publication["id_publication"]); ?></span>
                                        </a>
                                </div>

                                <div class="d-inline-block">
                                    <button class="btn btn-dark" onclick="sharePublication(<?=$publication['id_publication'];?>, '<?= gc::getSetting('site.url'); ?>')">
                                        <i class="fa-solid fa-share d-inline-block"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
            <div class="show-more text-center mt-3 mb-3 d-none" title="More posts" id="load_post">
                <i class="fa fa-circle-o-notch fa-spin fa-fw"></i> <?=$user->i18n("load_publications");?>...
            </div>
        </div>

        <div class="col-md-4">
            <?php require_once('www/templates/social/_suggested_users.php') ?>
        </div>
    </div>
</div>

<div class="modal fade" id="deckModal" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="card-name-add"><?=$user->i18n("insert_deck");?></h5><span id="card-set-add" class="text-dark"><b>&nbsp; </b></span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <?php foreach ($decks as $idx => $deck) { ?>
                            <div class="card deck-card bg-dark mt-2 d-inline-block m-auto" style="width: 15rem;">
                                <h5 class="card-header"><b><?=$deck["name"]; ?></b></h5>
                                <img src="<?=$deck["deck_img"]; ?>" class="card-img-top w-100 m-0 align-center" height="175px">
                                <div class="card-body">
                                    <p class="card-text"><b><?=$user->i18n("format");?>:</b> <?=$deck["format"]; ?></p>
                                    
                                    <p class="card-text"><b><?=$user->i18n("colors");?>:</b>
                                    <?php if($deck["colors"]) { ?>
                                        <?php foreach (json_decode($deck["colors"], true) as $idx => $color) { ?>
                                            <img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/<?=$color;?>.svg" alt="" class="d-inline-block" width="20px">
                                        <?php } ?>
                                    <?php } ?>
                                    </p>
                                    <p class="card-text"><b><?=$user->i18n("actual_price");?></b> <?=$deck["totalPrice"]; ?> $</p>
                                    <div class="text-center">
                                        <button class="btn btn-dark-primary active w-100 insertDeck" type="button" value="<?=$deck["id_deck"];?>" data-name="<?=$deck["name"];?>" data-format="<?=$deck["format"];?>" data-price="<?=$deck["totalPrice"];?>" data-tix="<?=$deck["priceTix"];?>" data-img="<?=$deck["deck_img"];?>" data-colors="<?=$deck["colors"];?>"><?=$user->i18n("insert_deck"); ?></button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/cards/assets/js/globalController.js"></script>
<script>
    $postPerLoad = <?= gc::getSetting("publications.numPerLoad"); ?>;
    $totalRecord = <?= publicationService::countPublicationFeed($user->get("id_user"));?>;
    $( document ).ready(function() {
        <?php if(isset($_GET["reported"])) { ?>
            $('#reported').toast('show');
        <?php } ?>

        <?php if(isset($_GET["deleted"])) { ?>
            $('#deleted').toast('show');
        <?php } ?> 

        <?php if(isset($_GET["error"])) { ?>
            $('#errorProfile').toast('show');
        <?php } ?> 
    });   

    $( "#search-bar" ).keyup(function() {
        alert( "Handler for .keyup() called." );
    });

</script>

<script src="/cards/assets/js/homeController.js"></script>
</body>
<?php require_once('www/templates/_toast.php') ?>
</html>
