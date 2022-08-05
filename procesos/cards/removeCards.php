<?php 
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Cards.php";

    $obj= new cards;

    $datos=array(   
        $_POST['cardId'],
        $_POST['userId'],
        $_POST['cardQty']
    );

    echo $obj->deleteCard($datos);
?>