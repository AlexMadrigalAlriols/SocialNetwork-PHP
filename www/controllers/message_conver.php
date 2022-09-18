<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $error = array();

    if($user->get("id_user") === null){
        header("Location: /login");
    }
    
    $suggested_users = userService::getSuggestedUsers($user->get("id_user"));
    $user_chat = userService::getUserByUsername(str_replace("@", "", $username));

    if(isset($_POST["command_send"])) {
        if(messageService::sendMessage($user->get("id_user"), $user_chat["user_id"], $_POST, $_FILES["message"])) {
            header("Location: /messages/".$username);
        }
    }
    
    $chat_messages = messageService::getMessageChat($user->get("id_user"), $user_chat["user_id"]);
?>