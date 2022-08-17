<?php 
require_once("cards/framework/globalController.php");

$pages = 0;

if(!isset($_SESSION["iduser"])){
    header("Location: /login");
}
if(!isset($id_page)){
    header("Location: /decks/0");
}

$decks = deckService::getAllDecksFromUser($_SESSION["iduser"], $id_page * gc::getSetting("cards.numPerPage"), gc::getSetting("cards.numPerPage"), $_GET);
$formats = array("") + gc::getSetting("formats");

if(count($decks)){
    $pages = deckService::getPager($_SESSION["iduser"], $_GET);
    if($pages <= $id_page){
        header("Location: /decks/0");
    }
}
?>