<?php
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Tournaments.php";

    $obj= new tournaments;

    if(isset($_POST["round_id"])){
        $datos=array(   
            $_POST['round_id']
        );

        echo $obj->getGamesByRoundId($datos);
    }

?>