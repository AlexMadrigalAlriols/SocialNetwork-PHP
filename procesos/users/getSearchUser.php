<?php
    require_once("cards/framework/globalController.php");

    echo userService::searchUserInputBar($_SESSION["iduser"], $_POST["input"]);
?>