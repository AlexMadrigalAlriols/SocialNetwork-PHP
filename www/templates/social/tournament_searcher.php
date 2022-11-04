<!DOCTYPE html>
<html lang="en">
<?php require_once('header.php'); ?>
<body>
<?php require_once('cards/www/controllers/tournament-searcher.php'); ?>
<?php require_once('home_navbar.php'); ?>

<div class="container mb-5">
    <h3 class="mt-3"><i class="fa-solid fa-magnifying-glass"></i> <?=$user->i18n("tournament_searcher");?></h3>
    <div class="row">
        <div class="mt-4 bg-dark text-white rounded container">
            <h5 class="m-3"><i class="fa-solid fa-filter"></i> <?=$user->i18n("filters");?></h5>
            <form method="POST">
                <div class="row ms-2 me-2">
                    <div class="col-sm-6 mt-2">
                        <div class="form-group">
                            <label for="info"><?=$user->i18n("ubication");?></label>
                            <input type="text" class="form-control" id="info" name="info" placeholder="<?=$user->i18n("tournament_ubication_help");?>">
                        </div>
                    </div>

                    <div class="col-sm-4 mt-2">
                        <div class="form-group">
                            <label for="country"><?=$user->i18n("format");?></label>
                            <select class="form-select" id="format" name="format">
                                <option value="">------</option>
                                <?php foreach ($formats as $idx => $value) { ?>
                                    <option value="<?=$value;?>" <?=(isset($_GET["format"]) && $_GET["format"] == $value ? "selected" : "")?>><?=$value;?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2 mt-2">
                        <div class="form-group">
                            <label for="country"><?=$user->i18n("date");?></label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                    </div>
                </div>

                <p class="d-inline-block m-3 text-muted"><?=$user->i18n("filter_helper");?> (*)</p>
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
                        <span class="text-muted f-14"><i class="fa-solid fa-users me-1"></i> <?= count(json_decode($tournament["players"], true)); ?>/<?= $tournament["max_players"]; ?> <?=$user->i18n("players");?></span><br>
                        <span class="text-muted"><b class="f-20 text-purple"><?=$tournament["tournament_price"];?>€</b>/<?=$user->i18n("player");?></span>
                        <hr class="w-100">
                        <center><a href="/profile/<?=$tournament["id_user"];?>"><button class="btn btn-dark-primary active d-inline-block w-100"><i class="fa-solid fa-shop"></i> <?=$user->i18n("view_site");?></button></a></center>
                    </div>
                </div>
            <?php } ?>            
        </div>
    </div>
</div>
</body>

<script>
    $( document ).ready(function() {
        $("#SearchTour").addClass('active');

        locate();
    });  

    function locate() {
        navigator.geolocation.getCurrentPosition(success, error);
        function success(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;

            $.getJSON("https://api.opencagedata.com/geocode/v1/json?q="+latitude+"+"+longitude+"&key=604b367e1bd34ca29e5df3b3e76eefe3", function(data) {
                console.log(data);
            });
        }

        function error(){

        }
    }
</script>
</html>