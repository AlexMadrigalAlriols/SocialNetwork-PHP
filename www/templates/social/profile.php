
<!DOCTYPE html>
<html lang="en">
<?php require_once('header.php'); ?>
<?php require_once('cards/www/controllers/profile.php'); ?>
<body>
<?php require_once('home_navbar.php'); ?>
<div class="container mt-4">
<?php if(isset($_GET["error"])){?>
      <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
        <div>
            Error on upload your profile cover, try it with other image.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php } ?>
    <div class="mt-4 bg-dark text-white rounded">
        <div style="position:relative;">
            <img  src="/<?= ($user_profile_details["profile_cover"] ? $user_profile_details["profile_cover"] : "cards/uploads/profileCover.png"); ?>" alt="" style="width:100%; height:10rem; z-index: -1;">
            <?php if($user_id == $_SESSION["iduser"]) { ?>
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
                <?php if($user_id == $_SESSION["iduser"]){ ?>
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
                            <li><a class="dropdown-item" href="/profile/<?=$user_profile_details["user_id"];?>"><i class="fa-solid fa-share-nodes"></i> Share Profile</a></li>
                            <?php if (!in_array($user_id, json_decode($user_details["blocked_users"], true))) { ?>
                                <li><button class="dropdown-item" style="color: red;" name="command_block" value="1" type="submit"><i class="fa-solid fa-user-lock"></i> Block user</a></button>
                            <?php } else { ?>
                                <li><button class="dropdown-item" style="color: red;" name="command_unblock" value="1" type="submit"><i class="fa-solid fa-user-lock"></i> UnBlock user</a></button>
                            <?php } ?>
                            <li><a class="dropdown-item" href="#" style="color: red;"><i class="fa-solid fa-flag"></i> Report user</a></li>
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
                    <li class="nav-item ms-3" role="presentation">
                        <button class="btn btn-dark-primary" id="pills-lasttournaments-tab" data-bs-toggle="pill" data-bs-target="#lasttournaments" type="button" role="tab" aria-controls="lasttournaments" aria-selected="false">Last Tournaments</button>
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
                                                <a class="d-inline-block mt-1" style="font-size: 18px; float:right; color:white;" href="#"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                            </div>
                                            <div class="mt-3">
                                                <p><?=$publication["publication_message"];?></p>
                                                <?php if($publication["publication_img"] != "none"){?><img src="<?=($publication["publication_img"] != "none" ? "/cards/uploads/".$publication["publication_img"] : "");?>" class="rounded" style="width: 100%; rounded-border: 15%;"><?php } ?>
                                            </div>
                                            <div class="mt-2 ms-3" style="opacity: 60%;">
                                                <div class="d-inline-block me-5">
                                                    <button class="btn btn-dark <?php if(in_array($_SESSION["iduser"],json_decode($publication["publication_likes"],true))){?>active<?php } ?>" onclick='publicationLike(<?= $publication["id_publication"]; ?>)' id="like---<?=$publication["id_publication"];?>" >
                                                        <?php if(in_array($_SESSION["iduser"],json_decode($publication["publication_likes"],true))){?>
                                                            <i class="fa-solid fa-heart d-inline-block" id="like-icon2---<?= $publication["id_publication"]; ?>"></i>
                                                        <?php } else { ?>
                                                            <i class="fa-regular fa-heart d-inline-block" id="like-icon---<?= $publication["id_publication"]; ?>"></i>
                                                        <?php } ?>
                                                        <span class="d-inline-bloc ms-2" id="likes-txt---<?=$publication["id_publication"]; ?>"><?=count(json_decode($publication["publication_likes"], true));?></span>
                                                    </button>
                                                </div>

                                                <div class="d-inline-block me-5">
                                                    <button class="btn btn-dark" style="background-color: #1b1a1a; border-color: transparent;">
                                                        <i class="fa-regular fa-comment d-inline-block"></i>
                                                        <span class="d-inline-bloc ms-2">23</span>
                                                    </button>
                                                </div>

                                                <div class="d-inline-block">
                                                    <button class="btn btn-dark" style="background-color: #1b1a1a; border-color: transparent;">
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
                        <div class="row p-4">
                            <div class="card ms-2" style="width: 14rem; background-color: #1b1a1a;">
                                <img src="https://images.squarespace-cdn.com/content/v1/59309136ff7c50b2917d4985/1633299708682-MRK58XDLJJIX3NP5ENXU/OnlineStore_EventTicket_MtG_Modern_Tournament_MONDAYS_MHK.png?format=1000w" class="card-img-top mt-3 rounded" style="height: 150px;">
                                <div class="card-body" style="margin-left: -0.5rem;">
                                    <h6>Open Modern 2022</h6>
                                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-clock me-2"></i> 07/07/2022 - 10:00 PM</span>
                                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-users me-1"></i> 20/30 players</span>
                                    <span class="text-muted"><b style="font-size:20px; color:#4723D9;">20€</b>/player</span>
                                    <hr style="width: 100%;">
                                    <center><button class="btn btn-dark-primary active btn-block d-md-block" data-bs-toggle="modal" data-bs-target="#exampleModal">View Details</button></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="lasttournaments" role="tabpanel" aria-labelledby="pills-lasttournaments-tab" tabindex="0">
                <div class="container">
                        <div class="row p-4">
                            <div class="card ms-2" style="width: 14rem; background-color: #1b1a1a;">
                                <img src="https://images.squarespace-cdn.com/content/v1/59309136ff7c50b2917d4985/1633299708682-MRK58XDLJJIX3NP5ENXU/OnlineStore_EventTicket_MtG_Modern_Tournament_MONDAYS_MHK.png?format=1000w" class="card-img-top mt-3 rounded" style="height: 150px;">
                                <div class="card-body" style="margin-left: -0.5rem;">
                                    <h6>Open Modern 2022</h6>
                                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-clock me-2"></i> 07/07/2022</span> <br>
                                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-users me-1"></i> 30 Total players</span>
                                    <hr style="width: 100%;">
                                    <center><a href="" class="btn btn-dark-primary active btn-block d-md-block">View Details</a></center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modals -->
<div class="modal text-white" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Open Modern 2022</h5>
                <button type="button" class="btn-close" style="color:white;" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-dark-primary active">Sign up</button>
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
<script>
    function publicationLike($id_publication){
        $.ajax({
            url: '/procesos/publications/likePublication',
            type: 'POST',
            async: false,
            data: {user_id: <?=$_SESSION["iduser"];?>, id_publication: $id_publication},
            success: function(data) {
                if(data){
                    $("#like---"+$id_publication).toggleClass("active");
                    $("#likes-txt---"+$id_publication).empty();
                    $("#likes-txt---"+$id_publication).append(data);
                    $("#like-icon---"+$id_publication).toggleClass("fa-solid");
                    $("#like-icon---"+$id_publication).toggleClass("fa-regular");
                    $("#like-icon2---"+$id_publication).toggleClass("fa-solid");
                    $("#like-icon2---"+$id_publication).toggleClass("fa-regular");
                }
            }
        });
    }
</script>
</body>
</html>
