<?php 
    require_once("cards/framework/globalController.php");
    echo json_encode(cardService::searchCardsOnWeb($_POST['card_name']));
?>