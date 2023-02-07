<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();

    $error = array();
    $decks = false;
    $publications = false;
    
    if($user->get("id_user") === null){
        header("Location: /logout");
    }

    if(isset($_POST["commandFollowSuggested"])){
        if(userService::followUser($user->get("id_user"), $_POST["commandFollowSuggested"])){
            header("Location: /?success=1");
        }
    }

    if(isset($_POST["command_publish"])){
        $validator = new dataValidator();

        if(!$validator->value($_POST["publication"]["publication_message"])->notEmpty()->validate()){
            $error[] = "El mensaje no es valido, vuelve a probar.";
        }
        
        if(!count($error) && publicationService::addPublication($user->get("id_user"), $_POST, $_FILES["publication"])){
            header("Location: /");
        } else {
            header("Location: /?error=1");
        }
    }

    if(isset($_POST["commandReport"])){
        if (reportService::triggerReport($user->get("id_user"), REPORT_PUBLICATION, 0, $_POST["commandReport"])) {
            header("Location: /publication/".$_POST['commandReport'] . "?reported=1");
        }
    }

    if(isset($_POST["commandDelete"])){
        if (publicationService::deletePublication($_POST["commandDelete"])) {
            header("Location: /?commentDeleted=1");
        }
    }

    if(isset($_POST["commandCommentDelete"])){
        if (publicationCommentService::deleteComment($_POST["commandCommentDelete"])) {
            header("Location: /?deleted=1");
        }
    }

    $decks = deckService::getAllDecksFromUser($user->get("id_user"));
    $publications = publicationService::findPublicationsFeed($user->get("id_user"), 0, gc::getSetting("publications.numPerLoad"));
    $suggested_users = userService::getSuggestedUsers($user->get("id_user"));
?>