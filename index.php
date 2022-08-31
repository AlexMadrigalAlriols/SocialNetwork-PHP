<?php require_once('cards/www/controllers/home.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('cards/www/templates/social/header.php'); ?>
<body>
<?php require_once('cards/www/templates/social/home_navbar.php'); ?>

<div class="container mt-3">
    <?php if(isset($_GET["error"])){?>
      <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
        <div>
            Error on profile, you can't access.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php } ?>

    <div id="copyLink" class="toast bg-primary position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Copied to clipboard
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <div id="reported" class="toast bg-success position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Success reported publication.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    
    <div id="deleted" class="toast bg-success position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Success deleted publication.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <div id="commentDeleted" class="toast bg-success position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Success deleted comment from publication.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <div id="deckInserted" class="toast bg-success position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Success inserted deck on publication.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="mt-3 bg-dark text-white rounded container">
                <h5 class="p-2 pt-4">Publicate Something</h5>
                <form action="" class="justify-content-md-center px-4 py-2" method="post" enctype="multipart/form-data">
                    <div class="input-group ms-3">   
                        <textarea class="form-control bg-dark text-white" data-emojiable="true" data-emoji-input="unicode" name="publication[publication_message]" id="publication_message" cols="2" rows="2" placeholder="I bought 4 Black Lotus..."></textarea>
                    </div>
                    <div id="imgContainer" class="d-none">
                        <button type="button" onclick="removeFile()" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent; color:white; border-style: none; position:relative;"><i class="fa-solid fa-xmark"></i></button>
                        <img id="output" src="" class="mt-3" style="width:10%; height:10%; border-radius: 15%;">
                    </div>
                    <div class="inserted-deck-box d-none" id="insert-deck-box">
                        <button type="button" onclick="removeDeck()" style="background-color: transparent; color:white; border-style: none; position:relative; float:right;"><i class="fa-solid fa-xmark"></i></button>
                        <img class="d-inline-block m-2" width="100px" id="deckImg" src="" alt="">
                        <div class="d-inline-block align-top">
                            <span><b id="deckName"></b></span> <span><img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/B.svg" alt="" class="d-inline-block ms-1" width="20px"></span><img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/G.svg" alt="" class="d-inline-block ms-1" width="20px"><br>
                            <span id="deckFormat"></span><br>
                            <span id="prices"></span>
                        </div>
                    </div>

                    <input type="hidden" name="publication[id_user]" value="<?=$user->get("id_user");?>">
                    <input type="file" class="d-none" name="publication[publication_img]" id="publication_img" value="none" onchange="loadFile(event)">
                    <input type="hidden" name="publication[publication_deck]" value="0" id="publication_deck">
                    <div class="buttons my-3">
                        <span>Insert:</span>
                        <button class="btn btn-dark-primary m-1 mb-2 d-inline-block" name="buttonImages" id="buttonImages" type="button"><i class="fa-regular fa-images"></i></button>
                        <button class="btn btn-dark-primary m-1 mb-2 d-inline-block" type="button" data-bs-toggle="modal" data-bs-target="#deckModal"><i class="fa-solid fa-box"></i></button>
                        <button class="btn btn-dark-primary active mt-2 d-inline-block" name="command_publish" style="float:right;" type="submit" value="1">Publish</button>
                    </div>
                </form>
            </div>
            <?php foreach ($publications as $idx => $publication) { ?>
                <div class="card mt-2 bg-dark">
                    <div class="card-body">
                        <a href="/profile/<?= $publication["id_user"]; ?>" style="text-decoration: none;">
                            <div class="col-md-1 d-inline-block">
                                <img src="/<?=$publication["profile_image"];?>" class="rounded-circle" width="50px" height="50px">
                            </div>
                        </a>

                        <div class="col-md-10 d-inline-block" style="vertical-align: top;">
                            <div>
                                <a href="/profile/<?= $publication["id_user"]; ?>" style="text-decoration: none;" class="d-inline-block">
                                    <span class="d-inline-block" style="font-size: 14px; color:White;"><b><?=$publication["name"];?></b></span> 
                                    <span class="text-muted d-inline-block" style="font-size: 12px;">@<?=$publication["username"];?> - </span>
                                    <span class="text-muted d-inline-block" style="font-size: 12px;"><?=fwTime::getPassedTime($publication["publication_date"]);?></span>
                                </a>
                                <div class="dropdown">
                                    <a class="d-inline-block mt-2" style="font-size: 18px; float:right; color:white;" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item mt-1" role="button" onclick="sharePublication(<?=$publication['id_publication'];?>, '<?= gc::getSetting('site.url'); ?>')"><i class="fa-solid fa-link"></i> Copy link</a></li>
                                        <form action="" method="post">
                                            <?php if($user->get("id_user") == $publication["id_user"] || $user_details["admin"]) { ?>
                                                <li><button class="dropdown-item mt-1" style="color: red;"  name="commandDelete" type="submit" value="<?=$publication["id_publication"];?>"><i class="fa-regular fa-trash-can"></i> Delete Publication</button></li>
                                            <?php } ?>
                                            <li><button class="dropdown-item mt-1" style="color: red;"  name="commandReport" type="submit" value="<?=$publication["id_publication"];?>"><i class="fa-regular fa-flag"></i> Report Publication</button></li>
                                        </form>
                                    </ul>
                                </div>

                            </div>
                            
                            <a href="/publication/<?=$publication["id_publication"];?>" class="text-white text-decoration-none">
                            <div class="mt-3">
                                <p><?=$publication["publication_message"];?></p>
                                <?php if($publication["publication_img"] != "none") {?><a href="/publication/<?=$publication["id_publication"];?>"><img src="/cards/uploads/<?=$publication["publication_img"];?>" class="rounded app-open-publication" style="width: 100%; max-height: 400px;"></a><?php } ?>
                            </div></a>
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
                                        <span><?= $publication["totalPrice"]; ?> € // <?= $publication["priceTix"]; ?> tix</span>
                                    </div>
                                    <a href="/deck/<?=$publication["publication_deck"];?>" class="btn btn-dark-primary active d-inline-block text-white m-4" style="float:right;">View Deck</a>
                                </div>
                            <?php } ?>

                            <div class="mt-2 ms-3" style="opacity: 60%;">
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
            <div class="show-more text-center mt-3 mb-3 d-none" title="More posts" id="load_post">
                <i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Loading...
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
                                        <button class="d-inline-block mt-2 btn btn-dark" style="font-size: 12px; float:right; background-color: #141414;" name="commandFollowSuggested" type="submit" value="<?=$user_sugg["user_id"];?>"><b>Follow</b></button>
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

<div class="modal fade" id="deckModal" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="card-name-add" style="color: black;">Insert a deck </h5><span id="card-set-add" style="color: black;"><b>&nbsp; </b></span>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <?php foreach ($decks as $idx => $deck) { ?>
                            <div class="card text-center deck-card bg-dark mt-2" style="width: 15rem; display: inline-block; margin: auto;">
                                <h5 class="card-header"><b><?=$deck["name"]; ?></b></h5>
                                <img src="<?=$deck["deck_img"]; ?>" class="card-img-top" style="width: 100%; margin: 0; height: 175px;">
                                <div class="card-body" style="float:left; text-align: left;">
                                    <p class="card-text"><b>Format:</b> <?=$deck["format"]; ?></p>
                                    
                                    <p class="card-text"><b>Colors:</b>
                                    <?php if($deck["colors"]) { ?>
                                        <?php foreach (json_decode($deck["colors"], true) as $idx => $color) { ?>
                                            <img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/<?=$color;?>.svg" alt="" class="d-inline-block" width="20px">
                                        <?php } ?>
                                    <?php } ?>
                                    </p>
                                    <p class="card-text"><b>Actual Price:</b> <?=$deck["totalPrice"]; ?> €</p>
                                    <div class="text-center">
                                        <button class="btn btn-dark-primary active w-100 insertDeck" type="button" value="<?=$deck["id_deck"];?>" data-name="<?=$deck["name"];?>" data-format="<?=$deck["format"];?>" data-price="<?=$deck["totalPrice"];?>" data-tix="<?=$deck["priceTix"];?>" data-img="<?=$deck["deck_img"];?>">Insert Deck</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="/cards/assets/js/globalController.js"></script>
<script>
    $( document ).ready(function() {
        $("#Home").addClass('active');
        $('#buttonImages').click(function(){ $('#publication_img').trigger('click'); });

        $(".insertDeck").click(function(){
            $("#publication_deck").val($(this).val());
            $("#insert-deck-box").removeClass("d-none");
            $('#deckModal').modal('toggle');
            $('#deckInserted').toast('show');
            $("#deckName").text($(this).data('name'));
            $("#deckFormat").text($(this).data('format'));
            $("#prices").text($(this).data('price') + " € // " + $(this).data('tix') + " tix");
            $("#deckImg").attr("src", $(this).data('img'));
        });

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

        
        <?php if(isset($_GET["commentDeleted"])) { ?>
            $('#commentDeleted').toast('show');
        <?php } ?> 
    });   

    var loadFile = function(event) {
        var output = document.getElementById('output');
        $("#imgContainer").removeClass("d-none");
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };

   /* $(window).scroll(function(){

        if (($(window).scrollTop() == $(document).height() - $(window).height())){
            $('#load_post').removeClass("d-none");
            alert("hola");
            //Cargar mas posts
            $.ajax({
                type:'POST',
                url:'ajax_more.php',
                data:{ 'action':'showPost', 'showPostFrom':$showPostFrom, 'showPostCount':$showPostCount },
                success:function(data){
                    if (data != '') {
                        $('#load_post').addClass("d-none");
                        $('.post-data-list').append(data).show('slow');
                    } else {
                        $('#load_post').addClass("d-none");
                    }
                }
            });
        }
    });*/

    function removeFile(){
        $("#imgContainer").addClass("d-none");
        const file = document.querySelector('#publication_img');
        file.value = '';
    }

    function removeDeck() {
        $("#insert-deck-box").addClass("d-none");
        $("#publication_deck").val(0);
    }

</script>
</body>
</html>
