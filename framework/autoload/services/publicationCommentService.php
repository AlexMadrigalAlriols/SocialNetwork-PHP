<?php

class publicationCommentService {
    public static function commentPublication($user_id, $request){
        $model = new commentsModel();
        $validator = new dataValidator();
        $error = array();
        $request["id_user"] = strval($user_id);

        if (!$request["comment_message"] = $validator->value($request["comment_message"])->notEmpty()->sanitizeAlphanumeric()->validate()) {$error[] = "comment_message";}
        if (!$request["id_publication"] = $validator->value($request["id_publication"])->notEmpty()->validate()) {$error[] = "id_publication";}

        if(!count($error) && $model->create($request)){
            $model_publi = new publicationsModel();

            $result = $model_publi->findOne($request["id_publication"], null, array("id_user"));
            if($result && $result["id_user"]){
                notificationService::notificationTrigger($result["id_user"], NOTIFICATION_TYPE_COMMENTED, $user_id, $request["id_publication"]);
            }
            
            return 1;
        } else {
            return 0;
        }
    }

    public static function getComments($id_publication){
        $model = new commentsModel();
        $results = $model->find("id_publication = ".$id_publication);
        foreach ($results as $idx => $comment) {
            $results[$idx]["passed_time"] = fwTime::getPassedTime($comment["comment_date"]);
        }
        
        return json_encode($results);
    }

    public static function getCommentCount($id_publication) {
        $model = new commentsModel();
        $results = $model->find("id_publication = ".$id_publication);

        return count($results);
    }

}

?>