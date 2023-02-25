<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    echo userService::searchUserInputBar($user->get("id_user"), $_POST["input"], (isset($_POST["put_followed"]) && $_POST["put_followed"] ? true : false));
?>