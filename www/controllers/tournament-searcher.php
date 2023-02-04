<?php 
require_once("cards/framework/globalController.php");
$user = &fwUser::getInstance();
$pages = 0;
$tournaments = array();
$formats = gc::getSetting("formats");
$suggested_users = userService::getSuggestedUsers($user->get("id_user"));

if($user->get("id_user") === null){
    header("Location: /login");
}

if(isset($_POST["commandSearch"]) && trim($_POST["info"]) == "" 
    && trim($_POST["format"]) == "" && trim($_POST["date"]) == "") {
    header("Location: /tournament-searcher?error=1");
}

if(isset($_POST["commandSearch"])) {
    $tournaments = tournamentService::tournamentSearch($_POST);
}

?>