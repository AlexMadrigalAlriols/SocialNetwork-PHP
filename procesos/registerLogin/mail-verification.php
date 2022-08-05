<?php 
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Usuarios.php";

    $obj = new usuarios();

    $datos=array(    
        $_POST['id_verification']
    );

    echo $obj->mail_verification($datos);
?>