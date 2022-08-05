<?php
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Tournaments.php";

    $obj= new tournaments;

    if(isset($_POST["tournament_id"])){
        $datos=array(   
            $_POST['tournament_id']
        );

        echo $obj->getRoundByTournamentId($datos);
    }

?>