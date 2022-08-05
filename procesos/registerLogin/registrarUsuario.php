<?php 

    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Usuarios.php";

    $obj = new usuarios();

    $pass=sha1($_POST['password']);
    
    $datos=array(
        $_POST['name'],
        $_POST['email'],
        $pass,
        $_POST['username'],
        false
    );

    echo $obj->registroUsuario($datos);
?>