<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $currencies = gc::getSetting("currencies");

    if($user->get("id_user") === null){
        header("Location: /login");
    }

    if(isset($_POST["commandUpdateShop"])){
        if(!is_array(userService::saveSettings($user->get("id_user"), $_POST, $_FILES["shop_img"]))){
            header("Location: /settings/shop?success=1");
        } else {
            header("Location: /settings/shop?error=1");
        }
    }

?>