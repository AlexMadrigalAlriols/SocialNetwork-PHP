<?php 
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    echo cardService::removeCards($_POST, $user->get("id_user"));
?>