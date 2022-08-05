<?php 
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Cards.php";

    $obj= new cards;

    $datos=array(   
        $_POST['cardId'],
        $_POST['cardName'],
        $_POST['userId'],
        $_POST['cardQty'],
        $_POST["cardDesc"],
        $_POST["userId"]
    );

    echo $obj->addCard($datos);
?>