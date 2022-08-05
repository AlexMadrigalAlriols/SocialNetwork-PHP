<?php
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Tournaments.php";

    $obj= new tournaments;

    if(isset($_POST["tournament_id"])){
        $datos=array(   
            $_POST['tournament_id']
        );

        echo $obj->getTournamentById($datos);
    }else{
        $name = 'none';
        $location = 'none';
        $date = 'none';
        $deck_id = 'none';

        $datos=array(   
                $_POST['userId'],
                $_POST['startFrom'],
                $_POST['numPerPage']
        );

        if(isset($_POST['name']) && $_POST['name'] != ""){
            $name = $_POST['name'];
        }

        if(isset($_POST['location']) && $_POST['location'] != ""){
            $location = $_POST['location'];
        }

        if(isset($_POST['date']) && $_POST['date'] != ""){
            $date = $_POST['date'];
        }

        if(isset($_POST['deck_id']) && $_POST['deck_id'] != ""){
            $deck_id = $_POST['deck_id'];
        }

        echo $obj->getAllTournaments($datos, $name, $location, $date, $deck_id);
    }

?>