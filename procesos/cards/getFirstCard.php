<?php 
    require_once("cards/framework/globalController.php");
    echo json_encode(apiService::getFirstCardOfEdition($_GET['card_name'], $_GET['format']));
?>