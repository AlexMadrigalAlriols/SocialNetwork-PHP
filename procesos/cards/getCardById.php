<?php
    require_once("cards/framework/globalController.php");
    
    echo json_encode(apiService::getSpecificCard($_POST["card_id"]));
?>