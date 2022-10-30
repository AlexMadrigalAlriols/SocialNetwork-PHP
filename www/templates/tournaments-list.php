<!DOCTYPE html>
<html lang="en">

<?php require_once("cards/www/controllers/tournament-list.php"); ?>
<?php require_once('header.php'); ?>
<body id="body-pd" class="body-pd overflow-x-hidden">
<?php 
    require_once('navControlPanel.php');
    $shop_config = json_decode($user_details["shop_config"], true);
?>
<div class="position-relative">
<?php require_once('_toast.php') ?>

<div class="card mb-3 filterBox">
        <div class="card-header">
            <h6><i class="fa-solid fa-filter"></i> <?=$user->i18n("tournaments_filter");?></h6>
        </div>

        <div class="card-body">
            <div class="row px-4">
                <form>
                    <div class="input-group">
                        <div class="me-3 col-md-4 addon-btn-filters">
                            <label for="name" class="form-label"><?=$user->i18n("tournament_name");?></label>
                            <input type="text" class="form-control " id="name" placeholder="Ex. Saturday Modern" name="name" value="<?php if(isset($_GET["name"])){ echo $_GET["name"]; } ?>">
                        </div>

                        <div class="me-3 col-lg-3 addon-btn-filters">
                            <label for="format" class="form-label"><?=$user->i18n("format");?></label>
                            <select class="form-select" id="format" name="format">
                                <option value="">------</option>
                                <?php foreach ($formats as $idx => $value) { ?>
                                    <option value="<?=$value;?>" <?=(isset($_GET["format"]) && $_GET["format"] == $value ? "selected" : "")?>><?=$value;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="me-3 col-md-4 mb-2 addon-btn-filters">
                            <label for="date" class="form-label"><?=$user->i18n("min_date");?></label>
                            <input type="date" class="form-control" id="date" name="start_date" value="<?php if(isset($_GET["start_date"])){ echo $_GET["start_date"]; } ?>">
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-success m-2 pull-right addon-btn-filters"><i class="fa-solid fa-magnifying-glass me-2"></i> <?=$user->i18n("search");?></button>
                        <a href="/tournaments/edit-tournament/0"><button type="button" class="btn btn-secondary m-2 pull-right addon-btn-filters"><i class="fa-solid fa-plus me-2"></i> <?=$user->i18n("new_tournament");?></button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mb-3 px-0" id="searchedCards">
        <?php foreach ($tournaments as $idx => $tournament) { ?>
            <div class="card d-inline-block mt-4 deck-card card-tournaments">
                <div class="card-body">
                    <img src="<?=($tournament["image"] ? "/cards/uploads/".$tournament["image"] : "/cards/assets/img/placeholder.png")?>" class="card-img-top mt-3 rounded tournament-img" id="imgContainer">
                    <div class="card-body">
                    <h6 id="nameTxt"><?=$tournament["name"];?></h6>
                    <span class="text-muted f-14"><i class="fa-solid fa-cubes me-1"></i> <span id="formatTxt"><?=(isset($tournament["format"]) ? $tournament["format"] : "---")?></span></span><br>
                    <span class="text-muted f-14"><i class="fa-solid fa-clock me-2"></i> <span id="dateTxt"><?=(isset($tournament["start_date"]) ? $tournament["start_date"] : date("d-m-y h:m"))?></span></span><br>
                    <span class="text-muted f-14"><i class="fa-solid fa-users me-1"></i> <span id="playersTxt"><?=(isset($tournament["max_players"]) ? count(json_decode($tournament["players"], true)) . "/" . $tournament["max_players"] : "30/30")?> <?=$user->i18n("players");?></span></span><br>
                    <span class="text-muted"><b class="f-20 text-purple-light" id="priceTxt"><?=(isset($tournament["tournament_price"]) ? $tournament["tournament_price"] : "5")?><?=gc::getSetting("currencies")[$user_details["shop_currency"]];?></b>/<?=$user->i18n("player");?></span>
                    <hr class="w-100">
                    <center>
                        <!--  href="/get-tournament-image/<?=$tournament["id_tournament"];?>"  -->
                        <a class="btn btn-primary d-inline-block addon-btn-filters download" data-id="<?=$tournament["id_tournament"];?>"><i class="fa-solid fa-download"></i> <?=$user->i18n("download");?></a>
                        <a href="/tournaments/edit-tournament/<?=$tournament["id_tournament"];?>" class="btn btn-secondary d-inline-block ms-1"><i class="bx bxs-edit"></i></a>
                        <form method="POST" class="d-inline-block">
                            <button class="btn btn-danger d-inline-block ms-1" name="commandDelete" value="<?=$tournament["id_tournament"];?>" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                    </center>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <?php if(!count($tournaments)) { ?>
        <div class="container text-center" id="tournamentNotFound">
            <div class="card">
                <div class="card-body">
                    <h1><?=$user->i18n("no_tournaments_yet");?></h1>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="container text-center d-none mb-3" id="pager">
        <?php for ($i=0; $i < $pages; $i++) { ?>
            <a href='/tournaments/<?=$i?>?name=<?=(isset($_GET["name"]) ? $_GET["name"] : ""); ?>&format=<?=(isset($_GET["format"]) ? $_GET["format"] : ""); ?>&start_date=<?=(isset($_GET["start_date"]) ? $_GET["start_date"] : ""); ?>'><button class='btn <?= ($i == $id_page ? "btn-primary" : "btn-success") ?>' class="m-2"><?=$i + 1;?></button></a>
        <?php } ?>
    </div>
</div>
<div class="modal text-white" id="coverModal" tabindex="-1" aria-labelledby="coverModalLabel" aria-hidden="true">
    <div class="modal-dialog bg-dark">
        <div class="modal-content bg-dark">
            <form method="post" id="frm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title"><?=$user->i18n("edit_tournament_img");?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6><?=$user->i18n("actual_background");?>:</h6>
                    <img class="mb-3" id="output" src="/cards/assets/img/Windswept-Heath-MtG-Art.jpg" alt="" width="300px" height="200px">
                    <h6>Colors:</h6>
                    <div class="form-group">
                        <label for="first_color" class="mt-3"><?= $user->i18n("principal_color"); ?></label><br>
                        <small class="text-muted"><?= $user->i18n("first_color_help"); ?></small><br>
                        <input type="color" class="mt-2" name="pcolor" value="<?=(isset($shop_config["principal_color"]) ? $shop_config["principal_color"] : "#55566a");?>">
                    </div>

                    <div class="form-group mb-3">
                        <label for="secondary_color" class="mt-3"><?= $user->i18n("secondary_color"); ?></label><br>
                        <small class="text-muted mb-2"><?= $user->i18n("second_color_help"); ?></small><br>
                        <input type="color" class="mt-2" name="scolor" value="<?=(isset($shop_config["secondary_color"]) ? $shop_config["secondary_color"] : "#ffffff");?>">
                    </div>
                    
                    <h6><?=$user->i18n("upload_new_background");?>:</h6>
                    <input type="file" class="form-control" name="profile[newProfileCover]" onchange="loadFile(event)">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$user->i18n("close");?></button>
                    <button type="submit" class="btn btn-primary" id="uploadCover" name="commandUploadCover" value="1"><i class="fa-solid fa-download me-1"></i> <?=$user->i18n("download");?></button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>

</html>

<script src="/cards/assets/js/headerControler.js"></script>

<script>

$( document ).ready(function() {
    $("#pager").toggleClass("d-none");

    <?php if(isset($_GET["success"])) { ?>
        <?php if($_GET["success"] == "add") { ?>
            $('#tournamentAdd').toast('show');
        <?php } ?>
        <?php if($_GET["success"] == "remove") { ?>
           $("#tournamentRemove").toast('show');
        <?php } ?>
    <?php } ?>

    <?php if(isset($_GET["error"])) { ?>
        $("#uploadSize").toast("show");
    <?php } ?>

    $("#tournaments").addClass('active');

    $(".download").click(function() {
        $('#uploadCover').attr('value', $(this).data("id"));
        $('#coverModal').modal('show');
    });

});

var loadFile = function(event) {
    var output = document.getElementById('output');
    $("#imgContainer").removeClass("d-none");
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
        URL.revokeObjectURL(output.src);
    }
};
</script>