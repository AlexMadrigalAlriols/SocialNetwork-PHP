<?php
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Tournaments.php";

    $obj= new tournaments;

    if(isset($_POST["tournament_id"])){
        $datos=array(   
            $_POST['userId'],
            $_POST['tournament_name'],
            $_POST['tournament_site'],
            $_POST['tournament_score'],
            $_POST['tournament_used_deck'],
            $_POST['tournament_format'],
            $_POST["tournament_id"]
        );

        echo $obj->updateTournament($datos);
    } else {
        $datos=array(   
            $_POST['userId'],
            $_POST['tournament_name'],
            $_POST['tournament_site'],
            $_POST['tournament_score'],
            $_POST['tournament_used_deck'],
            $_POST['tournament_format']
        );

        echo $obj->addTournament($datos);
    }

?>