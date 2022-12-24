<?php 
    require_once("cards/framework/globalController.php");
    echo json_encode(apiService::searchCardsOnWeb($_POST['card_name']));
?>