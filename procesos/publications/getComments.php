<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    echo publicationCommentService::getComments($_POST["id_publication"],$user->get("id_user"));
?>