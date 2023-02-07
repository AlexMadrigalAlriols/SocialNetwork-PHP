<?php
    require_once("cards/framework/globalController.php");
    require_once('cards/assets/vendor/GoogleApi/vendor/autoload.php');
    require_once('cards/framework/libs/discordAuth/discord.php');
    require_once('cards/framework/libs/twitterAuth/twitterAuth.php');

    $user = &fwUser::getInstance();

    if($user->get("id_user") !== null){
        header("Location: /");
    }
    $twitter = new Twitter_Client();

    $discord = new Discord_Client(gc::getSetting("discord.clientId"), gc::getSetting("discord.clientSecret"),
        gc::getSetting("site.url") . '/login?discord=1', gc::getSetting("discord.scopes"));

    $client = new Google_Client();
    $client->setClientId(gc::getSetting("google.clientId"));
    $client->setClientSecret(gc::getSetting("google.clientSecret"));
    $client->setRedirectUri(gc::getSetting("site.url") . '/login');
    $client->addScope("email");
    $client->addScope("profile");

    if (!isset($_GET["discord"]) && isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);
        
        // get profile info 
        $google_oauth = new Google_Service_Oauth2($client);
        $user = $google_oauth->userinfo->get();

        $request = array(
            "external_id" => $user->id,
            "email" => $user->email,
            "name"  => substr($user->name, 0, gc::getSetting("validators.name_length")),
            "username"  => substr(str_replace(' ', '', $user->name), 0, gc::getSetting("validators.name_length")),
            "verified"  => ($user->verifiedEmail ? 1 : 0),
            "profile_image"   => $user->picture
        );

        if(userService::externalLogin($request)) {
            header("Location: /");
        }
    } else if (isset($_GET["discord"]) && isset($_GET['code'])) {
        if($discord->init($_GET['code'], $_GET['state'])) {
            if($user = $discord->get_user()) {
                $request = array(
                    "external_id" => $user["id"],
                    "email" => $user["email"],
                    "name"  => ($user["display_name"] ? substr($user["display_name"], 0, gc::getSetting("validators.name_length")): substr($user["username"], 0, gc::getSetting("validators.username_length"))),
                    "username"  => substr($user["username"], 0, gc::getSetting("validators.username_length")),
                    "verified"  => $user["verified"],
                    "profile_image"   => "https://cdn.discordapp.com/avatars/" . $user["id"] . "/" . $user["avatar"] . Discord_Client::is_animated($user["avatar"])
                );

                if(userService::externalLogin($request)) {
                    header("Location: /");
                }
            }
        } else {
            header("Location: /login?error=1");
        }
    } else if(isset($_GET["oauth_token"]) && isset($_GET["oauth_verifier"])) {
        if($user = $twitter->getLogin($_GET["oauth_token"], $_GET["oauth_verifier"])) {
            $request = array(
                "external_id" => $user->id,
                "email" => $user->email,
                "name"  => ($user->name ? substr($user->name, 0, gc::getSetting("validators.name_length")) : substr($user->screen_name, 0, gc::getSetting("validators.name_length"))),
                "username"  => substr($user->screen_name, 0, gc::getSetting("validators.username_length")),
                //"verified"  => ($user->needs_phone_verification ? 0 : 1),
                "biography"  => ($user->description ? $user->description : "Your Biography"),
                "profile_image"   => ($user->profile_image_url_https ? $user->profile_image_url_https : $user->profile_image_url)
            );
            if(userService::externalLogin($request)) {
                header("Location: /");
            }
        }
    }

    if(isset($_POST["commandRegister"])){
        $response = userService::registerUser($_POST);

        if(!is_array($response)){
            header("Location: /");
        } else if(is_array($response)) {
            $_POST["error"] = $response[0];
            unset($_POST["password"], $_POST["commandRegister"], $_POST["Cpassword"]);
            header("Location: /register?" . http_build_query($_POST));
        } else {
            header("Location: /logout");
        }
    }

    if(isset($_POST["commandLogin"])){
        if(userService::loginUser($_POST)){
            header("Location: /");
        } else {
            header("Location: /login?error");
        }
    }

    
    if(isset($_POST["commandForgot"])){
        if(userService::forgotPassword($_POST)){
            header("Location: /forgot-password?success");
        } else {
            header("Location: /forgot-password?error");
        }
    }
?>