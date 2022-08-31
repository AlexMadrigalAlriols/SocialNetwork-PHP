<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    echo publicationService::likePublication($user->get("id_user"), $_POST["id_publication"]);
?>