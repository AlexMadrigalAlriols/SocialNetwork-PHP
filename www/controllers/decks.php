<?php 
require_once("cards/framework/globalController.php");
$user = &fwUser::getInstance();
$pages = 0;

if($user->get("id_user") === null){
    header("Location: /login");
}

if(!isset($id_page)){
    header("Location: /decks/0");
}

$decks = deckService::getAllDecksFromUser($user->get("id_user"), $id_page * gc::getSetting("cards.numPerPage"), gc::getSetting("cards.numPerPage"), $_GET);
$formats = array("") + gc::getSetting("formats");

if(count($decks)){
    $pages = deckService::getPager($user->get("id_user"), $_GET);
    if($pages <= $id_page){
        header("Location: /decks/0");
    }
}
?>