<?php

class notificationService{
    public static function notificationTrigger($user_id, $notification_type, $trigger_user_id = 0, $id_publication = 0){
        if($user_id == $trigger_user_id){
            return 0;
        }
        
        $model = new notificationModel();
        $request["user_id"] = $user_id;
        $request["notification_type"] = $notification_type;

        if($trigger_user_id){
            $request["trigger_user_id"] = $trigger_user_id;
        }

        if($id_publication){
            $request["id_publication"] = $id_publication;
        }

        if($model->create($request)){
            return 1;
        }

        return 0;
    }

    public static function getAllNotificationByUser($user_id){
        $model = new notificationModel();
        $notifications = $model->find("notifications.user_id = ". $user_id, "notifications.notification_date DESC");
        
        foreach ($notifications as $idx => $notification) {
            if($notification["username"] == "") {
                unset($notifications[$idx]);
            }
        }
        
        return $notifications;
    }
}

?>