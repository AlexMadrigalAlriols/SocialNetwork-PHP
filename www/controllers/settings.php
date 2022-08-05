<?php
    require_once("cards/framework/globalController.php");

    if(isset($_POST["commandUpdateProfile"]) && $_POST["commandUpdateProfile"]){
        if(!is_array(userService::saveSettings($_SESSION["iduser"], $_POST, $_FILES["settings"]))){
            header("Location: /settings?success=1");
        } else {
            header("Location: /settings?error=1");
        }
    }

    if(isset($_POST["commandUpdateUser"]) && $_POST["commandUpdateUser"]){
        if(!is_array(userService::saveSettings($_SESSION["iduser"], $_POST))){
            header("Location: /settings/account?success=1");
        } else {
            header("Location: /settings/account?error=1");
        }
    }

?>