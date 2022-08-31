<?php
    require_once("cards/framework/globalController.php");
    
    echo json_encode(cardService::getSpecificCard($_POST["card_id"]));
?>