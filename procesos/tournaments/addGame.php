<?php
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Tournaments.php";

    $obj= new tournaments;

    if(isset($_POST["game_id"])){
        $datos=array(   
            $_POST['game_num'],
            $_POST['game_info'],
            $_POST['game_result'],
            $_POST["game_id"]
        );

        echo $obj->updateGame($datos);
    } else {
        $datos=array(   
            $_POST['game_num'],
            $_POST['game_info'],
            $_POST['game_result'],
            $_POST['round_id']
        );

        echo $obj->addGame($datos);
    }

?>