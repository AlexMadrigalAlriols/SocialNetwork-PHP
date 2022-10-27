<!DOCTYPE html>
<html lang="en">

<?php 
require_once('header.php'); 
require_once("cards/framework/globalController.php");
$user = &fwUser::getInstance();

if($user->get("id_user") === null){
  header("Location: /login");
}

$user_price = cardService::getCollectionPriceByUserId($user->get("id_user"));
if(!$user_price) {
  header("Location: /cards/0");
}

?>
<body id="body-pd" class="body-pd overflow-x-hidden">
    <?php require_once('navControlPanel.php') ?>
    <div id="contenedor_carga" class="d-none">
        <div id="carga"></div>
    </div>
    <div class="card mb-3 filterBox" id="secondStep">
      <div class="card-header">
        <div>
          <h4 class="d-inline-block"><?=$user->i18n("collection_price");?></h4>
        </div>
      </div>

      <div class="card-body">
        <div class="col-md-10 pull-left d-inline-block">
          <div class="card view-deck-card">
            <div class="card-header">
              <h6 class="d-inline-block"><?=$user->i18n("cards_on_collection");?></h6>
            </div>
            <div class="card-body">
              <p><b><?=$user->i18n("collection_cards");?>: </b> <?=$user_price["totalCards"];?></p>
              <p><b><?=$user->i18n("total_price");?>: </b> <?=$user_price["price"];?> €</p>
              <p><b><?=$user->i18n("total_price");?> (MTGO): </b> <?=$user_price["priceTix"];?> tix</p>
              <p><b><?=$user->i18n("card_list");?></b></p>
              <textarea name="textCards" id="textCards" cols="50" rows="20" class="form-control" disabled><?php echo "\n"; foreach ($user_price["cards"] as $name => $qty) { echo $qty . " " . $name . "\n"; } ?></textarea>
            </div>
          </div>
        </div>
        <div class="col-md-2 container align-items-right d-inline-block">
          <div class="row">
            <a class="btn btn-primary mb-3 mt-3" href="/cards/0"><i class='bx bx-left-arrow-alt'></i> <?=$user->i18n("collection_page");?></a>
          </div>
        </div>
      </div>
    </div>
</body>
</html>

<script src="/cards/assets/js/headerControler.js"></script>