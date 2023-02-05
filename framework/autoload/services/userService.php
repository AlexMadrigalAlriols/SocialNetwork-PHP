<?php
class userService{
    public static function getUserDetails($userId){
        $model = new userModel();
        $userDetails = $model->findById($userId);
        $userDetails["links"] = json_decode($userDetails["links"], true);

        return $userDetails;
    }

    public static function getUserByUsername($username) {
        $model = new userModel();
        $userDetails = $model->findOne("users.username = '". $username . "'");

        return $userDetails;
    }

    public static function loginUser($request, $register = false, $no_password = false){
        $model = new userModel();
        if($register) {
            $password= $request["password"];
        } else {
            $password=sha1($request["password"]);
        }
        
        $email = $request["email"];
        if(!$no_password) {
            $result = $model->findOne("users.email = '$email' AND users.password='$password'");
        } else {
            $result = $model->findOne("users.external_id = '". $request['external_id'] ."'");
        }

        if(isset($result["user_id"])) {
            $data = array("id_user" => $result["user_id"], "admin" => $result["admin"]);
            
			if ($data) {
				if(userService::setUserSession($data)) {
                    if($model->update($result["user_id"], array("last_login" => date('Y-m-d H:i:s'), "last_ip" => $_SERVER['REMOTE_ADDR']))) {
                        if(isset($result["last_ip"]) && $result["last_ip"] != null && $result["last_ip"] != $_SERVER['REMOTE_ADDR']) {
                            $mailer = new fwMailer();
                            $browser = get_browser(null, true);
                            $body = fwHtmlTemplate::render(PATH_GLOBAL_AUTO . "templates/email/login_other_Ip_en.php", array("username" => $result["username"], "ip" => $_SERVER['REMOTE_ADDR'], "os" => $browser["platform"], "browser" => $browser["browser"]));

                            $mailer->sendMail(array("email" => $result["email"], "name" => $result["name"]), "[MTGCollectioner] New Login", $body);
                        }
                    }
                    return true;
                }
			}
        }

        return false;
    }	
    
    public static function setUserSession($user_data) {
		$user = &fwUser::getInstance();
        
		$user->set(array(
			"id_user" 			=> $user_data["id_user"],
            "locale"            => "en",
			"admin"				=> $user_data["admin"]
		));

        return true;
	}

    public static function registerUser($request){
            $model = new userModel();
            $request["fechaCaptura"] = date('Y-m-d H:i:s');
            $request["verify_code"]  = userService::gen_verify_code();
            
            if($request["password"] == $request["Cpassword"] && strlen($request["password"]) >= gc::getSetting("validators.password_length")){
                $request["password"] = sha1($request["password"]);
                unset($request["Cpassword"]);
                unset($request["commandRegister"]);
            } else {
                return array("Password");
            }

            if($model->findOne("users.username = '". $request["username"] ."'")) {
                return array("Username");
            }

            if($model->create($request)){
                $mailer = new fwMailer();
                $body = fwHtmlTemplate::render(PATH_GLOBAL_AUTO . "templates/email/verification_email_en.php", array("username" => $request["username"], "verify_code" => $request["verify_code"]));

                $mailer->sendMail(array("email" => $request["email"], "name" => $request["name"]), "Welcome to MTGCollectioner", $body);

                if(userService::loginUser($request, true)){
                    return 1;
                }
            } else {
                return array("Email");
            }
            
            return 3;
    }

    public static function externalLogin($request) {
        $model = new userModel();

        if($result = $model->findOne("users.external_id = '" . $request['external_id'] ."' OR users.email = '" . $request['email'] . "'")) {
            if(isset($result["user_id"])) {
                if($result["external_id"] == null) {
                    $model->update($result["user_id"], array("external_id" => $request['external_id']));
                }

                if(userService::loginUser($result, true, true)){
                    return 1;
                }
            }
        } else {
            $request["fechaCaptura"] = date('Y-m-d H:i:s');
            $request["verify_code"]  = userService::gen_verify_code();

            while(userService::checkForUsernameExists($request["username"])) {
                $request["username"] .= rand(0, 9);
            }

            if($user_id = $model->create($request)) {
                $result = $model->findOne("users.user_id = " . $user_id);

                if($result && !$result["verified"]) {
                    $mailer = new fwMailer();
                    $body = fwHtmlTemplate::render(PATH_GLOBAL_AUTO . "templates/email/verification_email_en.php", array("username" => $result["username"], "verify_code" => $result["verify_code"]));
    
                    $mailer->sendMail(array("email" => $result["email"], "name" => $result["name"]), "Welcome to MTGCollectioner", $body);
                }
                
                $data = array("id_user" => $user_id, "admin" => false);
                if ($data) {
                    if(userService::setUserSession($data)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public static function forgotPassword($request) {
        $model = new userModel();

        if($user = $model->findOne("users.email = '" . $request['email'] . "'")){
            $mailer = new fwMailer();
            $body = fwHtmlTemplate::render(PATH_GLOBAL_AUTO . "templates/email/forgot_password_en.php", array("username" => $user["username"], "verify_code" => $user["verify_code"], "id_user" => $user["user_id"]));

            if($mailer->sendMail(array("email" => $user["email"], "name" => $user["name"]), "[MTG Collectioner] Change Password", $body)) {
                return true;
            }
        }

        return false;
    }

    public static function followUser($user_id, $userToFollow){
        $model = new userModel();
        $user_details = $model->findOne("user_id = ".$user_id, null, array("followed"));
        $user_details = json_decode($user_details["followed"], true);

        if(count($user_details) == 0){
            $user_details = array("1" => $userToFollow);
        } else {
            if(!in_array($userToFollow, $user_details)){
                array_push($user_details, $userToFollow);
            }
        }
        $user_details = array("followed" => json_encode($user_details));

        // Update Followers Of Followed User
        if($model->update($user_id, $user_details)){
            $user_details = $model->findOne("user_id = ".$userToFollow, null, array("followed"));
            $followers = json_decode($user_details["followed"], true);

            if(count($followers) == 0){
                $followers = array("1" => $user_id);
            } else {
                if(!in_array($user_id, $followers)){
                    array_push($followers, $user_id);
                }
            }

            $user_details = array("followed" => json_encode($followers));

            if($model->update($userToFollow, $user_details)){
                if(count($followers) >= 1000) {
                    badgeService::setUserBadges($user_id, "1000_followers");
                }

                if(count($followers) >= 10000) {
                    badgeService::setUserBadges($user_id, "10000_followers");
                }

                if(count($followers) >= 100000) {
                    badgeService::setUserBadges($user_id, "100000_followers");
                }

                notificationService::notificationTrigger($userToFollow, NOTIFICATION_TYPE_FOLLOWED, $user_id);
                return 1;
            }
        }

        return 0;
    }

    public static function unfollowUser($userId, $userToFollow){
        $model = new userModel();
        $user_details = $model->findOne("user_id = ".$userId, null, array("followed"));
        $user_details = json_decode($user_details["followed"], true);

        if(count($user_details) != 0){
            if(in_array($userToFollow, $user_details)){
                unset($user_details[array_search($userToFollow, $user_details)]);
            }
        }
        $user_details = array("followed" => json_encode($user_details));

        // Update Followers Of Followed User
        if($model->update($userId, $user_details)){
            $user_details = $model->findOne("user_id = ".$userToFollow, null, array("followed"));
            $user_details = json_decode($user_details["followed"], true);

            if(count($user_details) != 0){
                if(in_array($userId, $user_details)){
                    unset($user_details[array_search($userId, $user_details)]);
                }
            }
            $user_details = array("followed" => json_encode($user_details));

            if($model->update($userToFollow, $user_details)){
                return 1;
            }
        }

        return 0;
    }

    public static function saveSettings($userId, $request, $files = false){
        $model = new userModel();
        $validator = new dataValidator();
        $error = array();
        $user_data = $model->findById($userId);

        if (isset($request["commandUpdateProfile"])) {
            /*---------- VALIDATIONS -----------------*/
            if (!$request["name"] = $validator->value($request["name"])->notEmpty()->sanitizeAlphanumeric()->maxLength(18)->validate()) {$error[] = "name";}
            if (!$request["username"] = $validator->value($request["username"])->notEmpty()->username()->maxLength(15)->validate()) {$error[] = "username";}
            if (!$request["biography"] = $validator->value($request["biography"])->notEmpty()->maxLength(250)->validate()) {$error[] = "biography";}
            $request["links"]["website"] = ($request["links"]["website"] ? $validator->value($request["links"]["website"])->url()->validate() : "");
            $request["ubication"]["street"] = $validator->value($request["ubication"]["street"])->sanitizeAlphanumeric()->maxLength(250)->validate();
            $request["ubication"]["city"] = $validator->value($request["ubication"]["city"])->sanitizeAlphanumeric()->maxLength(50)->validate();
            $request["ubication"]["state"] = $validator->value($request["ubication"]["state"])->sanitizeAlphanumeric()->maxLength(50)->validate();
            /*---------- END VALIDATIONS -----------------*/

            $request["ubication"] = json_encode($request["ubication"]);
            $request["links"] = json_encode($request["links"]);
            
            if (isset($files["name"]["profile_image"]) && $files["error"]["profile_image"] == 0) {
                $request["profile_image"] = "/". gc::getSetting("upload.img.path") . fwFiles::uploadFiles($files, "profile_image");
            }

            if (isset($files["name"]["profile_cover"]) && $files["error"]["profile_cover"] == 0) {
                $url = fwFiles::uploadFiles($files, "profile_cover");

                if($url != "none"){
                    $request["profile_cover"] = gc::getSetting("upload.img.path") . $url;
                }
            }
            
            unset($request["commandUpdateProfile"]);
        } else if(isset($request["commandUpdateUser"])) {
             /*---------- UPDATE EMAIL/PASSWORD -----------------*/
            if ($user = $model->load($userId)) {
                if ($user["password"] == null || $user["password"] == sha1($request["password"])) {
                    $user = $model->findOne("users.email = '" . $request['email'] . "'");
                    if ($user || !$request["email"] = $validator->value($request["email"])->notEmpty()->email()->validate()) {$error[] = "email";}

                    if ($request["newpassword"] != "") {
                        if (strlen($request["newpassword"]) >= gc::getSetting("validators.password_length") && sha1($request["newpassword"]) == sha1($request["cpassword"])) {
                            $request["password"] = sha1($request["newpassword"]);
                        } else {
                            $error[] = "newpassword";
                        }
                    } else {
                        unset($request["password"]);
                    }
                    unset($request["newpassword"]);
                    unset($request["cpassword"]);
                    unset($request["commandUpdateUser"]);

                    if(!count($error)) {
                        $mailer = new fwMailer();
                        $body = fwHtmlTemplate::render(PATH_GLOBAL_AUTO . "templates/email/change_settings_en.php", array("username" => $user["username"], "verify_code" => $user["verify_code"]));
        
                        $mailer->sendMail(array("email" => $user["email"], "name" => $user["name"]), "[MTGCollectioner] Account Changes", $body);
                    }
                } else {
                    $error[] = "password";
                }
            }
        } else if(isset($request["commandUpdateShop"])) {
            unset($request["commandUpdateShop"]);

            $request["shop_config"]["shop"] = ($request["shop_config"]["shop"] == "on" ? 1 : 0);
            $old_config = json_decode($user_data["shop_config"], true);

            if (isset($files["name"]["shop_img"]) && $files["name"]["shop_img"] != "" && $files["error"]["shop_img"] == 0) {
                $url = fwFiles::uploadFiles($files, "shop_img");

                if($url != "none"){
                    $request["shop_config"]["shop_img"] = gc::getSetting("upload.img.path") . $url;
                }
            }
            
            $request["shop_config"] = json_encode(array_merge($old_config, $request["shop_config"]));
        }
        
        if(!count($error)){
            if($model->update($userId, $request)){
                badgeService::setUserBadges($userId, "get_ready_profile");
                return 1;
            } else {
                return 0;
            }
        }

        return $error;
    }

    public static function uploadNewCover($userId, $files){
        $model = new userModel();

        $url = fwFiles::uploadFiles($files, "newProfileCover");
        if($url != "none"){
            $request["profile_cover"] = gc::getSetting("upload.img.path") . $url;

            if ($model->update($userId, $request)) {
                return 1;
            } else {
                return 0;
            }
        }

        return 0;
    }

    public static function blockUser($userId, $userToBlock){
        $model = new userModel();
        $user_details = $model->load($userId, array("blocked_users"));
        $user_details = json_decode($user_details["blocked_users"], true);

        if(count($user_details) == 0){
            $user_details = array("1" => $userToBlock);
        } else {
            if(!in_array($userToBlock, $user_details)){
                array_push($user_details, $userToBlock);
            }
        }
        $user_details = array("blocked_users" => json_encode($user_details));
        userService::unfollowUser($userId, $userToBlock);   
        userService::unfollowUser($userToBlock, $userId); 

        return $model->update($userId, $user_details);
    }

    public static function unblockUser($userId, $userToUnBlock){
        $model = new userModel();
        $user_details = $model->load($userId, array("blocked_users"));
        $user_details = json_decode($user_details["blocked_users"], true);

        if(count($user_details) != 0){
            if(in_array($userToUnBlock, $user_details)){
                unset($user_details[array_search($userToUnBlock, $user_details)]);
            }
        }

        $user_details = array("blocked_users" => json_encode($user_details));

        return $model->update($userId, $user_details);
    }

    public static function getSuggestedUsers($userId){
        $model = new userModel();
        $randomNumbers = array();
        $suggestedUsers = array();
        
        $users = $model->find("1=1");

        for ($i=0; $i < 3; $i++) { 
            $number = random_int(0, count($users));

            if(!in_array($number, $randomNumbers)){
                $randomNumbers[] = $number;
                if(isset($users[$number])){
                    $suggestedUsers[] = ($users[$number]);
                } else {
                    $i--;
                }
                
            } else {
                $i--;
            }
        }

        return $suggestedUsers;
    }

    public static function searchUserInputBar($user_id, $input){
        $model = new userModel();
        $users = $model->find("(users.username like '%".$input."%' OR users.name like '%".$input."%') AND users.user_id != ".$user_id, null, 0, 8, array("user_id", "username", "name", "profile_image"));

        foreach ($users as $idx => $user) {
            if(userService::isUserBlocked($user_id, $user["user_id"])) {
                array_splice($users, $idx, 1);
            }
        }
        
        return json_encode($users);
    }

    public static function banUser($id_user){
        $model = new userModel();
        if(publicationService::deleteAllPublications($id_user) && $model->delete($id_user)){
            return 1;
        }

        return 0;
    }

    public static function isUserBlocked($user_id, $userToCheck){
        if($userToCheck == null || $user_id == null){
            return 1;
        }

        $model = new userModel();
        $result = $model->findOne("users.user_id = ".$userToCheck, null, array("blocked_users"));

        $blocked_users = json_decode($result["blocked_users"], true);

        if($blocked_users && count($blocked_users) && in_array($user_id, $blocked_users)){
            return 1;
        }

        return 0;
    }

    public static function changePassword($request, $verify_code) {
        $model = new userModel();
        if(strlen($request["password"]) < gc::getSetting("validators.password_length") && sha1($request["password"]) != sha1($request["cpassword"]))  {
            return false;
        }
        
        $user = $model->findOne("verify_code = '" . $verify_code . "'", null);

        if($model->update($user["user_id"], array("users.password" => sha1($request["password"])))) {
            $mailer = new fwMailer();
            $body = fwHtmlTemplate::render(PATH_GLOBAL_AUTO . "templates/email/change_settings_en.php", array("username" => $user["username"], "verify_code" => $user["verify_code"], "id_user" => $user["user_id"]));
    
            $mailer->sendMail(array("email" => $user["email"], "name" => $user["name"]), "[MTGCollectioner] Account Changes", $body);

            return true;
        }

        return false;
    }

    public static function verifyUser($id, $actual_user) {
        $model = new userModel();
        $user = $model->findOne("users.verify_code = '".$id . "'", null, array("user_id"));

        if($actual_user == $user["user_id"]) {
            if($model->update($user["user_id"], array("verified" => 1))) {
                return true;
            }
        }

        return false;
    }

    public static function checkForVerifyCode($verify_code) {
        $model = new userModel();

        if($model->findOne("users.verify_code = '" . $verify_code . "'")) {
            return true;
        }

        return false;
    }

    // Verificado del simbolito no del email
    public static function checkIfAccountVerified($id_user) {
        $model = new userModel();

        if($user = $model->findOne("user_id = " . $id_user, null, array('settings'))) {
            if($settings = json_decode($user['settings'], true)) {
                if(isset($settings["verified"]) && $settings["verified"]) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function checkForUsernameExists($username) {
        $model = new userModel();

        if($user = $model->findOne("users.username = '" . $username . "'", null, array("username"))) {
            return true;
        }

        return false;
    }

    // Misc
    public static function gen_verify_code() {
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