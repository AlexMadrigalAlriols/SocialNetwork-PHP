<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();

    if($user->get("id_user") !== null){
        header("Location: /");
    }

   /* /////// GOOGLE INICIO DE SESSION ///////
    if(!isset($_SESSION['login_id'])){
        require_once("cards/assets/vendor/google_login/login.php");
    }
    if(isset($_SESSION['login_id'])) {
        $c=new conectar();
        $conexion=$c->conexion();
        $id = $_SESSION['login_id'];
    
        $get_user = mysqli_query($conexion, "SELECT * FROM `users` WHERE `google_id`='$id'");
        
        if(mysqli_num_rows($get_user) > 0){
            $user = mysqli_fetch_assoc($get_user);
        } else {
            echo "logout";
            header('Location: /logout');
        }
    }*/

    if(isset($_POST["commandRegister"]) && $_POST["commandRegister"]){
        $response = userService::registerUser($_POST);

        if($response === 3) {
            header("Location: /login");
        }

        if(!is_array($response)){
            header("Location: /start-config");
        } else {
            header("Location: /register?error=".$response[0]);
        }
    }

    if(isset($_POST["commandLogin"]) && $_POST["commandLogin"]){
        if(userService::loginUser($_POST)){
            header("Location: /");
        } else {
            header("Location: /login?error");
        }
    }
?>