<?php

class publicationService {
    public static function findAllPublicationsByUser($userId){
        $model = new publicationsModel();
        $allPublications = array();

        $allPublications = $model->findByUser($userId);

        return $allPublications;
    }

    public static function findPublicationsFeed($userId, $intOffset, $intCount){
        $model = new publicationsModel();
        $allPublications = array();

        $user_details = userService::getUserDetails($userId);

        $user_followed = json_decode($user_details["followed"], true);

        if(count($user_followed)){
            $allPublications = $model->find("id_user IN (" . implode(',', $user_followed) . ") OR id_user = $userId", "publication_date DESC", $intOffset, $intCount);
        } else {
            $allPublications = $model->find("id_user = $userId", "publication_date DESC", $intOffset, $intCount);
        }

        return $allPublications;
    }


    public static function countPublicationFeed($userId) {
        $model = new publicationsModel();
        $allPublications = array();

        $user_details = userService::getUserDetails($userId);
        $user_followed = json_decode($user_details["followed"], true);

        if(count($user_followed)){
            $allPublications = $model->find("id_user IN (" . implode(',', $user_followed) . ") OR id_user = $userId", "publication_date DESC", 0, 0, array("id_publication"));
        } else {
            $allPublications = $model->find("id_user = $userId", "publication_date DESC", 0, 0, array("id_publication"));
        }

        if($allPublications){
            return count($allPublications);
        }

        return 0;
    }

    public static function addPublication($user_id, $request, $files = false){
        $model = new publicationsModel();

        if(isset($files["name"]["publication_img"]) && $files["error"]["publication_img"] == 0){
            $request["publication"]["publication_img"] = fwFiles::uploadFiles($files, "publication_img");
        } else {
            $request["publication"]["publication_img"] = "none";
        }

        if(!isset($request["publication"]["publication_img"])){
            $request["publication"]["publication_img"] = "none";
        }

        if($model->create($request["publication"])) {
            badgeService::setUserBadges($user_id, "first_publication");
            return 1;
        } else {
            return 0;
        }
    }

    public static function likePublication($user_id, $id_publication){
        $model = new publicationsModel();
        $results = $model->findOne("id_publication = ".$id_publication, null, array("publication_likes", "id_user"));
        $publication_likes = json_decode($results["publication_likes"], true);

        if(count($publication_likes) == 0){
            $publication_likes = array("1" => $user_id);
            notificationService::notificationTrigger($results["id_user"], NOTIFICATION_TYPE_LIKE, $user_id, $id_publication);
        } else {
            if(!in_array($user_id, $publication_likes)){
                array_push($publication_likes, $user_id);
                notificationService::notificationTrigger($results["id_user"], NOTIFICATION_TYPE_LIKE, $user_id, $id_publication);

            } else {
                unset($publication_likes[array_search($user_id, $publication_likes)]);
            }
        }
        $publication_likes = array("publication_likes" => json_encode($publication_likes));
        if($model->update($id_publication, $publication_likes)){
            $total_likes = $model->findOne("id_publication = ".$id_publication, null, array("publication_likes"));
            
            badgeService::setUserBadges($user_id, "first_like");
            return count(json_decode($total_likes["publication_likes"],true));
        }
    }

    public static function getPublicationDetails($id_publication){
        $model = new publicationsModel();
        $result = $model->findOne("id_publication = ".$id_publication);
        if($result) {
            $result["passed_time"] = fwTime::getPassedTime($result["publication_date"]);

            return $result;
        }

        return 0;
    }

    public static function deletePublication($id_publication){
        $model = new publicationsModel();

        if(publicationCommentService::deleteAllCommentsFromPublication($id_publication) && $model->delete($id_publication)){
            return 1;
        }

        return 0;
    }

    public static function deleteAllPublications($id_user){
        $model = new publicationsModel();

        if(publicationCommentService::deleteAllCommentsFromUser($id_user) && $model->delete($id_user, "id_user = ". $id_user)){
            return 1;
        }

        return 0;
    }

    public static function getUserFromPublication($id_publication){
        $model = new publicationsModel();
        $result = $model->findOne("publications.id_publication = ".$id_publication, null, array("id_user"));

        return $result["id_user"];
    }

    public static function generate_UUID(){
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}

?>