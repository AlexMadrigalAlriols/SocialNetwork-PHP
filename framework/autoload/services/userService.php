<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'cards/assets/vendor/PHPMailer/src/Exception.php';
    require 'cards/assets/vendor/PHPMailer/src/PHPMailer.php';
    require 'cards/assets/vendor/PHPMailer/src/SMTP.php';

class userService{
    public static function getUserDetails($userId){
        $model = new userModel();
        $userDetails = $model->findById($userId);
        
        return $userDetails;
    }

    public static function getUserByUsername($username) {
        $model = new userModel();
        $userDetails = $model->findOne("users.username = '". $username . "'");

        return $userDetails;
    }

    public static function loginUser($request, $register = false){
        $model = new userModel();
        if($register) {
            $password= $request["password"];
        } else {
            $password=sha1($request["password"]);
        }
        
        $email = $request["email"];
        $result = $model->findOne("users.email = '$email' AND users.password='$password'");

        if(isset($result["user_id"])) {
            $data = array("id_user" => $result["user_id"], "admin" => $result["admin"]);

			if ($data) {
				userService::setUserSession($data);

				return 1;
			}
        }

        return 0;
    }	
    
    public static function setUserSession($user_data) {
		$user = &fwUser::getInstance();
        
		$user->set(array(
			"id_user" 			=> $user_data["id_user"],
            "locale"            => "en",
			"admin"				=> $user_data["admin"]
		));
	}

    public static function registerUser($request){
            $model = new userModel();
            $request["fechaCaptura"] = date('Y-m-d');
            $request["verify_code"]  = userService::gen_verify_code();
            
            if($request["password"] == $request["Cpassword"]){
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
                $mail = new PHPMailer(true);

                try {               
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'alex25005.lleida@gmail.com';                     //SMTP username
                    $mail->Password   = 'kuqfygvzxeehygzy';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                    //Recipients
                    $mail->setFrom('alex25005.lleida@gmail.com', 'Collection Saver');
                    $mail->addAddress($request["email"], $request["name"]);     //Add a recipient
                
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Collection Saver: E-mail verification';
                    $mail->Body    = '<body style="background-color: #3f3f3f; color: white;"><i class="bx bx-layer"></i> <h2 style="margin: 20px; padding: 15px;">Collection Saver</h2>
                        <center><h2><span style="background-color: #4723D9; color: white;">Welcome Alex</span>, lets get started!</h2></br>
                        <h3 style="font-weight: normal;">You have to click the button below to verificate your account:</h3></br>
                        <a href="http://localhost:8080/dashboard/'.$request["verify_code"].'" style="background-color: #4723D9;
                            border: none;
                            color: white;
                            padding: 13px 28px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 16px;
                            margin: 4px 2px;
                            cursor: pointer;">¡Click here!</a>
                        </center>
                        <div style="background-color: #3f3f3f; color: white; margin: 20px;">
                            <div style="margin-top: 4rem; background-color: #3f3f3f; color: white;">
                                <p>Best regards,</p>
                                <p>Collection Saver team</p>
                                <p>https://collectionsaver.com</p>
                                <p>info@collectionsaver.com</p>
                            </div>
                        </div>
                        <center style="padding-bottom: 3rem;">
                            <hr>
                            <h3 style="margin-top: 1rem;">Follow Us:</h3>
                            <div>
                                <span style="margin-right: 2rem;">Instagram</span> 
                                <span style="margin-right: 2rem;">Twitter</span> 
                                <span>Discord</span>
                            </div>
                        </center>
                    </body>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                
                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }    

                if(userService::loginUser($request, true)){
                    return 1;
                }
            } else {
                return array("Email");
            }
            
            return 3;
    }

    public static function followUser($userId, $userToFollow){
        $model = new userModel();
        $user_details = $model->findOne("user_id = ".$userId, null, array("followed"));
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
        if($model->update($userId, $user_details)){
            $user_details = $model->findOne("user_id = ".$userToFollow, null, array("followed"));
            $user_details = json_decode($user_details["followed"], true);

            if(count($user_details) == 0){
                $user_details = array("1" => $userId);
            } else {
                if(!in_array($userId, $user_details)){
                    array_push($user_details, $userId);
                }
            }
            $user_details = array("followed" => json_encode($user_details));

            if($model->update($userToFollow, $user_details)){
                notificationService::notificationTrigger($userToFollow, NOTIFICATION_TYPE_FOLLOWED, $userId);
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
            if (!$request["name"] = $validator->value($request["name"])->notEmpty()->sanitizeAlphanumeric()->validate()) {$error[] = "name";}
            if (!$request["username"] = $validator->value($request["username"])->notEmpty()->username()->validate()) {$error[] = "username";}
            if (!$request["biography"] = $validator->value($request["biography"])->notEmpty()->validate()) {$error[] = "biography";}

            $request["website"] = ($request["website"] ? $validator->value($request["website"])->url()->validate() : "");
            $request["cardmarket_link"] = ($request["cardmarket_link"] ? $validator->value($request["cardmarket_link"])->url()->validate() : "");
            
            if (isset($files["name"]["profile_image"]) && $files["error"]["profile_image"] == 0) {
                $request["profile_image"] = gc::getSetting("upload.img.path") . fwFiles::uploadFiles($files, "profile_image");
            }

            if (isset($files["name"]["profile_cover"]) && $files["error"]["profile_cover"] == 0) {
                $url = fwFiles::uploadFiles($files, "profile_cover");

                if($url != "none"){
                    $request["profile_cover"] = gc::getSetting("upload.img.path") . $url;
                }
            }
            /*---------- END VALIDATIONS -----------------*/
            unset($request["commandUpdateProfile"]);
        } else if(isset($request["commandUpdateUser"])) {
             /*---------- UPDATE EMAIL/PASSWORD -----------------*/
            if ($user = $model->load($userId)) {
                if ($user["password"] == sha1($request["password"])) {
                    if (!$request["email"] = $validator->value($request["email"])->notEmpty()->email()->validate()) {$error[] = "email";}

                    if ($request["newpassword"] != "") {
                        if (sha1($request["newpassword"]) == sha1($request["cpassword"])) {
                            $request["password"] = sha1($request["newpassword"]);
                        } else {
                            $error[] = "new_password";
                        }
                    } else {
                        unset($request["password"]);
                    }
                    unset($request["newpassword"]);
                    unset($request["cpassword"]);
                    unset($request["commandUpdateUser"]);
                } else {
                    $error[] = "password";
                }
            }
        } else if(isset($request["commandUpdateShop"])) {
            unset($request["commandUpdateShop"]);

            $request["shop"] = ($request["shop"] == "on" ? 1 : 0);
            $old_config = json_decode($user_data["shop_config"], true);

            if (isset($files["name"]["shop_img"]) && $files["name"]["shop_img"] != "" && $files["error"]["shop_img"] == 0) {
                $url = fwFiles::uploadFiles($files, "shop_img");

                if($url != "none"){
                    $request["shop_config"]["shop_img"] = gc::getSetting("upload.img.path") . $url;
                }
            }

            $request["shop_config"] = json_encode(array_merge($request["shop_config"], $old_config));
        }
        
        if(!count($error)){
            if($model->update($userId, $request)){
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

        if(in_array($user_id, json_decode($result["blocked_users"], true))){
            return 1;
        }

        return 0;
    }

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