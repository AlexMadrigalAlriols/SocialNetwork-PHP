<?php
    require_once("cards/framework/globalController.php");
    $searched_cards = array("none");

    if(isset($_POST["commandSearch"]) && $_POST["commandSearch"]) {
        $searched_cards = cardService::searchCardsOnWeb($_POST["searcher-card"]);
    }

?>