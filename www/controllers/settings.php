<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();

    if($user->get("id_user") === null){
        header("Location: /login");
    }

    if(isset($_POST["commandUpdateProfile"])){
        if(!is_array(userService::saveSettings($user->get("id_user"), $_POST, $_FILES["settings"]))){
            header("Location: /settings?success=1");
        } else {
            header("Location: /settings?error=1");
        }
    }

    if(isset($_POST["commandDeleteUser"])){
        if(userService::banUser($user->get("id_user"))) {
            header("Location: /logout");
        } else {
            header("Location: /settings/account?error=1");
        }
    }

    if(isset($_POST["commandUpdateUser"])){
        $result = userService::saveSettings($user->get("id_user"), $_POST);
        if(!is_array($result)){
            header("Location: /settings/account?success=1");
        } else {
            header("Location: /settings/account?error=" . $result[0]);
        }
    }

?>