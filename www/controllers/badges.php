<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $error = array();

    if($user->get("id_user") === null){
        header("Location: /login");
    }

    if(!isset($id_user)) {
        header("Location: /badges/" . $user->get("id_user"));
    }

    if(!is_numeric($id_user)) {
        $user_data = userService::getUserByUsername(str_replace("@", "", $id_user));
        if(!$user_data) {
            header("Location: /?error=1");
        }

        $id_user = $user_data["user_id"];
    } else {
        $user_profile_details = userService::getUserDetails($id_user);

        header("Location: /badges/@" . $user_profile_details["username"]);
    }
    
    $user_profile_details = userService::getUserDetails($id_user);
    $suggested_users = userService::getSuggestedUsers($user->get("id_user"));
    $badges = gc::getBadges();
    $user_badges = badgeService::getUserBadges($id_user);
?>