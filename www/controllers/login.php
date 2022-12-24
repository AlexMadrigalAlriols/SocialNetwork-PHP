<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();

    if($user->get("id_user") !== null){
        header("Location: /");
    }

    if(isset($_POST["commandRegister"])){
        $response = userService::registerUser($_POST);

        if($response === 3) {
            header("Location: /login?error=1");
        }

        if(!is_array($response)){
            header("Location: /");
        } else {
            header("Location: /register?error=".$response[0]);
        }
    }

    if(isset($_POST["commandLogin"])){
        if(userService::loginUser($_POST)){
            print_r("hola");
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