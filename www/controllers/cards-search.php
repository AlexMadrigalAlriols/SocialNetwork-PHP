<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    
    if($user->get("id_user") === null){
        header("Location: /login");
    }
    
    $searched_cards = array("none");

    if(isset($_POST["commandSearch"]) && $_POST["commandSearch"]) {
        $searched_cards = apiService::searchAllCards($_POST["searcher-card"]);
    }
?>