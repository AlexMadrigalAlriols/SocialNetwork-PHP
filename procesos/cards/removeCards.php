<?php 
    require_once("cards/framework/globalController.php");
    echo cardService::removeCards($_POST, $_SESSION["iduser"]);
?>