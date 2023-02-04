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

if(isset($_POST["commandDownloadCover"])) {
    if(isset($_FILES["profile"])) {
        $file = fwFiles::uploadFiles($_FILES["profile"], "newProfileCover");
        if($file != "none") {
            header("Location: /get-tournament-image/" . $_POST["commandDownloadCover"] . "?img=" . urlencode($file). "&pcolor=" . urlencode($_POST["pcolor"]) . "&scolor=".urlencode($_POST["scolor"]));
        } else {
            header("Location: /tournaments/" . $id_page . "?error=size");
        }
    }
}

if(isset($_POST["commandDownloadCalendar"])) {
    header("Location: /get-calendar/" . $_POST["commandDownloadCover"] . "?img=" . urlencode($file). "&pcolor=" . urlencode($_POST["pcolor"]) . "&scolor=".urlencode($_POST["scolor"]));
}

$tournaments = tournamentService::getAllTournamentsByShop($user->get("id_user"), $id_page * gc::getSetting("cards.numPerPage"), gc::getSetting("cards.numPerPage"), $_GET);
$formats = gc::getSetting("formats");
$months = fwTime::getMonths($user);

if(count($tournaments)){
    $pages = tournamentService::getPager($user->get("id_user"), $_GET);
    if($pages <= $id_page){
        header("Location: /tournaments/0");
    }
}

?>