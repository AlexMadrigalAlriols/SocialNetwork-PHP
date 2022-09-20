<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $error = array();

    if($user->get("id_user") === null){
        header("Location: /login");
    }

    $suggested_users = userService::getSuggestedUsers($user->get("id_user"));
    $user_chat = userService::getUserByUsername(str_replace("@", "", $username));

    if(userService::isUserBlocked($user->get("id_user"), $user_chat["user_id"])) {
        header('Location: /messages?error=access');
    }
    
    $chat_messages = messageService::getMessageChat($user->get("id_user"), $user_chat["user_id"]);
    
    if($user->get("id_user") == $user_chat["user_id"] || !$user_chat) {
        header("Location: /messages");
    }

    if(isset($_POST["command_send"])) {
        if(messageService::sendMessage($user->get("id_user"), $user_chat["user_id"], $_POST, $_FILES["message"])) {
            header("Location: /messages/".$username);
        }
    }

    if(isset($_POST["commandReport"])) {
        if (reportService::triggerReport($user->get("id_user"), REPORT_CONVERSATION, $user_chat["user_id"], 0, 0, $chat_messages)) {
            header("Location: /messages?reported=1");
        }
    }
?>