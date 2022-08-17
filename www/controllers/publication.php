<?php
    require_once("cards/framework/globalController.php");
    $error = array();

    if(!isset($_SESSION["iduser"])){
        header("Location: /login");
    }

    if(isset($_POST["commandFollowSuggested"]) && $_POST["commandFollowSuggested"]){
        if(userService::followUser($_SESSION["iduser"], $_POST["commandFollowSuggested"])){
            header("Location: /?success=1");
        }
    }

    if(isset($_POST["commandReport"]) && $_POST["commandReport"]){
        if (!isset($_SESSION["iduser"])) {
            header("Location: /login");
        }

        if (reportService::triggerReport($_SESSION["iduser"], REPORT_PUBLICATION, 0, $_POST["commandReport"])) {
            header("Location: /publication/".$_POST['commandReport'] . "?reported=1");
        }
    }

    if(isset($_POST["commandDelete"]) && $_POST["commandDelete"]){
        if (!isset($_SESSION["iduser"])) {
            header("Location: /login");
        }

        if (publicationService::deletePublication($_POST["commandDelete"])) {
            header("Location: /?deleted=1");
        }
    }

    if(isset($_POST["commandCommentPublish"]) && $_POST["commandCommentPublish"]){
        if (!isset($_SESSION["iduser"])) {
            header("Location: /login");
        }

        $_POST["id_publication"] = $publication_id;
        unset($_POST["commandCommentPublish"]);
        if (publicationCommentService::commentPublication($_SESSION["iduser"], $_POST)) {
            header("Location: /publication/".$publication_id."?success=1");
        }
    }

    if(isset($_POST["commandCommentDelete"]) && $_POST["commandCommentDelete"]){
        if (!isset($_SESSION["iduser"])) {
            header("Location: /login");
        }

        if (publicationCommentService::deleteComment($_POST["commandCommentDelete"])) {
            header("Location: /publication/".$publication_id."?commentDeleted=1");
        }
    }
    
    $publication = publicationService::getPublicationDetails($publication_id);

    $comments = publicationCommentService::getComments($publication_id, $_SESSION["iduser"]);

    $suggested_users = userService::getSuggestedUsers($_SESSION["iduser"]);
?>