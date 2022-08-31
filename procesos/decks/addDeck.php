<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    
    if($_POST["id_deck"] != 0 && deckService::isDeckOwner($user->get("id_user"), $_POST["id_deck"])) {
        echo deckService::editDeck($_POST);
    } else {
        unset($_POST["id_deck"]);
        echo deckService::addDeck($_POST, $user->get("id_user"));
    }
    
?>