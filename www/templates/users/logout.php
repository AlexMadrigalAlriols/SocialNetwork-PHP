<?php 
    require_once("cards/framework/globalController.php");

    $user = &fwUser::getInstance();
    $user->reset();
    
    header("Location: /login");

?>