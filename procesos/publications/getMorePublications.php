<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $publications = publicationService::findPublicationsFeed($user->get("id_user"), $_POST["postOffset"], gc::getSetting("publications.numPerLoad"));
    
    foreach ($publications as $key => $publication) {
        $publications[$key]["passed_time"] = fwTime::getPassedTime($publication["publication_date"]);
        $publications[$key]["comment_count"] = publicationCommentService::getCommentCount($publication["id_publication"]);
        $publications[$key]["like_count"] = count(json_decode($publication["publication_likes"], true));
        $publications[$key]["user_liked"] = (in_array($user->get("id_user"), json_decode($publication["publication_likes"],true)) ? true : false);
        $publications[$key]["site_url"] = gc::getSetting('site.url');
        $publications[$key]["session_user_id"] = $user->get("id_user");
        $publications[$key]["session_user_admin"] = $user->get("admin");
    }
    
    echo json_encode($publications);
?>