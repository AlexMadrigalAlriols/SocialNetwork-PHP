<!DOCTYPE html>
<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $user_details = userService::getUserDetails($user->get("id_user"));
    $shop_config = json_decode($user_details["shop_config"], true);

    $tournament = tournamentService::getTournamentById($id_tournament);
    $background = (isset($_GET["img"]) && $_GET["img"] != "" ?  '/' . gc::getSetting("upload.img.path") . $_GET["img"] : '/cards/assets/img/Windswept-Heath-MtG-Art.jpg');

    $primary_color = (isset($_GET["pcolor"]) && $_GET["pcolor"] != "" ? $_GET["pcolor"] : "#55566a");
    $secondary_color = (isset($_GET["scolor"]) && $_GET["scolor"] != "" ? $_GET["scolor"] : "#ffffff");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTGCollectioner Imager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
</head>
<style>

#my-node {
    width: 1280px !important; 
    height: 720px !important; 
    font-family: 'Work Sans', sans-serif;
	background-image: url(<?=$background; ?>);
	background-size: cover;
	background-repeat: no-repeat;
}

.right {
    position: absolute;
    left: 0;
    top: 0;
    -webkit-clip-path: polygon(60% 0, 100% 0%, 100% 100%, 40% 100%);
    clip-path: polygon(60% 0, 100% 0%, 100% 100%, 40% 100%);
    width: 1280px !important; 
    height: 720px !important;
}

.right .content {
    padding: 2rem;
    color: white;
    float: right !important;
    margin-left: 46rem !important; 
}

.left {
    position: absolute;
    left: 0;
    top: 0;
    background: radial-gradient(at 0% 0%, <?= $primary_color; ?> 30%, #282834);
    width: 1280px;
    height: 720px;
    -webkit-clip-path: polygon(0 0, 60% 0, 40% 100%, 0 100%);
    clip-path: polygon(0 0, 60% 0, 40% 100%, 0 100%);
	opacity: 85%;
}

.left .content {
    padding: 2rem;
    color: <?= $secondary_color; ?>;
}

.shop-logo{
    position: absolute;
    right: 20px;
    bottom: 20px;
    width: 75px;
}

</style>
<body>
    <div id="my-node">
        <div class="left">
            <div class="content">
                <h1><?= $tournament["name"]; ?> - <span style="font-size: 26px;"><?= $tournament["ubication"]; ?></span></h1>

                <p style="margin-right: 40rem;"><?= $tournament["description"]; ?></p>
                <div class="details" style="font-size: 20px; margin-top: 3rem;">
                    <p><b>- Details - </b></p>
                    <p><b>Precio:</b> <?= $tournament["tournament_price"]; ?>€</p>
                    <p><b>Formato:</b> <?= $tournament["format"]; ?></p>
                    <p><b>Nivel de Reglas:</b> Competitivo</p>
                    <p><b>Aforo:</b> <?= $tournament["max_players"]; ?></p>
                    <p><b>- Premios -</b></p>
                    <div class="premios" style="font-size: 16px; margin-right: 38rem; margin-top: -1.75rem;">
                        <?php if(json_decode($tournament["prices"], true) && count(json_decode($tournament["prices"], true))) { foreach (json_decode($tournament["prices"], true) as $idx => $position) { ?>
                            <p style="display: inline-block; margin-right: 2rem; width:250px; vertical-align: top;"><?=$idx;?>.
                                <?php foreach ($position as $index => $price) { ?>
                                    <br> - <?=$price["qty"];?>x <?=$price["name"];?> <?=(isset($price["foil"]) && $price["foil"] == "on" ? "(FOIL)" : ""); ?>
                                <?php } ?>
                                </p>
                        <?php }
                            }else{?> <p style='margin-top: 2rem;'>No prices</p> <?php } ?>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="right">
            <?php if(isset($shop_config["shop_img"]) && $shop_config["shop_img"] != "") { ?>
                <img src="/<?=$shop_config["shop_img"];?>" alt="" class="shop-logo">
            <?php } ?>
        </div>
        <border>

    </div>
</body>
<script src="/cards/assets/vendor/htmlToImage/dom-to-image.js"></script>
<script>
domtoimage.toJpeg(document.getElementById('my-node'), { quality: 0.95, bgcolor: "#FFFFFF" })
    .then(function (dataUrl) {
        var link = document.createElement('a');
        link.download = 'tournament-image.jpeg';
        link.href = dataUrl;
        link.click();

        var link2 = document.createElement('a');
        link2.href = '/tournaments/0';
        link2.click();
    });
</script>
<?php require_once('cards/www/templates/_footer.php'); ?>
</html>