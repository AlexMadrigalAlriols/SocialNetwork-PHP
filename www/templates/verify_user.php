<?php 
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();

    if($user->get("id_user") === null){
        header("Location: /login");
    }
    
    if(isset($verify_code) && $verify_code != "") {
        if(userService::verifyUser($verify_code, $user->get("id_user"))) {
            header("Location: /?verified=1");
        }
    }

    header("Location: /?verified=0");
?>

<html>

</html>