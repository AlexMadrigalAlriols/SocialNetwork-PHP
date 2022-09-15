<?php

class messageService {
    public static function getMessageList($id_user){
        $model = new messagesModel();

        $messages = $model->find("messages.id_user = ".$id_user, "messages.date_sent DESC");

        $message_list = array();
        foreach ($messages as $idx => $message) {
            $esta = false;
            foreach ($message_list as $idx => $message_on_list) {
                if($message["id_user"] === $message_on_list["id_user"] && $message["id_user_destination"] === $message_on_list["id_user_destination"]) {
                    $esta = true;
                    
                }

            }

            if(!$esta) {
                $message_content = json_decode($message["message_content"], true);

                if(isset($message_content) && $message_content["message_txt"] != "") {
                    $message["message_text"] = $message_content["message_txt"];
                    $message_list[] = $message;
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

                if(isset($message_content) && $message_content["message_txt"] != "") {
                    $messages[$idx]["message_text"] = $message_content["message_txt"];
                }

                if(isset($message_content) && $message_content["message_img"] != "none") {
                    $messages[$idx]["message_img"] = $message_content["message_img"];
                }
            }
        }

        return $messages;
    }

    public static function sendMessage($id_sender, $id_receiver, $request) {
        $model = new messagesModel();

        $data = array(
            "id_user"   => $id_sender,
            "message_content" => json_encode(
                array("message_txt" => $request["message_text"], "message_img" => $request["message_image"])),
            "id_user_destination"   => $id_receiver
        );

        if($model->create($data)) {
            return true;
        }

        return false;
    }
}

?>