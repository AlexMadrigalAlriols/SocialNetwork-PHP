<?php
require_once("cards/framework/globalController.php");

$pages = 0;

if(!isset($_SESSION["iduser"])){
    header("Location: /login");
}
if(!isset($id_page)){
    header("Location: /cards/0");
}

if(isset($_POST["command_import"]) && $_POST["import_cards"]) {
    if(cardService::importCards($_POST["import_cards"], $_SESSION["iduser"])) {
        header("Location: /cards/0?success=import");
    }
}

$cards = cardService::getAllCardsByUser($_SESSION["iduser"], $id_page * gc::getSetting("cards.numPerPage"), gc::getSetting("cards.numPerPage"), $_GET);

if(count($cards)){
    $pages = cardService::getPager($_SESSION["iduser"], $_GET);
    if($pages <= $id_page){
        header("Location: /cards/0");
    }
}
?>