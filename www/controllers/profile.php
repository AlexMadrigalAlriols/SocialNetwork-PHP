<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    
    if(!is_numeric($user_id)) {
        $user_deta = userService::getUserByUsername(str_replace("@", "", $user_id));
        if(!$user_deta) {
            header("Location: /?error=1");
        }

        $user_id = $user_deta["user_id"];
    }
    
    $user_profile_details = userService::getUserDetails($user_id);
    $user_profile_details["shop_config"] = json_decode($user_profile_details["shop_config"], true);
    $user_profile_details["badges"] = badgeService::getUserBadges($user_id);
    
    $publications = publicationService::findAllPublicationsByUser($user_id);
    
    if(isset($user_profile_details["shop_config"]["shop"]) && $user_profile_details["shop_config"]["shop"]) {
        $tournaments = tournamentService::getAllTournamentsByShop($user_id, false, false, false, true);
    }
    
    if($ubication = json_decode($user_profile_details["ubication"], true)) {
        $user_profile_details["ubication"] = ($ubication["street"] ? $ubication["street"] . ". " : "") . ($ubication["city"] ? $ubication["city"] . ", " : "") . ($ubication["state"] ? $ubication["state"] . "." : "");
    }


    if($user->get("id_user") !== null && isset($_POST)) {
        if (!$user_profile_details || userService::isUserBlocked($user->get("id_user") ,$user_profile_details["user_id"])) {
            header("Location: /?error=1");
        }
    
        if (isset($_POST["command_follow"])) {
    
            if (userService::followUser($user->get("id_user") ,$user_id)) {
                header("Location: /profile/".$user_id);
            }
        }
    
        if (isset($_POST["command_unfollow"])) {
            if(userService::unfollowUser($user->get("id_user") ,$user_id)){
                header("Location: /profile/".$user_id);
            }
        }
    
        if (isset($_POST["command_block"])) {
            if (userService::blockUser($user->get("id_user"), $user_id)) {
                header("Location: /profile/".$user_id);
            }
        }
    
        if (isset($_POST["command_unblock"])) {
            if (userService::unblockUser($user->get("id_user"), $user_id)) {
                header("Location: /profile/".$user_id);
            }
        }
    
        if(isset($_POST["command_report"])){
            if (reportService::triggerReport($user->get("id_user"), REPORT_USER, $user_id)) {
                header("Location: /profile/".$user_id . "?reported=1");
            }
        }
    
        if(isset($_POST["commandUploadCover"])){
            if(userService::uploadNewCover($user->get("id_user"), $_FILES["profile"])){
                header("Location: /profile/".$user->get("id_user"));
            } else {
                header("Location: /profile/". $user->get("id_user") ."?error=1");
            }
        }
    
        if(isset($_POST["commandReport"])) {
            if (reportService::triggerReport($user->get("id_user"), REPORT_PUBLICATION, 0, $_POST["commandReport"])) {
                header("Location: /profile/".$user_id. "?report=1");
            }
        }
    
        if(isset($_POST["commandDelete"])) {
            if (publicationService::deletePublication($_POST["commandDelete"])) {
                header("Location: /profile/".$user_id."?deleted=1");
            }
        }
    
        if(isset($_POST["commandSignUp"])) {
            if(tournamentService::userJoinTournament($_POST["commandSignUp"], $user->get("id_user"))) {
                header("Location: /tournaments/".$user->get("id_user"));
            }
        }
    } else if($user->get("id_user") === null && isset($_POST)) {
        header("Location: /login");
    }
    
?>