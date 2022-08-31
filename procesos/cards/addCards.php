<?php 
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    echo cardService::addCards($_POST, $user->get("id_user"));
?>