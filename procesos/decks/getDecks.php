<?php
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Decks.php";

    $obj= new decks;
    if(isset($_POST['deckName'])) {

        echo $obj->getDeckByName($_POST['deckName'], $_POST['userId']);
    } else if(isset($_POST['deckId'])) {
        
        echo $obj->getDeckById($_POST['deckId']);
    } else if(isset($_POST['name']) || isset($_POST['format'])){
        $name = "none";
        $format = "none";
        
        $datos=array(   
            $_POST['userId'],
            $_POST['startFrom'],
            $_POST['numPerPage']
        );

        if(isset($_POST['name']) && $_POST['name'] != ""){
            $name = $_POST['name'];
        }

        if(isset($_POST['format']) && $_POST['format'] != ""){
            $format = $_POST['format'];
        }

        echo $obj->getDetailsByName($datos, $name, $format);
    } else {
        $datos=array(   
            $_POST['userId'],
            $_POST['startFrom'],
            $_POST['numPerPage']
        );

        echo $obj->getAllDecks($datos);
    }
?>