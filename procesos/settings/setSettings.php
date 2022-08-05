<?php
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Usuarios.php";

    $obj= new usuarios();

    $datos=array(   
        $_POST['userId'],
        $_POST["value"]
    );

    echo $obj->setSettings($datos);
?>