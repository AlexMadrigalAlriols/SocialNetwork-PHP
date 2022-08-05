<?php
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Tournaments.php";

    $obj= new tournaments;

    if(isset($_POST["round_id"])){
        $datos=array(   
            $_POST['game_status'],
            $_POST['opponent_deck'],
            $_POST["round_id"]
        );

        echo $obj->updateRound($datos);
    } else {
        $datos=array(   
            $_POST['game_status'],
            $_POST['opponent_deck'],
            $_POST['tournament_id']
        );

        echo $obj->addRound($datos);
    }

?>