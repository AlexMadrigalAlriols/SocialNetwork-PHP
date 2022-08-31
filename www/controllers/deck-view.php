<?php 
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    
    if(!isset($id_deck)) {
        header("Location: /decks/0");
    }

    $deck = deckService::getDeckDetails($id_deck);

    if($deck && $deck["private"]) {
        if($user->get("id_user") === null){
            header("Location: /login");
        }

        if ($deck["user_id"] != $user->get("id_user") && !$user->get("admin")) {
            header("Location: /decks/0");
        }
    } else {
        header("Location: /decks/0");
    }

    if(isset($_POST["commandReport"])) {
        if($user->get("id_user") === null){
            header("Location: /login");
        }

        if (reportService::triggerReport($user->get("id_user"), REPORT_DECK, 0, 0, $_POST["commandReport"])) {
            header("Location: /deck/".$_POST["commandReport"] . "?reported=1");
        }
    }

?>