<?php
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Decks.php";

    $obj= new decks;

    $datos=array(   
        $_POST['deckId']
    );

    echo $obj->deleteDeck($datos);
?>