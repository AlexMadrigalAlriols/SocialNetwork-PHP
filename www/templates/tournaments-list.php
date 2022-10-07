<!DOCTYPE html>
<html lang="en">

<?php require_once("cards/www/controllers/tournament-list.php"); ?>
<?php require_once('header.php'); ?>
<body id="body-pd" class="body-pd overflow-x-hidden">

    <?php require_once('navControlPanel.php') ?>
<div class="position-relative">


<div id="tournamentAdd" class="toast bg-success position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            <?=$user->i18n("success_add_tournament");?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
    
<div id="tournamentRemove" class="toast bg-success position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            <?=$user->i18n("success_remove_tournament");?>
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
<div class="card mb-3 filterBox">
        <div class="card-header">
            <h6>Decks Filter</h6>
        </div>

        <div class="card-body">
            <div class="row px-4">
                <form>
                    <div class="input-group">
                        <div class="ms-3 col-md-4">
                            <label for="name" class="form-label">Tournament Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Ex. Saturday Modern" name="name" value="<?php if(isset($_GET["name"])){ echo $_GET["name"]; } ?>">
                        </div>

                        <div class="ms-3 col-lg-3">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-select" id="format" name="format">
                                <option value="">------</option>
                                <?php foreach ($formats as $idx => $value) { ?>
                                    <option value="<?=$value;?>" <?=(isset($_GET["format"]) && $_GET["format"] == $value ? "selected" : "")?>><?=$value;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="ms-3 col-md-4 mb-2">
                            <label for="date" class="form-label">Min Date</label>
                            <input type="date" class="form-control" id="date" name="start_date" value="<?php if(isset($_GET["start_date"])){ echo $_GET["start_date"]; } ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success m-2 pull-right">Search</button>
                        <a href="/tournaments/edit-tournament/0"><button type="button" class="btn btn-secondary m-2 pull-right">New Tournament</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mb-3" id="searchedCards">
        <?php foreach ($tournaments as $idx => $tournament) { ?>
            <div class="card d-inline-block mt-4 ms-5 card-tournaments">
                <div class="card-body">
                    <img src="<?=($tournament["image"] ? "/cards/uploads/".$tournament["image"] : "/cards/assets/img/placeholder.png")?>" class="card-img-top mt-3 rounded tournament-img" id="imgContainer">
                    <div class="card-body">
                    <h6 id="nameTxt"><?=$tournament["name"];?></h6>
                    <span class="text-muted f-14"><i class="fa-solid fa-cubes me-1"></i> <span id="formatTxt"><?=(isset($tournament["format"]) ? $tournament["format"] : "---")?></span></span><br>
                    <span class="text-muted f-14"><i class="fa-solid fa-clock me-2"></i> <span id="dateTxt"><?=(isset($tournament["start_date"]) ? $tournament["start_date"] : date("d-m-y h:m"))?></span></span><br>
                    <span class="text-muted f-14"><i class="fa-solid fa-users me-1"></i> <span id="playersTxt"><?=(isset($tournament["max_players"]) ? count(json_decode($tournament["players"], true)) . "/" . $tournament["max_players"] : "30/30")?> players</span></span><br>
                    <span class="text-muted"><b class="f-20 text-purple-light" id="priceTxt"><?=(isset($tournament["tournament_price"]) ? $tournament["tournament_price"] : "5")?><?=gc::getSetting("currencies")[$user_details["shop_currency"]];?></b>/player</span>
                    <hr class="w-100">
                    <center>
                        <!--  href="/get-tournament-image/<?=$tournament["id_tournament"];?>"  -->
                        <a class="btn btn-primary d-inline-block" data-bs-toggle="modal" data-bs-target="#coverModal"><i class="fa-solid fa-download"></i> Download</a>
                        <form method="POST" class="d-inline-block">
                            <button class="btn btn-danger d-inline-block ms-1" name="commandDelete" value="<?=$tournament["id_tournament"];?>" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                        </form>
                        <a href="/tournaments/edit-tournament/<?=$tournament["id_tournament"];?>" class="btn btn-secondary d-inline-block ms-1"><i class="bx bxs-edit"></i></a>
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
                    <h1>No Tournaments Found</h1>
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
                    <h5 class="modal-title">Edit Background Tournament Image</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Actual Background:</h6>
                    <img class="mb-3" src="/cards/assets/img/Windswept-Heath-MtG-Art.jpg" alt="" width="250px" height="250px">
                    <h6>Upload new background:</h6>
                    <input type="file" class="form-control" name="profile[newProfileCover]" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="commandUploadCover" value="1">Download Image</button>
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

    $("#tournaments").addClass('active');

});
</script>