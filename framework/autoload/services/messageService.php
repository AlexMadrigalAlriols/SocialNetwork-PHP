<?php

class messageService {
    public static function getMessageList($id_user){
        $model = new messagesModel();

        $messages = $model->find("messages.id_user = ".$id_user . " OR messages.id_user_destination = " . $id_user, "messages.date_sent DESC");

        $message_list = array();
        foreach ($messages as $idx => $message) {
            $ready_on_list = false;
            foreach ($message_list as $idx => $message_on_list) {
                if(($message["id_user"] === $message_on_list["id_user"] 
                    && $message["id_user_destination"] === $message_on_list["id_user_destination"])) {
                    $ready_on_list = true;
                }

                if(($message["id_user"] === $message_on_list["id_user_destination"] 
                    && $message["id_user_destination"] === $message_on_list["id_user"])) {
                    $ready_on_list = true;
                }
                
            }

            if(!$ready_on_list) {
                $message_content = json_decode($message["message_content"], true);

                if(isset($message_content)) {
                    if($message_content["message_txt"] != "") {
                        $message["message_text"] = $message_content["message_txt"];
                    } else if($message_content["message_txt"] == "" && $message_content["message_img"] == "none") {
                        $message["message_text"] = "Shared a Publication";
                    } else {
                        $message["message_text"] = "<i class='fa-regular fa-image me-1'></i> Image";
                    }

                    if($message["id_user"] == $id_user) {
                        $message["message_readed"]  = true;
                    }

                    if($message["id_user"] != $id_user) {
                        $destination_details = userService::getUserDetails($message["id_user"]);
                        $message = array_merge($message, $destination_details);
                    }
                    
                    if($message["username"]) {
                        $message_list[] = $message;
                    }
                }
            }   
        }

        return $message_list;
    }

    public static function getMessageChat($id_user, $id_chat_user) {
        $model = new messagesModel();

        $messages = $model->find(
        "(messages.id_user = ".$id_user." AND messages.id_user_destination = " . $id_chat_user .
        ") OR (messages.id_user = " . $id_chat_user . " AND messages.id_user_destination = " . $id_user . ")"
        , "messages.date_sent ASC");

        if($messages) {
            foreach ($messages as $idx => $message) {
                $message_content = json_decode($message["message_content"], true);

                if(isset($message_content)) {
                    if($message_content["message_txt"] != "") {
                        $messages[$idx]["message_text"] = $message_content["message_txt"];
                    }
    
                    if($message_content["message_img"] != "none") {
                        $messages[$idx]["message_img"] = $message_content["message_img"];
                    }

                    if($message_content["message_publication"] != "") {
                        $model = new publicationsModel();

                        $messages[$idx]["message_publication"] = $model->findOne("publications.id_publication = " . $message_content["message_publication"]);
                    }
                }

                if($message["id_user"] != $id_user && !$message["message_readed"]) {
                    $model->update($message["id_message"], array("message_readed" => 1));
                }
            }
        }

        return $messages;
    }

    public static function sendMessage($id_sender, $id_receiver, $request, $files = false) {
        $model = new messagesModel();

        if(isset($files["name"]["message_img"]) && $files["error"]["message_img"] == 0){
            $request["message_image"] = fwFiles::uploadFiles($files, "message_img");
        } else {
            $request["message_image"] = "none";
        }

        if($request["message_text"] == "" && $request["message_image"] == "none" && !isset($request["message_publication"])) {
            return false;
        }

        $data = array(
            "id_user"   => $id_sender,
            "message_content" => json_encode(
                array("message_txt" => $request["message_text"], "message_img" => $request["message_image"], "message_publication" => $request["message_publication"])),
            "id_user_destination"   => $id_receiver
        );

        if($model->create($data)) {
            badgeService::setUserBadges($id_sender, "first_dm_message");
            return true;
        }

        return false;
    }

    public static function sharePublications($id_sender, $users_to_share, $id_publication) {
        foreach ($users_to_share as $id_receiver) {
            messageService::sendMessage($id_sender, $id_receiver, array("message_text" => "", "message_publication" => $id_publication));
        }

        return true;
    }

    public static function checkIfMessages($user_id) {
        $model = new messagesModel();
        $messages = $model->find("messages.id_user_destination = ". $user_id . " AND messages.message_readed = 0");
        
        if($messages) {
            $messages_no_read = count($messages);
            if($messages_no_read >= gc::getSetting("notifications_max_count")) {
                $messages_no_read = gc::getSetting("notifications_max_count");
            }

            return $messages_no_read;
        }

        return 0;
    }
}

?>