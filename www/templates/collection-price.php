<!DOCTYPE html>
<html lang="en">

<?php 
require_once('header.php'); 
require_once("cards/framework/globalController.php");

if(!isset($_SESSION["iduser"])){
  header("Location: /login");
}

$user_price = cardService::getCollectionPriceByUserId($_SESSION["iduser"]);
if(!$user_price) {
  header("Location: /cards/0");
}

?>
<body id="body-pd" class="body-pd" style="overflow-x: hidden;">

    <?php require_once('navControlPanel.php') ?>
    <div id="contenedor_carga" class="d-none">
        <div id="carga"></div>
    </div>
    <div class="card mb-3 filterBox" id="secondStep">
          <div class="card-header">
            <div>
              <h4 style="display: inline-block;">Collection Price</h4>
            </div>
          </div>

          <div class="card-body">
            <div class="col-md-10" style="float:left; display: inline-block;">
            <div class="card" style="width: 97%;">
              <div class="card-header">
                <h6 style="display: inline-block;">Cards on collection</h6>
              </div>

              <div class="card-body">
                <p><b>Collection Cards: </b> <?=$user_price["totalCards"];?></p>
                <p><b>Total Price: </b> <?=$user_price["price"];?> €</p>
                <p><b>Total Price (MTGO): </b> <?=$user_price["priceTix"];?> tix</p>
                <p><b>Collection List</b></p>
                <textarea name="textCards" id="textCards" cols="50" rows="20" class="form-control" disabled><?php echo "\n"; foreach ($user_price["cards"] as $name => $qty) { echo $qty . " " . $name . "\n"; } ?></textarea>
              </div>
            </div>

            </div>
            <div class="col-md-2 container" style="display: inline-block; aling-items: right;">
              <div class="row">
                <a class="btn btn-primary mb-3" href="/cards/0"><i class='bx bx-left-arrow-alt'></i> Collection Page</a>
              </div>
            </div>
          </div>
    </div>
</body>
</html>

<script src="/cards/assets/js/headerControler.js"></script>