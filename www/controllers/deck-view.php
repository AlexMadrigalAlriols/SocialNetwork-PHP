<?php 
require_once("cards/framework/globalController.php");
if(!isset($_SESSION["iduser"])){
    header("Location: /login");
}
if(!isset($id_deck)) {
    header("Location: /decks/0");
}

$deck = deckService::getDeckDetails($id_deck);
if($deck) {
    if ($deck["private"] && $deck["user_id"] != $_SESSION["iduser"]) {
        header("Location: /decks/0");
    }
} else {
    header("Location: /decks/0");
}

/***************************
  Sample using a PHP array
****************************/

?>