<?php
    require_once("cards/framework/globalController.php");

    $publications = publicationService::findAllPublicationsByUser($user_id);
    $user_profile_details = userService::getUserDetails($user_id);

    if (!$user_profile_details || in_array($_SESSION["iduser"], json_decode($user_profile_details["blocked_users"], true))) {
        header("Location: /?error=1");
    }

    if (isset($_POST["command_follow"]) && $_POST["command_follow"]) {
        if (!isset($_SESSION["iduser"])) {
            header("Location: /login");
        }

        if (userService::followUser($_SESSION["iduser"],$user_id)) {
            header("Location: /profile/".$user_id);
        }
    }

    if (isset($_POST["command_unfollow"]) && $_POST["command_unfollow"]) {
        if (!isset($_SESSION["iduser"])) {
            header("Location: /login");
        }
        
        if(userService::unfollowUser($_SESSION["iduser"],$user_id)){
            header("Location: /profile/".$user_id);
        }
    }

    if (isset($_POST["command_block"]) && $_POST["command_block"]) {
        if (!isset($_SESSION["iduser"])) {
            header("Location: /login");
        }

        if (userService::blockUser($_SESSION["iduser"], $user_id)) {
            header("Location: /profile/".$user_id);
        }
    }

    if (isset($_POST["command_unblock"]) && $_POST["command_unblock"]) {
        if (!isset($_SESSION["iduser"])) {
            header("Location: /login");
        }

        if (userService::unblockUser($_SESSION["iduser"], $user_id)) {
            header("Location: /profile/".$user_id);
        }
    }

    if(isset($_POST["command_report"]) && $_POST["command_report"]){
        if (!isset($_SESSION["iduser"])) {
            header("Location: /login");
        }

        if (reportService::triggerReport($_SESSION["iduser"], REPORT_USER, $user_id)) {
            header("Location: /profile/".$user_id . "?reported=1");
        }
    }

    if(isset($_POST["commandUploadCover"]) && $_POST["commandUploadCover"]){

        if(userService::uploadNewCover($_SESSION["iduser"], $_FILES["profile"])){
            header("Location: /profile/".$_SESSION["iduser"]);
        } else {
            header("Location: /profile/".$_SESSION["iduser"] ."?error=1");
        }
    }
?>