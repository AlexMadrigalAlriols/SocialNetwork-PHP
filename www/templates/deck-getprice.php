<!DOCTYPE html>
<html lang="en">

<?php 
require_once('header.php'); 
require_once("cards/framework/globalController.php");

if(!isset($_SESSION["iduser"])){
  header("Location: /login");
}

if(!isset($id_deck)) {
  header("Location: /decks/0");
}

$deck = deckService::getPriceByIdDeck($id_deck);

if($deck["deck"]) {
    if ($deck["deck"]["private"] && $deck["deck"]["user_id"] != $_SESSION["iduser"]) {
        header("Location: /decks/0");
    }
} else {
    header("Location: /decks/0");
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
              <h4 style="display: inline-block;"><?=$deck["deck"]["name"];?></h4>
              <p><b>Owner: </b> <?=$deck["deck"]["owner_name"];?></p>
            </div>
          </div>

          <div class="card-body">
            <div class="col-md-10" style="float:left; display: inline-block;">
            <div class="card" style="width: 97%;">
              <div class="card-header">
                <h6 style="display: inline-block;">Cards not on collection</h6>
              </div>

              <div class="card-body">
                <p><b>Missing Cards: </b> <?=$deck["missing_cards_count"];?></p>
                <p><b>Total Price: </b> <?=$deck["total_price"];?> €</p>
                <p><b>Total Price (MTGO): </b> <?=$deck["total_price_tix"];?> tix</p>
                <p><b>Deck List</b></p>
                <textarea name="textCards" id="textCards" cols="50" rows="20" class="form-control">Deck<?php echo "\n"; foreach ($deck["missing_cards"] as $name => $qty) { echo $qty . " " . $name . "\n"; } ?><?php if(count($deck["missing_side"])){ echo "Sideboard"; }?><?php echo "\n"; foreach ($deck["missing_side"] as $name => $qty) { echo $qty . " " . $name . "\n"; } ?></textarea>
              </div>
            </div>

            </div>
            <div class="col-md-2 container" style="display: inline-block; aling-items: right;">
            <div class="row">
              <a class="btn btn-primary mb-3" href="/deck/<?php echo $id_deck; ?>"><i class='bx bx-left-arrow-alt'></i> Deck Page</a>
            </div>
            </div>
          </div>
    </div>
</body>
</html>

<script src="/cards/assets/js/headerControler.js"></script>