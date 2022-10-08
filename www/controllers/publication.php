<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $error = array();

    if($user->get("id_user") === null){
        header("Location: /login");
    }

    if(isset($_POST["commandFollowSuggested"])){
        if(userService::followUser($user->get("id_user"), $_POST["commandFollowSuggested"])){
            header("Location: /?success=1");
        }
    }

    if(isset($_POST["commandReport"])){
        if (reportService::triggerReport($user->get("id_user"), REPORT_PUBLICATION, 0, $_POST["commandReport"])) {
            header("Location: /publication/".$_POST['commandReport'] . "?reported=1");
        }
    }

    if(isset($_POST["commandDelete"])){
        if (publicationService::deletePublication($_POST["commandDelete"])) {
            header("Location: /?deleted=1");
        }
    }

    if(isset($_POST["commandCommentPublish"])){
        $_POST["id_publication"] = $publication_id;
        unset($_POST["commandCommentPublish"]);
        if (publicationCommentService::commentPublication($user->get("id_user"), $_POST)) {
            header("Location: /publication/".$publication_id."?success=1");
        }
    }

    if(isset($_POST["commandCommentDelete"])){
        if (publicationCommentService::deleteComment($_POST["commandCommentDelete"])) {
            header("Location: /publication/".$publication_id."?commentDeleted=1");
        }
    }
    
    $publication = publicationService::getPublicationDetails($publication_id);

    $comments = publicationCommentService::getComments($publication_id,$user->get("id_user"));

    $suggested_users = userService::getSuggestedUsers($user->get("id_user"));
?>