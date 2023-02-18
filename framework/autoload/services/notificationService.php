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

        if($model->findOne("notifications.notification_type = '" . $notification_type . "' AND notifications.user_id = " . $user_id . 
        " AND notifications.trigger_user_id = " . $trigger_user_id)) {
            return 0;
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
            if ($notification["notification_type"] == NOTIFICATION_TYPE_COMMENTED || $notification["notification_type"] == NOTIFICATION_TYPE_LIKE) {  
                $notifications[$idx]["notification_url"] = '/publication/'.$notification["id_publication"]; 
            } else { 
                $notifications[$idx]["notification_url"] = '/profile/'. $notification["trigger_user_id"];
            }

            if($notification["username"] == "" || $notification["trigger_user_id"] == $user_id) {
                unset($notifications[$idx]);
            }
        }
        
        return $notifications;
    }

    public static function readAllNotifications($user_id) {
        $model = new notificationModel();

        if($model->update(array("user_id" => $user_id), array("already_read" => 1))) {
            return true;
        }

        return false;
    }

    public static function checkIfNotifications($user_id) {
        $model = new notificationModel();
        $notifications = $model->find("notifications.user_id = ". $user_id . " AND notifications.already_read = 0", "notifications.notification_date DESC");
        
        if($notifications) {
            $notification_no_read = count($notifications);
            if($notification_no_read >= gc::getSetting("notifications_max_count")) {
                $notification_no_read = gc::getSetting("notifications_max_count");
            }

            return $notification_no_read;
        }

        return 0;
    }
}

?>