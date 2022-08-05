<?php
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Decks.php";

    $obj= new decks;

    if($_POST["deckId"] != -1) {
        $datos=array(
            $_POST['userId'],
            $_POST['nameDeck'],
            $_POST['format'],
            $_POST['deck_img'],
            $_POST['cards'],
            $_POST['private'],
            $_POST["totalPrice"],
            $_POST["tixTotal"],
            $_POST["deckId"]
        );
    } else {
        $datos=array(   
            $_POST['userId'],
            $_POST['nameDeck'],
            $_POST['format'],
            $_POST['deck_img'],
            $_POST['cards'],
            $_POST['private'],
            $_POST["totalPrice"],
            $_POST["tixTotal"]
        );
    }

    echo $obj->addDeck($datos);
?>