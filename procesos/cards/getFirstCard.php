<?php 
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Cards.php";

    if(isset($_GET['searchercard'])) {
        $obj= new cards;

        if(isset($_GET["format"])) {
            $datos=array(   
                $_GET['searchercard'],
                $_GET["format"]
            );
        } else {
            $datos=array(   
                $_GET['searchercard']
            );
        }

        
        echo $obj->getFirstCard($datos);
    }
    
?>