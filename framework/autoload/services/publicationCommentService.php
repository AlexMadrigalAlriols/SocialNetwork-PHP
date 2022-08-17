<?php

class publicationCommentService {
    public static function commentPublication($user_id, $request){
        $model = new commentsModel();
        $validator = new dataValidator();
        $model_publi = new publicationsModel();
        $error = array();
        $request["id_user"] = strval($user_id);
        
        if (!$request["id_publication"] = $validator->value($request["id_publication"])->notEmpty()->validate()) {$error[] = "id_publication";}
        
        $result = $model_publi->findOne($request["id_publication"], null, array("id_user"));

        if(!count($error) && $model->create($request) && !userService::isUserBlocked($user_id, $result["id_user"])){
            
            if($result && $result["id_user"]){
                notificationService::notificationTrigger($result["id_user"], NOTIFICATION_TYPE_COMMENTED, $user_id, $request["id_publication"]);
            }
            
            return 1;
        } else {
            return 0;
        }
    }

    public static function getComments($id_publication, $id_user){
        $model = new commentsModel();
        $results = $model->find("id_publication = ".$id_publication);

        return $results;
    }

    public static function getCommentCount($id_publication) {
        $model = new commentsModel();
        $results = $model->find("id_publication = ".$id_publication);

        return count($results);
    }

    public static function deleteAllCommentsFromPublication($id_publication){
        $model = new commentsModel();
        if($model->delete($id_publication, "id_publication = ". $id_publication)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function deleteAllCommentsFromUser($id_user){
        $model = new commentsModel();
        
        if($model->delete(0, "id_user = ". $id_user)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function deleteComment($id_comment){
        $model = new commentsModel();
        
        if($model->delete($id_comment)) {
            return 1;
        } else {
            return 0;
        }
    }

}

?>