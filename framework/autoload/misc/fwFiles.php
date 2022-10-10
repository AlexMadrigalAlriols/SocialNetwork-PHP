<?php
class fwFiles{
    public static function uploadFiles($file, $input_name){

        $target_dir = gc::getSetting("upload.img.path");
        $error = array();
        $imageType = explode("/",$file["type"][$input_name]);
        if(isset($imageType[1])) {
            $imageType = $imageType[1];
        } else {
            return "";
        }
        
        $file["name"][$input_name] = publicationService::generate_UUID(). "." . $imageType;
        $target_file = $target_dir . basename($file["name"][$input_name]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($file["tmp_name"][$input_name]);
        if($check === false) {
            $error[] = "File is not an image.";
        }

        if (file_exists($target_file)) {
            $error[] = "Sorry, file already exists.";
        }

        if ($file["size"][$input_name] > 1000000) {
            $error[] = "Sorry, your file is too large.";
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $error[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
        
        if (count($error) == 0) {
            if (move_uploaded_file($file["tmp_name"][$input_name], $target_file)) {
                return basename($file["name"][$input_name]);
            } else {
                $error[] = "Sorry, there was an error uploading your file.";
            }
        }
        

        return "none";
    }
}
?>