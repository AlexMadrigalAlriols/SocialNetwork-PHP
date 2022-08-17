<?php
    require_once("cards/framework/globalController.php");
    echo cardService::getAutoComplet($_POST["autocomplet"]);
?>