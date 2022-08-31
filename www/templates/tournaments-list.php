<!DOCTYPE html>
<html lang="en">

<?php require_once("cards/www/controllers/tournament-list.php"); ?>
<?php require_once('header.php'); ?>
<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

    <?php require_once('navControlPanel.php') ?>
<div style="position: relative;">
<?php if(isset($_GET["success"])) { ?>
    <?php if($_GET["success"] == "add") { ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="alert alert-success alert-dismissible"  style="margin-top: 5rem; margin-bottom: -5rem;" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg> Success Added To Tournaments <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    <?php } ?>
    <?php if($_GET["success"] == "remove") { ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="alert alert-success alert-dismissible"  style="margin-top: 5rem; margin-bottom: -5rem;" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg> Success Removed Of Tournaments <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    <?php } ?>
<?php } ?>
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

                        <div class="ms-3 col-md-4" style="margin-bottom: 20px;">
                            <label for="date" class="form-label">Min Date</label>
                            <input type="date" class="form-control" id="date" name="start_date" value="<?php if(isset($_GET["start_date"])){ echo $_GET["start_date"]; } ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-success m-2" style="float:right;">Search</button>
                        <a href="/tournaments/edit-tournament/0"><button type="button" class="btn btn-secondary m-2" style="float:right;">New Tournament</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container mb-3" id="searchedCards">
        <?php foreach ($tournaments as $idx => $tournament) { ?>
            <div class="card d-inline-block mt-4 ms-5" style="width: 18rem;">
                <div class="card-body">
                    <img src="<?=($tournament["image"] ? "/cards/uploads/".$tournament["image"] : "/cards/assets/img/placeholder.png")?>" class="card-img-top mt-3 rounded" style="height: 150px;" id="imgContainer">
                    <div class="card-body" style="margin-left: -0.5rem;">
                    <h6 id="nameTxt"><?=$tournament["name"];?></h6>
                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-cubes me-1"></i> <span id="formatTxt"><?=(isset($tournament["format"]) ? $tournament["format"] : "---")?></span></span><br>
                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-clock me-2"></i> <span id="dateTxt"><?=(isset($tournament["start_date"]) ? $tournament["start_date"] : date("d-m-y h:m"))?></span></span><br>
                    <span class="text-muted" style="font-size: 14px;"><i class="fa-solid fa-users me-1"></i> <span id="playersTxt"><?=(isset($tournament["max_players"]) ? count(json_decode($tournament["players"], true)) . "/" . $tournament["max_players"] : "30/30")?> players</span></span><br>
                    <span class="text-muted"><b style="font-size:20px; color:#7353f5;" id="priceTxt"><?=(isset($tournament["tournament_price"]) ? $tournament["tournament_price"] : "5")?>€</b>/player</span>
                    <hr style="width: 100%;">
                    <center>
                        <a class="btn btn-primary d-inline-block" href="/get-tournament-image/<?=$tournament["id_tournament"];?>"><i class="fa-solid fa-download"></i> Download</a>
                        <a class="btn btn-primary d-inline-block ms-2" href="/get-tournament-image/<?=$tournament["id_tournament"];?>"><i class="fa-solid fa-user"></i></a>
                        <a href="/tournaments/edit-tournament/<?=$tournament["id_tournament"];?>" class="btn btn-secondary d-inline-block ms-2"><i class="bx bxs-edit"></i></a>
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
            <a href='/tournaments/<?=$i?>?name=<?=(isset($_GET["name"]) ? $_GET["name"] : ""); ?>&format=<?=(isset($_GET["format"]) ? $_GET["format"] : ""); ?>&start_date=<?=(isset($_GET["start_date"]) ? $_GET["start_date"] : ""); ?>'><button class='btn <?= ($i == $id_page ? "btn-primary" : "btn-success") ?>' style='margin: 5px;'><?=$i + 1;?></button></a>
        <?php } ?>
    </div>
</div>
    
</body>

</html>

<script src="/cards/assets/js/headerControler.js"></script>

<script>

$( document ).ready(function() {
    $("#pager").toggleClass("d-none");

    $("#tournaments").addClass('active');

});
</script>