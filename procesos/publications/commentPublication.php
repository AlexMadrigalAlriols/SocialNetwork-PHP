<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    echo publicationCommentService::commentPublication($user->get("id_user"), $_POST);
?>