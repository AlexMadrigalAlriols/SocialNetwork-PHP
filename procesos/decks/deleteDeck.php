<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();

    if(deckService::isDeckOwner($user->get("id_user"), $_POST["deckId"])) {
        echo deckService::deleteDeck($_POST["deckId"]);
    }
    
    echo 0;
?>