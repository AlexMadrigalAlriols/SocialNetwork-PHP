<!DOCTYPE html>
<html lang="en">
<?php require_once('header.php'); ?>
<body>
<?php require_once('cards/www/controllers/tournament-searcher.php'); ?>
<?php require_once('home_navbar.php'); ?>

<div class="container mb-5">

    <div class="row">
        <div class="col-md-8">
            <div class="mt-4 bg-dark text-white rounded container card">
                <div class="card-header">
                    <h3 class="mt-3"><i class="fa-solid fa-magnifying-glass"></i> <?=$user->i18n("tournament_searcher");?></h3>
                </div>
                <form method="POST">
                    <div class="row ms-2 me-2">
                        <div class="col-md-5 mt-2">
                            <div class="form-group">
                                <label for="info"><?=$user->i18n("ubication");?></label>
                                <input type="text" class="form-control" id="info" name="info" placeholder="<?=$user->i18n("tournament_ubication_help");?>" value="<?=(isset($_POST["info"]) ? $_POST["info"] : "")?>">
                            </div>
                        </div>

                        <div class="col-md-4 mt-2">
                            <div class="form-group">
                                <label for="country"><?=$user->i18n("format");?></label>
                                <select class="form-select" id="format" name="format">
                                    <option value="">------</option>
                                    <?php foreach ($formats as $idx => $value) { ?>
                                        <option value="<?=$value;?>" <?=(isset($_POST["format"]) && $_POST["format"] == $value ? "selected" : "")?>><?=$value;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mt-2">
                            <div class="form-group">
                                <label for="country"><?=$user->i18n("date");?></label>
                                <input type="date" class="form-control" id="date" name="date" min="<?=date("Y-m-d");?>" value="<?=(isset($_POST["date"]) ? $_POST["date"] : "")?>">
                            </div>
                        </div>
                    </div>

                    <p class="d-inline-block p-4 text-muted"><?=$user->i18n("filter_helper");?> (*)</p>
                    <button class="btn btn-dark-primary active my-4 d-inline-block pull-right addon-btn-filters" name="commandSearch" value="1"><i class="fa-solid fa-magnifying-glass"></i> <?=$user->i18n("search");?></button>
                </form>
            </div>

            <div class="row mt-4 mb-3" id="searched-tournaments">
                <?php foreach ($tournaments as $idx => $tournament) { ?>
                    <div class="card ms-5 tournament-card">
                        <img src="<?=($tournament["image"] != "" ? gc::getSetting("upload.img.path").$tournament["image"] : "/cards/assets/img/placeholder.png");?>" class="card-img-top mt-3 rounded" height="130px">
                        <div class="card-body">
                            <h6><?=$tournament["name"];?></h6>
                            <span class="text-muted f-14"><i class="fa-solid fa-location-dot"></i> <?=$tournament["ubication"];?></span><br>
                            <span class="text-muted f-14"><i class="fa-solid fa-gamepad"></i> <?=$tournament["format"];?></span><br>
                            <span class="text-muted f-14"><i class="fa-solid fa-clock me-2"></i> <?= date_format(date_create($tournament["start_date"]), "d/m/Y - H:i") ?></span><br>
                            <span class="text-muted f-14"><i class="fa-solid fa-users me-1"></i> Max. <?= $tournament["max_players"]; ?> <?=$user->i18n("players");?></span><br>
                            <span class="text-muted"><b class="f-20 text-purple"><?=$tournament["tournament_price"];?>€</b>/<?=$user->i18n("player");?></span>
                            <hr class="w-100">
                            <center><a href="/profile/@<?=$tournament["username"];?>"><button class="btn btn-dark-primary active d-inline-block w-100"><i class="fa-solid fa-shop"></i> <?=$user->i18n("view_site");?></button></a></center>
                        </div>
                    </div>
                <?php } ?>
                
                <?php if(!count($tournaments) && (isset($_POST["format"]) || isset($_POST["info"]) || isset($_POST["date"]))) { ?>
                    <div class="container text-center mb-3">
                        <div class="card bg-dark">
                            <div class="card-body">
                                <h2><?=$user->i18n("no_tournaments");?></h2>
                                <img src="/cards/assets/img/thraben_decks.png" class="mt-3 opacity-75" width="35%"><br>
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
</body>
<?php require_once('cards/www/templates/_footer.php'); ?>
<script>
    $( document ).ready(function() {
        $("#SearchTour").addClass('active');
    });  
</script>

</html>