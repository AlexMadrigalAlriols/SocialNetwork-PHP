<?php
require_once("cards/framework/globalController.php");
$user = &fwUser::getInstance();
$pages = 0;

if($user->get("id_user") === null){
    header("Location: /login");
}

if(!isset($id_page)){
    header("Location: /cards/0");
}

if(isset($_POST["command_import"])) {
    if(cardService::importCards($_POST["import_cards"], $user->get("id_user"))) {
        header("Location: /cards/0?success=import");
    }
}

$cards = cardService::getAllCardsByUser($user->get("id_user"), $id_page * gc::getSetting("cards.numPerPage"), gc::getSetting("cards.numPerPage"), $_GET);

if(count($cards)){
    $pages = cardService::getPager($user->get("id_user"), $_GET);
    if($pages <= $id_page){
        header("Location: /cards/0");
    }
}
?>