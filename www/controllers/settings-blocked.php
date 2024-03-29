<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();

    if($user->get("id_user") === null){
        header("Location: /login");
    }

    $user_details = userService::getUserDetails($user->get("id_user"));

    $json_users_blocked = json_decode($user_details["blocked_users"], true);
    $users_blocked = array();

    foreach ($json_users_blocked as $idx => $user_id) {
        $users_blocked[] = userService::getUserDetails($user_id);
    }

    if(isset($_POST["command_block"])){
        if (userService::unblockUser($user->get("id_user"), $_POST["command_block"])) {
            header("Location: /settings/blockusers");
        }
    }
?>