<?php 
require_once("cards/framework/globalController.php");
$user = &fwUser::getInstance();
$pages = 0;

if($user->get("id_user") === null){
    header("Location: /login");
}

if(!isset($id_page)) {
    header("Location: /tournaments/0");
}

if(isset($_POST["commandDelete"])) {
    if(tournamentService::deleteTournament($_POST["commandDelete"])) {
        header("Location: /tournaments/" . $id_page . "?success=remove");
    }
}
$tournaments = tournamentService::getAllTournamentsByShop($user->get("id_user"), $id_page * gc::getSetting("cards.numPerPage"), gc::getSetting("cards.numPerPage"), $_GET);

$formats = gc::getSetting("formats");

if(count($tournaments)){
    $pages = tournamentService::getPager($user->get("id_user"), $_GET);
    if($pages <= $id_page){
        header("Location: /tournaments/0");
    }
}

?>