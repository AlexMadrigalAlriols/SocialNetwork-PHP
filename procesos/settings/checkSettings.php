<?php
    require_once "cards/framework/autoload/clases/Conexion.php";
    require_once "cards/framework/autoload/clases/Usuarios.php";

    $obj= new usuarios();

    $datos=array(   
        $_POST['userId']
    );

    echo $obj->checkSettings($datos);
?>