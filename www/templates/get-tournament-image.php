<!DOCTYPE html>
<?php
    require_once("cards/framework/globalController.php");
    $tournament = tournamentService::getTournamentById($id_tournament);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CollectionSaver Imager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100;300;400;500;600;700;900&display=swap" rel="stylesheet">
</head>
<style>

#my-node {
    width: 1280px !important; 
    height: 720px !important; 
    font-family: 'Work Sans', sans-serif;
}

.right {
    position: absolute;
    left: 0;
    top: 0;
    -webkit-clip-path: polygon(60% 0, 100% 0%, 100% 100%, 40% 100%);
    clip-path: polygon(60% 0, 100% 0%, 100% 100%, 40% 100%);
    background-image: url('/cards/assets/img/Windswept-Heath-MtG-Art.jpg');
    width: 1280px !important; 
    height: 720px !important;
    background-color: #cccccc; /* Used if the image is unavailable */
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Do not repeat the image */
    background-size: cover; /* Resize the background image to cover the entire container */
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
    background: radial-gradient(at 0% 0%, #55566a 30%, #282834);
    width: 1280px;
    height: 720px;
    -webkit-clip-path: polygon(0 0, 60% 0, 40% 100%, 0 100%);
    clip-path: polygon(0 0, 60% 0, 40% 100%, 0 100%);
}

.left .content {
    padding: 2rem;
    color: white;
}

border {
    position: absolute;
    left: 0;
    top: 0;
    width: 1280px;
    height: 720px;
    background-color: Gainsboro;
    -webkit-clip-path: polygon(59% 0, 61% 0, 41% 100%, 39% 100%);
    clip-path: polygon(60% 0, 61% 0, 41% 100%, 40% 100%);
}

</style>
<body>
    <div id="my-node">
        <div class="left">
            <div class="content">
                <h1><?= $tournament["name"]; ?> - <span style="font-size: 26px;"><?= $tournament["ubication"]; ?></span></h1>

                <p style="margin-right: 40rem; color: DarkGray;"><?= $tournament["description"]; ?></p>
                <div class="details" style="font-size: 20px; margin-top: 3rem;">
                    <p><b>- <?=$user->i18n("details");?> - </b></p>
                    <p><b>Precio:</b> <?= $tournament["tournament_price"]; ?>€</p>
                    <p><b>Formato:</b> <?= $tournament["format"]; ?></p>
                    <p><b>Nivel de Reglas:</b> Competitivo</p>
                    <p><b>Aforo:</b> <?= $tournament["max_players"]; ?></p>
                    <p><b>- Premios -</b></p>
                    <div class="premios" style="font-size: 16px; margin-right: 38rem; margin-top: -1.75rem;">
                        <?php foreach (json_decode($tournament["prices"], true) as $idx => $position) { ?>
                            <p style="display: inline-block; margin-right: 2rem; width:250px; vertical-align: top;"><?=$idx;?>.
                                <?php foreach ($position as $index => $price) { ?>
                                    <br> - <?=$price["qty"];?>x <?=$price["name"];?> <?=(isset($price["foil"]) && $price["foil"] == "on" ? "(FOIL)" : ""); ?>
                                <?php } ?>
                                </p>
                        <?php } ?>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="right">
            
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

</html>