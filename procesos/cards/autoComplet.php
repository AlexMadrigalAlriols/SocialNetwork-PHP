<?php
    require_once("cards/framework/globalController.php");
    echo apiService::getAutoComplet($_POST["autocomplet"]);
?>