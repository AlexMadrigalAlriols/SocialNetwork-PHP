<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $publications = publicationService::findAllPublicationsByUser($user_id);
    $user_profile_details = userService::getUserDetails($user_id);

    if($user_profile_details["shop"]) {
        $tournaments = tournamentService::getAllTournamentsByShop($user_id);
    }

    if($user->get("id_user") !== null && isset($_POST)) {
        if (!$user_profile_details || in_array($user->get("id_user"), json_decode($user_profile_details["blocked_users"], true))) {
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