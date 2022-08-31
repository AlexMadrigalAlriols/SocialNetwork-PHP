<?php 
require_once("cards/framework/globalController.php");
$user = &fwUser::getInstance();

if($user->get("id_user") === null){
    header("Location: /login");
}

if(!isset($id_tournament)){
    header("Location: /tournaments/0");
}

if(isset($_POST["commandSave"])) {
    unset($_POST["commandSave"]);

    if($id_tournament) {
        if(tournamentService::editTournament($id_tournament, $_POST["tournament"], $user->get("id_user"), $_FILES["tournament"], $_POST["prices"])) {
            header("Location: /tournaments/0");
        }
    } else {
        if(tournamentService::createTournament($_POST["tournament"], $user->get("id_user"), $_FILES["tournament"], $_POST["prices"])) {
            header("Location: /tournaments/0");
        }
    }
}

if($id_tournament != 0) {
    $tournament = tournamentService::getTournamentById($id_tournament, $user->get("id_user"));
    $prices = json_decode($tournament["prices"], true);

    if(!$tournament) {
        header("Location: /tournaments/0");
    }
}

$formats = gc::getSetting("formats");

?>