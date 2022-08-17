<?php 
    require_once("cards/framework/globalController.php");
    echo cardService::addCards($_POST, $_SESSION["iduser"]);
?>