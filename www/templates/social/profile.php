
<!DOCTYPE html>
<html lang="en">
<?php require_once('header.php'); ?>
<?php require_once('cards/www/controllers/profile.php'); ?>
<body>
<?php require_once('home_navbar.php'); ?>

<div class="container mt-4 mb-5">
    <?php require_once('cards/www/templates/_toast.php') ?>
    <div class="mt-4 bg-dark text-white rounded">
        <div class="position-relative">
            <img  src="/<?= ($user_profile_details["profile_cover"] ? $user_profile_details["profile_cover"] : "cards/assets/img/profileCover.png"); ?>" alt="" class="profile-cover">
            <?php if($user_id == $user->get("id_user")) { ?>
                <button class="btn btn-secondary btn-edit-cover" data-bs-toggle="modal" data-bs-target="#coverModal"><i class="fa-solid fa-pencil"></i>&nbsp;&nbsp;<?=$user->i18n("edit_cover");?></button>
            <?php } ?>
            <?php if(isset($user_profile_details["shop_config"]["cardmarket_link"]) && $user_profile_details["shop_config"]["cardmarket_link"]){ ?>
                <a href="<?= $user_profile_details["shop_config"]["cardmarket_link"];?>" class="btn btn-secondary btn-cardmarket p-0" target="_blank"><img src="https://static.cardmarket.com/img/75b96e78c35ea027396cde754c99f595/Downloads/Logos/CardmarketLogoWhite1.png" alt="" width="105"><i class="fa-solid fa-up-right-from-square me-2 f-12"></i></a>
            <?php } ?>
            <img class="rounded-circle profile-img" src="<?= $user_profile_details["profile_image"];?>" alt="profile image" referrerpolicy="no-referrer">
        </div>

        <div class="p-3 profile-box">
            <div class="d-inline-block profile-names">
                <h4><?= $user_profile_details["name"];?> <?php if(userService::checkIfAccountVerified($user_id)) { ?> <i class="fa-solid fa-certificate text-purple"  data-bs-toggle="tooltip" data-bs-title="Account Verified"></i> <?php } ?></h4>
                <p class="text-muted">@<?=$user_profile_details["username"];?></p>
            </div>

            <div class="d-inline-block text-center profile-counters">
                <div class="d-inline-block col-md me-4">
                    <h6><?=$user->i18n("publications");?></h6>
                    <span><center><?= count($publications); ?></center></span>
                </div>
                <div class="d-inline-block col-md me-4">
                    <h6><?=$user->i18n("followers");?></h6>
                    <span><center id="followers"><?= count(json_decode($user_profile_details["followers"], true)); ?></center></span>
                </div>

                <?php if(isset($user_profile_details["shop_config"]["shop"]) && $user_profile_details["shop_config"]["shop"]) { ?>
                    <div class="d-inline-block col-md">
                        <h6><?=$user->i18n("tournaments");?></h6>
                        <span><center><?=tournamentService::countShopTournaments($user_profile_details["user_id"]);?></center></span>
                    </div>
                <?php } ?>
            </div>

            <div class="d-inline-block profile-buttons">
                <?php if($user_id == $user->get("id_user")){ ?>
                    <a class="btn btn-dark-primary d-inline-block" href="/settings"><i class="fa-solid fa-pencil me-2"></i> <?=$user->i18n("edit_profile");?></a>
                <?php } else { ?>
                    <form action="" method="post" class="d-inline-block w-100">
                        <?php if($user_details && in_array($user_id, json_decode($user_details["followed"], true)) && in_array($user_id, json_decode($user_details["blocked_users"], true))) { ?>
                            <button class="btn btn-dark-primary d-inline-block" type="submit" name="command_unfollow" value="1"><?=$user->i18n("unfollow");?> <i class="fa-solid fa-heart-crack"></i></button>
                        
                            <?php } else if ($user_details && in_array($user_id, json_decode($user_details["blocked_users"], true))) { ?>
                            <button class="btn btn-dark-primary d-inline-block" type="submit" name="command_unblock" value="1"><?=$user->i18n("unblock");?> <i class="fa-solid fa-ban"></i></button>
                        
                        <?php } else { ?>
                            <button class="btn btn-dark-primary active d-inline-block" type="submit" name="command_follow" value="1"><?=$user->i18n("follow");?> <i class="fa-solid fa-plus"></i></button>
                        
                        <?php } ?>    

                        <a href="#" class="d-inline-block text-white f-30 align-middle ms-2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                        <ul class="dropdown-menu dropdown-profile animate slideIn" aria-labelledby="dropdownMenuButton1">
                            <li><a href="/messages/@<?=$user_profile_details["username"];?>" class="dropdown-item"><i class="fa-solid fa-inbox"></i> <?=$user->i18n("send_message");?></a></li>
                            <li><a class="dropdown-item" href="/profile/<?=$user_profile_details["user_id"];?>"><i class="fa-solid fa-share-nodes"></i> <?=$user->i18n("share_profile");?></a></li>
                            <?php if ($user_details && in_array($user_id, json_decode($user_details["blocked_users"], true))) { ?>
                                <li><button class="dropdown-item text-red" name="command_unblock" value="1" type="submit"><i class="fa-solid fa-user-lock"></i> <?=$user->i18n("unblock_user");?></a></button>
                            <?php } else { ?>
                                <li><button class="dropdown-item text-red" name="command_block" value="1" type="submit"><i class="fa-solid fa-user-lock"></i> <?=$user->i18n("block_user");?></a></button>
                            <?php } ?>
                            <li><button class="dropdown-item text-red" href="#" name="command_report" value="1" type="submit"><i class="fa-solid fa-flag"></i> <?=$user->i18n("report_user");?></button></li>
                        </ul>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="row container">
    <div class="mt-3 mb-3 me-5 bg-dark p-4 text-white rounded col-md-4 h-50">
            <h4><?=$user->i18n("biography");?></h4>
            <div>
                <p><?=$user_profile_details["biography"]; ?></p>
            </div>
            <hr>
            <div>
                <?php if(isset($user_profile_details["ubication"]) && $user_profile_details["ubication"]) { ?>
                    <h6><i class="fa-solid fa-location-dot"></i> <?=$user->i18n("ubication");?></h6>
                <?php } ?>
                <p class="text-muted"><?=$user_profile_details["ubication"];?></p>
                
                <?php if(isset($user_profile_details["links"]["website"]) && $user_profile_details["links"]["website"]) { ?>
                    <h6><i class="fa-solid fa-globe"></i> Website</h6>
                    <p><a href="<?=$user_profile_details["links"]["website"];?>"><?=$user_profile_details["links"]["website"];?></a></p>
                <?php } ?>
                <?php if((isset($user_profile_details["links"]["twitter"]) && $user_profile_details["links"]["twitter"]) || (isset($user_profile_details["links"]["instagram"]) && $user_profile_details["links"]["instagram"]) || (isset($user_profile_details["links"]["discord"]) && $user_profile_details["links"]["discord"])) { ?>
                    <h5><?=$user->i18n("social_networks");?></h5>
                <?php } ?>
                <?php if(isset($user_profile_details["links"]["twitter"]) && $user_profile_details["links"]["twitter"]) { ?>
                    <h6><i class="fa-brands fa-twitter"></i> Twitter</h6>
                    <a href="https://twitter.com/<?=$user_profile_details["links"]["twitter"];?>" target="_blank"><p class="text-muted"><?=$user_profile_details["links"]["twitter"];?></p></a>
                <?php } ?>

                <?php if(isset($user_profile_details["links"]["instagram"]) && $user_profile_details["links"]["instagram"]) { ?>
                    <h6><i class="fa-brands fa-instagram"></i> Instagram</h6>
                    <a href="https://www.instagram.com/<?=$user_profile_details["links"]["instagram"];?>" target="_blank"><p class="text-muted">@<?=$user_profile_details["links"]["instagram"];?></p></a>
                <?php } ?>

                <?php if(isset($user_profile_details["links"]["discord"]) && $user_profile_details["links"]["discord"]) { ?>
                    <h6><i class="fa-brands fa-discord"></i> Discord</h6>
                    <p class="text-muted"><?=$user_profile_details["links"]["discord"];?></p>
                <?php } ?>
            </div>
            <hr>
            <div id="badges" class="mt-4">
                <div class="mb-2">
                    <span class="h5 me-2"><?=$user->i18n("badges");?></span> 
                    <a class="text-muted align-top f-14" href="/badges/@<?=$user_profile_details["username"];?>"><?=$user->i18n("all_badges");?></a>
                </div>

                <div class="user-badges">
                    <?php foreach ($user_profile_details["badges"] as $name => $badge) { ?>
                        <div class="d-inline-block m-2" 
                                data-bs-toggle="tooltip" 
                                data-bs-html="true" 
                                data-bs-placement="bottom" 
                                data-bs-title="<b><?=$user->i18n("badge.".$name);?></b></br> 
                                <span><i>Rarity: <?=$user->i18n("badge.rarity.".$badge["rarity"]);;?></span></i></br>
                                <span><?=$badge["description"];?>!</span>">
                            <img src="<?=(file_exists('cards/assets/img/badges/'.$name.'.png') ? '/cards/assets/img/badges/'.$name.'.png' : '/cards/assets/img/badges/webbed.svg')?>" alt="" width="75">
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="mt-3 mb-2 profile-publications-container bg-dark text-white rounded col-md-7">
            <ul class="nav nav-pills mb-3 p-4" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="btn btn-dark-primary active" id="pills-publications-tab" data-bs-toggle="pill" data-bs-target="#publications" type="button" role="tab" aria-controls="publications" aria-selected="true"><?=$user->i18n("publications");?></button>
                </li>
                <?php if(isset($user_profile_details["shop_config"]["shop"]) && $user_profile_details["shop_config"]["shop"]){ ?>
                    <li class="nav-item ms-3" role="presentation">
                    <button class="btn btn-dark-primary" id="pills-tournaments-tab" data-bs-toggle="pill" data-bs-target="#tournaments" type="button" role="tab" aria-controls="tournaments" aria-selected="false"><?=$user->i18n("tournaments");?></button>
                    </li>
                <?php } ?>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active col-md-12" id="publications" role="tabpanel" aria-labelledby="pills-publications-tab" tabindex="0">
                    <div class="container publi-container">
                        <div class="row">
                            <?php if(!count($publications)) {?>
                                <div class="container text-center" id="cardsNoFound">
                                    <div class="bg-none">
                                        <div class="">
                                            <img src="/cards/assets/img/no_publications_img.png" class="mt-1 opacity-75" width="45%">
                                            <h2 class="mt-4"><?=$user->i18n("no_publications");?></h2>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php foreach ($publications as $idx => $publication) { ?>
                                <div class="card ms-2 mt-2 profile-publications">
                                    <div class="card-body">
                                        <div class="col-md-2 d-inline-block">
                                            <img src="<?=$user_profile_details["profile_image"]; ?>" class="rounded-circle" width="50px" height="50px" referrerpolicy="no-referrer">
                                        </div>
                                        <div class="col-md-9 d-inline-block align-top">
                                            <div>
                                                <span class="d-inline-block f-14"><b><?=$user_profile_details["name"]; ?> <?php if(userService::checkIfAccountVerified($user_id)) { ?> <i class="fa-solid fa-certificate text-purple"></i> <?php } ?></b></span>
                                                <span class="text-muted d-inline-block f-12">@<?=$user_profile_details["username"]; ?> - </span>
                                                <span class="text-muted d-inline-block f-12"><span class="text-muted d-inline-block f-12"><?=fwTime::getPassedTime($publication["publication_date"]);?></span></span>
                                                <div class="dropdown">
                                                    <a class="d-inline-block mt-2 f-18 pull-right text-white" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
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
                                                <a href="/publication/<?=$publication["id_publication"];?>"  class="text-white text-decoration-none">
                                                    <p><?=$publication["publication_message"];?></p>
                                                    <?php if($publication["publication_img"] != "none"){?>
                                                        <a href="/publication/<?= $publication['id_publication']; ?>">
                                                            <img src="<?=($publication["publication_img"] != "none" ? "/cards/uploads/".$publication["publication_img"] : "");?>" class="rounded w-100">
                                                        </a>
                                                    <?php } ?>
                                                </a>
                                            </div>
                                            <?php if($publication["publication_deck"]) { ?>
                                                <div class="inserted-deck-box ms-0" id="insert-deck-box">
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
                                                    <a href="/deck/<?=$publication["publication_deck"];?>" class="btn btn-dark-primary active text-white m-3"><i class="fa-regular fa-eye me-2"></i> <?=$user->i18n("view_deck");?></a>
                                                </div>
                                            <?php } ?>
                                            <div class="mt-2 ms-3 opacity-75">
                                                <div class="d-inline-block me-4">
                                                    <button class="btn btn-dark btn-actions-profile" onclick='publicationLike(<?= $publication["id_publication"]; ?>)' id="like---<?=$publication["id_publication"];?>">
                                                        <?php if(in_array($user->get("id_user"),json_decode($publication["publication_likes"],true))){?>
                                                            <i class="fa-solid fa-heart d-inline-block" id="like-icon2---<?= $publication["id_publication"]; ?>"></i>
                                                        <?php } else { ?>
                                                            <i class="fa-regular fa-heart d-inline-block" id="like-icon---<?= $publication["id_publication"]; ?>"></i>
                                                        <?php } ?>
                                                        <span class="d-inline-bloc ms-2" id="likes-txt---<?=$publication["id_publication"]; ?>"><?=count(json_decode($publication["publication_likes"], true));?></span>
                                                    </button>
                                                </div>


                                                <div class="d-inline-block me-4">
                                                    <a class="btn btn-dark btn-actions-profile" href="/publication/<?= $publication['id_publication']; ?>">
                                                        <i class="fa-regular fa-comment d-inline-block"></i>
                                                        <span class="d-inline-bloc ms-2"><?= publicationCommentService::getCommentCount($publication["id_publication"]); ?></span>
                                                    </a>
                                                </div>

                                                <div class="d-inline-block">
                                                    <button class="btn btn-dark btn-actions-profile" onclick="sharePublication(<?=$publication['id_publication'];?>, '<?= gc::getSetting('site.url'); ?>')">
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
                <?php if(isset($user_profile_details["shop_config"]["shop"]) && $user_profile_details["shop_config"]["shop"]) { ?>
                    <div class="tab-pane fade" id="tournaments" role="tabpanel" aria-labelledby="pills-tournaments-tab" tabindex="0">
                        <div class="container">
                            <div class="row m-auto">
                                <?php if($tournaments && count($tournaments)) { ?>
                                    <?php foreach ($tournaments as $idx => $tournament) { ?>
                                        <div class="card ms-2 m-auto mt-4 tournament-card tournament-profile-card">
                                            <img src="<?=($tournament["image"] ? "/cards/uploads/".$tournament["image"] : "/cards/assets/img/placeholder.png");?>" class="card-img-top mt-3 rounded tournament-img">
                                            <div class="card-body">
                                                <h6><?= $tournament["name"]; ?></h6>
                                                <span class="text-muted f-14"><i class="fa-solid fa-clock me-2"></i> <?= date_format(date_create($tournament["start_date"]), "d/m/Y - H:i") ?></span><br>
                                                <span class="text-muted f-14"><i class="fa-solid fa-users me-1"></i> <?= $tournament["max_players"]; ?> <?=$user->i18n("players");?></span><br>
                                                <span class="text-muted"><b class="f-20 text-purple"><?=$tournament["tournament_price"];?><?=gc::getSetting("currencies")[$user_profile_details["shop_config"]["shop_currency"]];?></b>/<?=$user->i18n("player");?></span>
                                                <hr class="w-100">
                                                <center><button class="btn btn-dark-primary active btn-block d-md-block w-100" onclick="viewTournamentDetails(this)" data-id="<?=$tournament["id_tournament"];?>"><?=$user->i18n("view_details");?></button></center>
                                            </div>
                                        </div>
                                    <?php }
                                } ?>
                                <?php if(!$tournaments) { ?>
                                    <div class="container text-center mt-3" id="cardsNoFound">
                                        <div class="bg-none">
                                            <div class="">
                                                <img src="/cards/assets/img/no_tournaments_img.png" class="mt-3 opacity-75" width="65%">
                                                <h2 class="mt-3"><?= $user->i18n("no_tournaments_found");?></h2>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>

<!-- Modals -->
<div class="modal text-white" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title"><?=$user->i18n("tournament_details");?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="tournament_image" src="/cards/assets/img/placeholder.png" class="card-img-top mt-3 rounded tournament-img">
                            <div class="card-body">
                                <h6 id="tournament_name">undefined</h6>
                                <span class="text-muted f-14"><i class="fa-solid fa-clock me-2"></i> <span id="tournament_date">07/07/2022 - 10:00 PM</span></span><br>
                                <span class="text-muted f-14"><i class="fa-solid fa-users me-1"></i> <span id="tournament_players">5/80</span> <?=$user->i18n("players")?></span><br>
                                <span class="text-muted"><b class="f-20 text-purple" id="tournament_price">30$</b>/<?=$user->i18n("player")?></span>
                                <hr class="w-100">
                                <form method="POST">
                                    <center><a class="btn btn-dark-primary active btn-block d-md-block w-100" href="/messages/@<?=$user_details["username"];?>"><i class="fa-regular fa-message"></i> <?=$user->i18n("send_message");?></a></center>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h3><?=$user->i18n("details")?></h3>
                            <p class="text-muted" id="tournament_description">No description found.</p>
                            <h3><?=$user->i18n("prices")?></h3>
                            <div class="row" id="pricesContainer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal text-white" id="coverModal" tabindex="-1" aria-labelledby="coverModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark">
        <div class="modal-content bg-dark">
            <form method="post" id="frm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title"><?=$user->i18n("edit_user_cover");?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6><?=$user->i18n("actual_cover");?>:</h6>
                    <img class="mb-3" src="/<?= ($user_profile_details["profile_cover"] ? $user_profile_details["profile_cover"] : "cards/assets/img/profileCover.png"); ?>" alt="" width="100%" height="75px">
                    <h6><?=$user->i18n("upload_new_cover");?>:</h6>
                    <input type="file" class="form-control" name="profile[newProfileCover]" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$user->i18n("close");?></button>
                    <button type="submit" class="btn btn-dark-primary active" name="commandUploadCover" value="1"><?=$user->i18n("update_cover");?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/cards/assets/js/globalController.js"></script>
<script>
    $( document ).ready(function() {
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        <?php if(isset($_GET["report"])) { ?>
            $('#reported').toast('show');
        <?php } ?>

        <?php if(isset($_GET["deleted"])) { ?>
            $('#deleted').toast('show');
        <?php } ?>

        <?php if(isset($_GET["error"])){?>
            $("#uploadError").toast('show');
        <?php } ?>

        <?php if(isset($_GET["reported"])){?>
            $("#reportUser").toast('show');
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
                $("#tournament_players").text(tournament.max_players);
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
                            '<a onmouseenter="showImg(this)"'; 
                        if(card.id) {
                            html += 'href="/card/'+card.id+'"';
                        }
                        
                        html += ' onmouseleave="showImg(this)" class="text-white">- '+card.qty+'x '+card.name;

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

                                    html += '<div class="showImgCard d-none">'+
                                        '<img src="'+cards.Img+'" width="225">'+
                                    '</div>';
                                }
                            });
                        }

                        html += '</br></a></div>';
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
<?php require_once('cards/www/templates/_footer.php'); ?>
</body>

</html>
