<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $error = array();

    if($user->get("id_user") === null){
        header("Location: /login");
    }

    $suggested_users = userService::getSuggestedUsers($user->get("id_user"));
    $notifications = notificationService::getAllNotificationByUser($user->get("id_user"));

    $read = notificationService::readAllNotifications($user->get("id_user"));
?>