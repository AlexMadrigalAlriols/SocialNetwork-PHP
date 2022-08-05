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

    <div id="liveToast" class="toast bg-primary position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
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

    <div class="row">
        <div class="col-md-8">
            <div class="mt-3 bg-dark text-white rounded container">
                <h5 class="p-2">Publicate Something</h5>
                <form action="" class="justify-content-md-center" method="post" enctype="multipart/form-data">
                    <div class="input-group ms-3">   
                        <textarea class="form-control bg-dark text-white" data-emojiable="true" data-emoji-input="unicode" name="publication[publication_message]" id="publication_message" cols="2" rows="2" placeholder="I bought 4 Black Lotus..."></textarea>
                    </div>
                    <div id="imgContainer" class="d-none">
                        <button type="button" onclick="removeFile()" data-bs-dismiss="modal" aria-label="Close" style="background-color: transparent; color:white; border-style: none; position:relative;"><i class="fa-solid fa-xmark"></i></button>
                        <img id="output" src="" class="mt-3" style="width:10%; height:10%; border-radius: 15%;">
                    </div>
                    <input type="hidden" name="publication[id_user]" value="0<?=$_SESSION["iduser"];?>">
                    <input type="file" class="d-none" name="publication[publication_img]" id="publication_img" value="none" onchange="loadFile(event)">
                    <input type="hidden" name="publication[publication_deck]" value="0">
                    <input type="hidden" name="publication[publication_card]" value="0">
                    <div class="buttons mt-2">
                        <span>Insert:</span>
                        <button class="btn btn-dark-primary m-1 mb-2 d-inline-block" name="buttonImages" id="buttonImages" type="button"><i class="fa-regular fa-images"></i></button>
                        <button class="btn btn-dark-primary m-1 mb-2 d-inline-block" name="deck"><i class="fa-solid fa-box"></i></button>
                        <button class="btn btn-dark-primary m-1 mb-2 d-inline-block" name="cards"><i class="fa-solid fa-sd-card"></i></button>
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
                                        <li><a class="dropdown-item mt-1" href="#" role="button" onclick="sharePublication(<?=$publication['id_publication'];?>)"><i class="fa-solid fa-link"></i> Copy link</a></li>
                                        <form action="" method="post">
                                            <?php if($_SESSION["iduser"] == $publication["id_user"] || $user_details["admin"]) { ?>
                                                <li><button class="dropdown-item mt-1" href="#" style="color: red;"  name="commandDelete" type="submit" value="<?=$publication["id_publication"];?>"><i class="fa-regular fa-trash-can"></i> Delete Publication</button></li>
                                            <?php } ?>
                                            <li><button class="dropdown-item mt-1" href="#" style="color: red;"  name="commandReport" type="submit" value="<?=$publication["id_publication"];?>"><i class="fa-regular fa-flag"></i> Report Publication</button></li>
                                        </form>
                                        
                                    </ul>
                                </div>

                            </div>
                            
                            <div class="mt-3">
                                <p><?=$publication["publication_message"];?></p>
                                <?php if($publication["publication_img"] != "none") {?><img src="/cards/uploads/<?=$publication["publication_img"];?>" class="rounded app-open-publication" style="width: 100%; max-height: 400px;" onclick="openComments(<?= $publication['id_publication']; ?>)" role="button" tabindex="0"><?php } ?>
                            </div>

                            <div class="mt-2 ms-3" style="opacity: 60%;">
                                <div class="d-inline-block me-5">
                                    <button class="btn btn-dark <?php if(in_array($_SESSION["iduser"],json_decode($publication["publication_likes"],true))){?>active<?php } ?>" onclick='publicationLike(<?= $publication["id_publication"]; ?>)' id="like---<?=$publication["id_publication"];?>">
                                        <?php if(in_array($_SESSION["iduser"],json_decode($publication["publication_likes"],true))){?>
                                            <i class="fa-solid fa-heart d-inline-block" id="like-icon2---<?= $publication["id_publication"]; ?>"></i>
                                        <?php } else { ?>
                                            <i class="fa-regular fa-heart d-inline-block" id="like-icon---<?= $publication["id_publication"]; ?>"></i>
                                        <?php } ?>
                                        <span class="d-inline-bloc ms-2" id="likes-txt---<?=$publication["id_publication"]; ?>"><?=count(json_decode($publication["publication_likes"], true));?></span>
                                    </button>
                                </div>

                                <div class="d-inline-block me-5">
                                    <button class="btn btn-dark" onclick="openComments(<?= $publication['id_publication']; ?>)">
                                        <i class="fa-regular fa-comment d-inline-block"></i>
                                        <span class="d-inline-bloc ms-2"><?= publicationCommentService::getCommentCount($publication["id_publication"]); ?></span>
                                    </button>
                                </div>

                                <div class="d-inline-block">
                                    <button class="btn btn-dark" onclick="sharePublication(<?=$publication['id_publication'];?>)">
                                        <i class="fa-solid fa-share d-inline-block"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
                        <a class="btn btn-dark active w-100 mt-3" href="/profile/<?=$_SESSION["iduser"];?>">Ver perfil</a>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <form method="post" id="frm">
                            <p style="font-size:13px;"><b>New Accounts</b></p>
                            <?php foreach ($suggested_users as $idx => $user) { ?>
                                <?php if(!in_array($user["user_id"], json_decode($user_details["followed"],true)) && $user["user_id"] != $_SESSION["iduser"]) {?>
                                    <div class="mt-1 p-2">
                                        <img src="/<?=$user["profile_image"]?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                                        <span class="d-inline-block ms-2" style="font-size: 13px;"><b>@<?=$user["username"]?></b></span>
                                        <button class="d-inline-block mt-2 btn btn-dark" style="font-size: 12px; float:right; background-color: #141414;" name="commandFollowSuggested" type="submit" value="<?=$user["user_id"];?>"><b>Follow</b></button>
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

<div class="modal text-white" id="publicationModal" tabindex="-1" aria-labelledby="publicationModal" aria-hidden="true">
    <div class="modal-dialog bg-dark modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-body">
                <div class="row">
                    <!-- Header -->
                    <div class="col-md-12">
                        <a href="/profile/<?= $publications[0]["id_user"]; ?>" style="text-decoration: none;">
                            <div class="col-md-1 d-inline-block">
                                <img src="" class="rounded-circle" width="50px" height="50px" id="profile_img">
                            </div>
                        </a>
                        <div class="d-inline-block">
                            <div>
                                <a href="/profile/<?= $publications[0]["id_user"]; ?>" style="text-decoration: none;" class="d-inline-block">
                                    <span class="d-inline-block" style="font-size: 14px; color:White;"><b id="profile_name"></b></span> 
                                    <span class="text-muted d-inline-block" style="font-size: 12px;" id="profile_username"></span>
                                    <span class="text-muted d-inline-block" style="font-size: 12px;" id="passed_time"></span>
                                </a>
                            </div>
                        </div>

                        <div class="d-inline-block" style="float:right;">
                            <button type="button" class="" style="color:white; background-color: transparent; border-style: none; font-size: 18px;" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <!-- Publication -->
                    <div class="col-md-7">
                        <p id="publication_msg"></p>
                        <img src="" alt="" width="100%" id="publication_img_container" style="max-height: 900px;">
                        <div class="mt-2 container text-center" style="opacity: 60%;">
                            <div class="d-inline-block me-5">
                                <button class="btn btn-dark <?php if(in_array($_SESSION["iduser"],json_decode($publication["publication_likes"],true))){?>active<?php } ?>" onclick='publicationLike(<?= $publication["id_publication"]; ?>)' id="like---<?=$publication["id_publication"];?>">
                                    <?php if(in_array($_SESSION["iduser"],json_decode($publication["publication_likes"],true))){?>
                                        <i class="fa-solid fa-heart d-inline-block" id="like-icon2---<?= $publication["id_publication"]; ?>"></i>
                                    <?php } else { ?>
                                        <i class="fa-regular fa-heart d-inline-block" id="like-icon---<?= $publication["id_publication"]; ?>"></i>
                                    <?php } ?>
                                    <span class="d-inline-bloc ms-2" id="likes-txt---<?=$publications[0]["id_publication"]; ?>"><?=count(json_decode($publications[0]["publication_likes"], true));?></span>
                                </button>
                            </div>

                            <div class="d-inline-block me-5">
                                <button class="btn btn-dark">
                                    <i class="fa-regular fa-comment d-inline-block"></i>
                                    <span class="d-inline-bloc ms-2">23</span>
                                </button>
                            </div>

                            <div class="d-inline-block">
                                <button class="btn btn-dark">
                                    <i class="fa-solid fa-share d-inline-block"></i>
                                    <span class="d-inline-bloc ms-2">2</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <h4>Comments</h4>
                        <div id="comments" style="overflow-y: auto; height: 19rem;"></div>
                        <div>
                        <hr>
                            <div class="input-group mb-3">
                                <textarea class="form-control" placeholder="Comment Something" aria-label="Comment Something" aria-describedby="button-addon2" style="resize: none;" rows="1" id="comment_msg" data-emojiable="true" data-emoji-input="unicode"></textarea>
                                <button class="btn btn-secondary" type="button" id="button-submit-comment" value="<?=$publications[0]["id_publication"];?>">Publicate</button>
                                
                                <div class="invalid-feedback">
                                    Error on comment this publication.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $( document ).ready(function() {
        $("#Home").addClass('active');
        $('#buttonImages').click(function(){ $('#publication_img').trigger('click'); });

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

        <?php if(isset($publication_id)) { ?>
            openComments(<?=$publication_id;?>);
        <?php } ?>

        $('#button-submit-comment').click(function() {
            $.ajax({
                url: '/procesos/publications/commentPublication',
                type: 'POST',
                async: false,
                data: {id_publication: $(this).attr("value"), comment_message: $("#comment_msg").val()},
                success: function(data) {
                    if(data == 0){
                        $("#comment_msg").addClass("is-invalid");
                    } else {
                        window.location.href = "/publication/"+$("#button-submit-comment").attr("value");
                        refreshComments($("#button-submit-comment").attr("value"));
                    }
                }
            });
        });
    });   

    var loadFile = function(event) {
        var output = document.getElementById('output');
        $("#imgContainer").removeClass("d-none");
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };

    function removeFile(){
        $("#imgContainer").addClass("d-none");
        const file = document.querySelector('#publication_img');
        file.value = '';
    }

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

    function openComments(id_publication){
        $('#button-submit-comment').attr("value", id_publication);
        $.ajax({
            url: '/procesos/publications/getPublicationDetails',
            type: 'POST',
            async: false,
            data: {id_publication: id_publication},
            success: function(data) {
                if(data != 0){
                    $('#publicationModal').modal('show');
                    publication_details = JSON.parse(data);
                    $("#publication_msg").text(publication_details["publication_message"]);
                    if(publication_details["publication_img"] != "none"){
                        $("#publication_img_container").removeClass("d-none");
                        $("#publication_img_container").attr("src", "/cards/uploads/"+publication_details["publication_img"]);
                    } else {
                        $("#publication_img_container").addClass("d-none");
                    }
                    
                    $("#profile_img").attr("src", "/"+publication_details["profile_image"]);
                    $("#profile_name").text(publication_details["name"]);
                    $("#profile_username").text("@"+publication_details["username"] + " - ");
                    $("#passed_time").text(publication_details["passed_time"]);
                } else {
                    window.location.href = "/";
                }
            }
        });
        refreshComments(id_publication);
    }

    function refreshComments(id_publication){
        $.ajax({
            url: '/procesos/publications/getComments',
            type: 'POST',
            async: false,
            data: {id_publication: id_publication},
            success: function(data) {
                if(data){
                    results = JSON.parse(data);
                    $("#comments").empty();
                    results.forEach(comment => {
                        $("#comments").append('<div class="card bg-dark mb-2">'+
                                '<div class="card-body">'+
                                    '<a href="/profile/'+comment["id_user"]+'" style="text-decoration: none;">'+
                                        '<div class="col-md-2 d-inline-block">'+
                                            '<img src="/'+comment["profile_image"]+'" class="rounded-circle" width="35px" height="35px">'+
                                        '</div>'+
                                    '</a>'+
                                    '<div class="d-inline-block">'+
                                        '<div>'+
                                            '<a href="/profile/'+comment["id_user"]+'" style="text-decoration: none;" class="d-inline-block">'+
                                                '<span class="d-inline-block" style="font-size: 11px; color:White;"><b>'+comment["name"]+' </b></span>'+
                                                '<span class="text-muted" style="font-size: 10px;"> @'+comment["username"]+' - </span>'+
                                                '<span class="text-muted" style="font-size: 10px;"> '+comment["passed_time"]+'</span>'+
                                            '</a>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="mt-2" style="font-size: 13px;">'+
                                        comment["comment_message"]+
                                    '</div>'+
                                '</div>'+
                            '</div>');
                        
                    });
                }
            }
        });
    }

    function sharePublication($id_publication){
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = "<?=gc::getSetting("site.url");?>/publication/"+$id_publication; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
        $('.toast').toast('show');
    }
</script>
</body>
</html>
