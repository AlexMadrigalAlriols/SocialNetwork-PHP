<?php 
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Cards.php";
    
    $obj= new cards;

    $datos=array(   
        $_POST['userid']
    );

    echo $obj->getCardsPerMonth($datos);
?>