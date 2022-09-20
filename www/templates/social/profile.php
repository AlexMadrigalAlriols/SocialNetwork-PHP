
<!DOCTYPE html>
<html lang="en">
<?php require_once('header.php'); ?>
<?php require_once('cards/www/controllers/profile.php'); ?>
<body>
<?php require_once('home_navbar.php'); ?>

<div class="container mt-4">
    <div id="copyLink" class="toast bg-primary position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Copied to clipboard
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

    <div id="reported" class="toast bg-success position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Success reported publication.
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <?php if(isset($_GET["error"])){?>
      <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
        <div>
            Error on upload your profile cover, try it with other image.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php } ?>
    <?php if(isset($_GET["reported"])){?>
      <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
        <div>
            Success reported user.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php } ?>
    
    <div class="mt-4 bg-dark text-white rounded">

        <div style="position:relative;">
            <img  src="/<?= ($user_profile_details["profile_cover"] ? $user_profile_details["profile_cover"] : "cards/uploads/profileCover.png"); ?>" alt="" style="width:100%; height:10rem; z-index: -1;">
            <?php if($user_id == $user->get("id_user")) { ?>
                <button class="btn btn-secondary" style="position:absolute; display:block; top: 15px; right: 15px; opacity: 70%;" data-bs-toggle="modal" data-bs-target="#coverModal"><i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;Edit cover</button>
            <?php } ?>
            <?php if($user_profile_details["cardmarket_link"]){ ?>
                <a href="<?= $user_profile_details["cardmarket_link"];?>" class="btn btn-secondary" target="_blank" style="position:absolute; display:block; top: 15px; left: 30px;"><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;CardMarket</a>
            <?php } ?>
            <img class="rounded-circle" src="/<?= $user_profile_details["profile_image"];?>" alt="" style="width: 150px; height: 150px; margin-top: -5rem; margin-left: 3%;">
        </div>

        <div class="p-3" style="margin-top: -4rem; position: relative;">
            <div class="d-inline-block" style="margin-left: 11rem; ">
                <h4><?= $user_profile_details["name"];?></h4>
                <p class="text-muted">@<?=$user_profile_details["username"];?></p>
            </div>

            <div class="d-inline-block text-center" style="margin-left: 10rem;">
                <div class="d-inline-block">
                    <h6>Publications</h6>
                    <span><center><?= count($publications); ?></center></span>
                </div>
                <div class="d-inline-block ms-3">
                    <h6>Followers</h6>
                    <span><center id="followers"><?= count(json_decode($user_profile_details["followers"], true)); ?></center></span>
                </div>

                <div class="d-inline-block ms-3">
                    <h6>Torneos</h6>
                    <span><center>12</center></span>
                </div>
            </div>

            <div class="d-inline-block" style="float:right; position: absolute; right: 25px;">
                <?php if($user_id == $user->get("id_user")){ ?>
                    <a class="btn btn-dark-primary d-inline-block" href="/settings"><i class="fa-solid fa-pencil me-2"></i> Edit Profile</a>
                <?php } else { ?>
                    <form action="" method="post" class="d-inline-block">
                        <?php if(!in_array($user_id, json_decode($user_details["followed"], true)) && !in_array($user_id, json_decode($user_details["blocked_users"], true))) { ?>
                            <button class="btn btn-dark-primary active d-inline-block" type="submit" name="command_follow" value="1">Follow <i class="fa-solid fa-plus"></i></button>
                        
                        <?php } else if (in_array($user_id, json_decode($user_details["blocked_users"], true))) { ?>
                            <button class="btn btn-dark-primary d-inline-block" type="submit" name="command_unblock" value="1">Unblock <i class="fa-solid fa-ban"></i></button>
                        
                        <?php } else { ?>
                            <button class="btn btn-dark-primary d-inline-block" type="submit" name="command_unfollow" value="1">UnFollow <i class="fa-solid fa-heart-crack"></i></button>
                        
                        <?php } ?>    

                        <a href="#" class="d-inline-block" style="color: white; font-size: 30px;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                        <ul class="dropdown-menu mt-4 animate slideIn" aria-labelledby="dropdownMenuButton1">
                            <li><a href="/messages/@<?=$user_profile_details["username"];?>" class="dropdown-item"><i class="fa-solid fa-inbox"></i> Enviar mensaje</a></li>
                            <li><a class="dropdown-item" href="/profile/<?=$user_profile_details["user_id"];?>"><i class="fa-solid fa-share-nodes"></i> Share Profile</a></li>
                            <?php if (!in_array($user_id, json_decode($user_details["blocked_users"], true))) { ?>
                                <li><button class="dropdown-item" style="color: red;" name="command_block" value="1" type="submit"><i class="fa-solid fa-user-lock"></i> Block user</a></button>
                            <?php } else { ?>
                                <li><button class="dropdown-item" style="color: red;" name="command_unblock" value="1" type="submit"><i class="fa-solid fa-user-lock"></i> UnBlock user</a></button>
                            <?php } ?>
                            <li><button class="dropdown-item" href="#" style="color: red;" name="command_report" value="1" type="submit"><i class="fa-solid fa-flag"></i> Report user</button></li>
                        </ul>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="row container">
    <div class="mt-3 mb-3 p-4 bg-dark text-white rounded col-md-4" style="height:50%;">
            <h4>Biografia</h4>
            <div>
                <p><?=$user_profile_details["biography"]; ?></p>
            </div>
            <hr>
            <div>
                <?php if($user_profile_details["ubication"]) { ?>
                    <h6><i class="fa-solid fa-location-dot"></i> Ubicacion</h6>
                <?php } ?>
                <p class="text-muted"><?=$user_profile_details["ubication"];?></p>
                
                <?php if($user_profile_details["website"]) { ?>
                    <h6><i class="fa-solid fa-globe"></i> Website</h6>
                    <p><a href="#"><?=$user_profile_details["website"];?></a></p>
                <?php } ?>
                <?php if($user_profile_details["twitter"] || $user_profile_details["instagram"] || $user_profile_details["discord"]) { ?>
                    <h5>Social Networks</h5>
                <?php } ?>
                <?php if($user_profile_details["twitter"]) { ?>
                    <h6><i class="fa-brands fa-twitter"></i> Twitter</h6>
                    <a href="https://twitter.com/<?=$user_profile_details["twitter"];?>" target="_blank"><p class="text-muted"><?=$user_profile_details["twitter"];?></p></a>
                <?php } ?>

                <?php if($user_profile_details["instagram"]) { ?>
                    <h6><i class="fa-brands fa-instagram"></i> Instagram</h6>
                    <a href="https://www.instagram.com/<?=$user_profile_details["instagram"];?>" target="_blank"><p class="text-muted">@<?=$user_profile_details["instagram"];?></p></a>
                <?php } ?>

                <?php if($user_profile_details["discord"]) { ?>
                    <h6><i class="fa-brands fa-discord"></i> Discord</h6>
                    <p class="text-muted"><?=$user_profile_details["discord"];?></p>
                <?php } ?>
            </div>
        </div>
        <div class="mt-3 mb-2 ms-5 p-4 bg-dark text-white rounded col-md-7">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="btn btn-dark-primary active" id="pills-publications-tab" data-bs-toggle="pill" data-bs-target="#publications" type="button" role="tab" aria-controls="publications" aria-selected="true">Publications</button>
                </li>
                <?php if($user_profile_details["shop"]){ ?>
                    <li class="nav-item ms-3" role="presentation">
                    <button class="btn btn-dark-primary" id="pills-tournaments-tab" data-bs-toggle="pill" data-bs-target="#tournaments" type="button" role="tab" aria-controls="tournaments" aria-selected="false">Tournaments</button>
                    </li>
                <?php } ?>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active col-md-12" id="publications" role="tabpanel" aria-labelledby="pills-publications-tab" tabindex="0">
                    <div class="container">
                        <div class="row">
                            <?php if(count($publications) == 0) {?>
                                <div id="noPublications" class="mt-2"><h5>Este usuario aun no tiene publicaciones!</h5></div>
                            <?php } ?>

                            <?php foreach ($publications as $idx => $publication) { ?>
                                <div class="card ms-2 mt-2" style="background-color: #1b1a1a;">
                                    <div class="card-body">
                                        <div class="col-md-2 d-inline-block">
                                            <img src="/<?=$user_profile_details["profile_image"]; ?>" class="rounded-circle" width="50px" height="50px">
                                        </div>
                                        <div class="col-md-9 d-inline-block" style="vertical-align: top;">
                                            <div>
                                                <span class="d-inline-block" style="font-size: 14px;"><b><?=$user_profile_details["name"]; ?></b></span>
                                                <span class="text-muted d-inline-block" style="font-size: 12px;">@<?=$user_profile_details["username"]; ?> - </span>
                                                <span class="text-muted d-inline-block" style="font-size: 12px;"><span class="text-muted d-inline-block" style="font-size: 12px;"><?=fwTime::getPassedTime($publication["publication_date"]);?></span></span>
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
                                            <div class="mt-3">
                                                <p><?=$publication["publication_message"];?></p>
                                                <?php if($publication["publication_img"] != "none"){?><a href="/publication/<?= $publication['id_publication']; ?>"><img src="<?=($publication["publication_img"] != "none" ? "/cards/uploads/".$publication["publication_img"] : "");?>" class="rounded" style="width: 100%; rounded-border: 15%;"></a><?php } ?>
                                            </div>
                                            <?php if($publication["publication_deck"]) { ?>
                                                <div class="inserted-deck-box" id="insert-deck-box" style="margin-left: 0;">
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
                                                    <a href="/deck/<?=$publication["publication_deck"];?>" class="btn btn-dark-primary active text-white m-3">View Deck</a>
                                                </div>
                                            <?php } ?>
                                            <div class="mt-2 ms-3" style="opacity: 60%;">
                                                <div class="d-inline-block me-5">
                                                    <button class="btn btn-dark" onclick='publicationLike(<?= $publication["id_publication"]; ?>)' id="like---<?=$publication["id_publication"];?>" style="background-color: #1b1a1a; border-color: transparent;">
                                                        <?php if(in_array($user->get("id_user"),json_decode($publication["publication_likes"],true))){?>
                                                            <i class="fa-solid fa-heart d-inline-block" id="like-icon2---<?= $publication["id_publication"]; ?>"></i>
                                                        <?php } else { ?>
                                                            <i class="fa-regular fa-heart d-inline-block" id="like-icon---<?= $publication["id_publication"]; ?>"></i>
                                                        <?php } ?>
                                                        <span class="d-inline-bloc ms-2" id="likes-txt---<?=$publication["id_publication"]; ?>"><?=count(json_decode($publication["publication_likes"], true));?></span>
                                                    </button>
                                                </div>


                                                <div class="d-inline-block me-5">
                                                    <a class="btn btn-dark" href="/publication/<?= $publication['id_publication']; ?>" style="background-color: #1b1a1a; border-color: transparent;">
                                                        <i class="fa-regular fa-comment d-inline-block"></i>
                                                        <span class="d-inline-bloc ms-2"><?= publicationCommentService::getCommentCount($publication["id_publication"]); ?></span>
                                                    </a>
                                                </div>

                                                <div class="d-inline-block">
                                                    <button class="btn btn-dark" onclick="sharePublication(<?=$publication['id_publication'];?>, '<?= gc::getSetting('site.url'); ?>')" style="background-color: #1b1a1a; border-color: transparent;">
                                                        <i class="fa-solid fa-share d-inline-block"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="tournaments" role="tabpanel" aria-labelledby="pills-tournaments-tab" tabindex="0">
                    <div class="container">
                        <div class="row m-auto">
                            <?php foreach ($tournaments as $idx => $tournament) { ?>
                            <div class="card ms-2 m-auto mt-4" style="width: 14rem; background-color: #1b1a1a;">
                                <img src="<?=($tournament["image"] ? "/cards/uploads/".$tournament["image"] : "/cards/assets/img/placeholder.png");?>" class="card-img-top mt-3 rounded" style="height: 150px;">
                                <div class="card-body" style="margin-left: -0.5rem;">
                                    <h6><?= $tournament["name"]; ?></h6>
                                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-clock me-2"></i> <?= date_format(date_create($tournament["start_date"]), "d/m/Y - H:i") ?></span><br>
                                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-users me-1"></i> <?= count(json_decode($tournament["players"], true)); ?>/<?= $tournament["max_players"]; ?> players</span><br>
                                    <span class="text-muted"><b style="font-size:20px; color:#4723D9;"><?=$tournament["tournament_price"];?><?=gc::getSetting("currencies")[$user_details["shop_currency"]];?></b>/player</span>
                                    <hr style="width: 100%;">
                                    <center><button class="btn btn-dark-primary active btn-block d-md-block w-100" onclick="viewTournamentDetails(this)" data-id="<?=$tournament["id_tournament"];?>">View Details</button></center>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modals -->
<div class="modal text-white" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Tournament Details</h5>
                <button type="button" class="btn-close" style="color:white;" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="tournament_image" src="/cards/assets/img/placeholder.png" class="card-img-top mt-3 rounded" style="height: 150px;">
                            <div class="card-body" style="margin-left: -0.5rem;">
                                <h6 id="tournament_name">Clasificatorio Sofia 2022</h6>
                                <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-clock me-2"></i> <span id="tournament_date">07/07/2022 - 10:00 PM</span></span><br>
                                <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-users me-1"></i> <span id="tournament_players">5/80</span> players</span><br>
                                <span class="text-muted"><b style="font-size:20px; color:#4723D9;" id="tournament_price">30€</b>/player</span>
                                <hr style="width: 100%;">
                                <form method="POST">
                                    <center><a class="btn btn-dark-primary active btn-block d-md-block w-100" href="/messages/@<?=$user_details["username"];?>"><i class="fa-regular fa-message"></i> Send Message</a></center>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h3>Details</h3>
                            <p class="text-muted" id="tournament_description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse tempora, laudantium commodi magni porro a.</p>
                            <h3>Prices</h3>
                            <div class="row" id="pricesContainer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal text-white" id="coverModal" tabindex="-1" aria-labelledby="coverModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark">
        <div class="modal-content bg-dark">
            <form method="post" id="frm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profile Cover</h5>
                    <button type="button" class="btn-close" style="color:white;" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <h6>Actual Cover:</h6>
                    <img class="mb-3" src="/<?= ($user_profile_details["profile_cover"] ? $user_profile_details["profile_cover"] : "cards/uploads/profileCover.png"); ?>" alt="" width="100%" height="75px">
                    <h6>Upload new cover:</h6>
                    <input type="file" class="form-control" name="profile[newProfileCover]" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark-primary active" name="commandUploadCover" value="1">Update Cover</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/cards/assets/js/globalController.js"></script>
<script>
    $( document ).ready(function() {
        <?php if(isset($_GET["report"])) { ?>
            $('#reported').toast('show');
        <?php } ?>

        <?php if(isset($_GET["deleted"])) { ?>
            $('#deleted').toast('show');
        <?php } ?>
        
    });   

    function viewTournamentDetails(button) {
        $.ajax({
            url: '/getTournamentDetails',
            type: 'POST',
            async: false,
            data: {id_tournament: $(button).data("id")},
            success: function(data) {
                tournament = JSON.parse(data);
                $("#commandSignUp").attr("value", tournament.id_tournament);
                $("#tournament_name").text(tournament.name);
                $("#tournament_description").text(tournament.description);
                $("#tournament_price").text(tournament.tournament_price + "€");
                $("#tournament_date").text(tournament.start_date);
                $("#tournament_image").attr("src", tournament.image);

                actual_players = JSON.parse(tournament.players);
                $("#tournament_players").text(Object.keys(actual_players).length + "/" + tournament.max_players);
                $('#detailsModal').modal('toggle');
                prices = JSON.parse(tournament.prices);
                prices_keys = Object.keys(prices);

                $("#pricesContainer").empty();
                for (let idx = 0; idx < prices_keys.length; idx++) {
                    html = "<div class='col-md-6 mb-4'>";
                    html += prices_keys[idx] + ". </br>";

                    for (let index = 0; index < Object.keys(prices[prices_keys[idx]]).length; index++) {
                        card = prices[prices_keys[idx]][Object.keys(prices[prices_keys[idx]])[index]];


                        html += '<div>'+
                            '<span onmouseenter="showImg(this)" onmouseleave="showImg(this)">- '+card.qty+'x '+card.name;

                        if(card.foil == "on") {
                            html += " (FOIL)";
                        }
                        
                        if(card.type == "card") {
                            $.ajax({
                                url: '/getCardById',
                                type: 'POST',
                                async: false,
                                data: {card_id: card.id},
                                success: function(data) {
                                    cards = JSON.parse(data);

                                    html += '<div class="showImgCard d-none" style="position: absolute; margin-left: 5rem;">'+
                                        '<img src="'+cards.Img+'">'+
                                    '</div>';
                                }
                            });
                        }

                        html += '</br></span></div>';
                    }

                    html += "</div>";
                    $("#pricesContainer").append(html);
                }

            }
        });
        
    }

    function showImg(x) {
        $(x).find('.showImgCard').toggleClass("d-none");
    }
</script>
</body>
</html>
