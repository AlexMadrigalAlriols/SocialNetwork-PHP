<?php 
    require_once("cards/framework/globalController.php");

    $user = &fwUser::getInstance();
    
    if($user->get("id_user") === null){
        header("Location: /login");
    }

    $card = apiService::getSpecificCard($id_card, true);
    if($card["object"] == "error" && $card["code"] == "not_found") {
        header("Location: /cards/0");
    }

    if(isset($_POST["commandPutOnCollection"])) {
        if(cardService::addCards(array("id_card" => $id_card, "qty" => 1), $user->get("id_user"))) {
            header("Location: /card/" . $id_card . "?success=1");
        }

        header("Location: /card/". $id_card . "?success=1");
    }
?>