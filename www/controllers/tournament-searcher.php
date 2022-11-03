<?php 
require_once("cards/framework/globalController.php");
$user = &fwUser::getInstance();
$pages = 0;
$tournaments = array();
$formats = gc::getSetting("formats");

if($user->get("id_user") === null){
    header("Location: /login");
}

/*if(!isset($id_page)) {
    header("Location: /tournaments/0");
}*/

if(isset($_POST["commandSearch"])) {
    $tournaments = tournamentService::tournamentSearch($_POST);
}

?>