<?php
    require_once("cards/framework/globalController.php");

    if($_POST["id_deck"] != 0 && deckService::isDeckOwner($_SESSION["iduser"], $_POST["id_deck"])) {
        echo deckService::editDeck($_POST);
    } else {
        unset($_POST["id_deck"]);
        echo deckService::addDeck($_POST, $_SESSION["iduser"]);
    }
    
?>