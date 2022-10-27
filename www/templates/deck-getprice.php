<!DOCTYPE html>
<html lang="en">

<?php 
require_once('header.php'); 
require_once("cards/framework/globalController.php");
$user = &fwUser::getInstance();

if($user->get("id_user") === null){
  header("Location: /login");
}

if(!isset($id_deck)) {
  header("Location: /decks/0");
}

$deck = deckService::getPriceByIdDeck($id_deck);

if($deck["deck"]) {
    if ($deck["deck"]["private"] && $deck["deck"]["user_id"] != $user->get("id_user")) {
        header("Location: /decks/0");
    }
} else {
    header("Location: /decks/0");
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
              <h4 class="d-inline-block"><?=$deck["deck"]["name"];?></h4>
              <p><b><?=$user->i18n("owner");?>: </b> <?=$deck["deck"]["owner_name"];?></p>
            </div>
          </div>

          <div class="card-body">
            <div class="col-md-10 d-inline-block">
            <div class="card view-deck-card">
              <div class="card-header">
                <h6 class="d-inline-block"><?=$user->i18n("cards_not_on_collec");?></h6>
              </div>

              <div class="card-body">
                <p><b><?=$user->i18n("missing_cards");?>: </b> <?=$deck["missing_cards_count"];?></p>
                <p><b><?=$user->i18n("total_price");?>: </b> <?=$deck["total_price"];?> €</p>
                <p><b><?=$user->i18n("total_price");?> (MTGO): </b> <?=$deck["total_price_tix"];?> tix</p>
                <p><b><?=$user->i18n("deck_list");?></b></p>
                <textarea name="textCards" id="textCards" cols="50" rows="20" class="form-control"><?=$user->i18n("deck");?><?php echo "\n"; foreach ($deck["missing_cards"] as $name => $qty) { echo $qty . " " . $name . "\n"; } ?><?php if(count($deck["missing_side"])){ echo "Sideboard"; }?><?php echo "\n"; foreach ($deck["missing_side"] as $name => $qty) { echo $qty . " " . $name . "\n"; } ?></textarea>
              </div>
            </div>

            </div>
            <div class="col-md-2 container d-inline-block">
            <div class="row">
              <a class="btn btn-primary mb-3 mt-3" href="/deck/<?php echo $id_deck; ?>"><i class='bx bx-left-arrow-alt'></i> <?=$user->i18n("deck_page");?></a>
            </div>
            </div>
          </div>
    </div>
</body>
</html>

<script src="/cards/assets/js/headerControler.js"></script>