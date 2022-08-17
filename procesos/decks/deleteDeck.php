<?php
    require_once("cards/framework/globalController.php");
    if(deckService::isDeckOwner($_SESSION["iduser"], $_POST["deckId"])) {
        echo deckService::deleteDeck($_POST["deckId"]);
    }
    
    echo 0;
?>