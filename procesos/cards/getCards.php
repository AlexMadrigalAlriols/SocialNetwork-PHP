<?php 
    require_once "cards/clases/Conexion.php";
    require_once "cards/clases/Cards.php";

    if(isset($_POST['userId'])) {
        $obj= new cards;
        $name = "none";
        $info = "none";
        $colors = "all";

        $datos=array(   
            $_POST['userId'],
            $_POST['startFrom'],
            $_POST['numPerPage']
        );

        if(isset($_POST['name']) && $_POST['name'] != ""){
            $name = $_POST['name'];
        }

        if(isset($_POST['info']) && $_POST['info'] != ""){
            $info = $_POST['info'];
        }

        if(isset($_POST['colors']) && $_POST['colors'] != "all"){
            $colors = $_POST['colors'];
        }
    
        echo $obj->getAllCards($datos, $name, $info, $colors);
    } else if(isset($_POST['cardId'])) {
        $obj= new cards;

        $datos=array(
            $_POST['cardId']
        );
        
        echo $obj->getCard($datos);
    } else if(isset($_POST['cardName'])) {
        $obj= new cards;
        echo $obj->getPriceCard($_POST['cardName']);
    }
    
?>