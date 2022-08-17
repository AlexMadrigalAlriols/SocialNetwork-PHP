<?php 
    require_once("cards/framework/globalController.php");
    echo json_encode(cardService::getFirstCardOfEdition($_GET['card_name'], $_GET['format']));
?>