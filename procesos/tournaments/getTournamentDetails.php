<?php
    require_once("cards/framework/globalController.php");
    $tournament = tournamentService::getTournamentById($_POST["id_tournament"]);
    $tournament["description"] = ($tournament["description"] ? $tournament["description"] : "No description found.");
    $tournament["start_date"] = date_format(date_create($tournament["start_date"]), "d/m/Y - H:i");
    $tournament["image"] = ($tournament["image"] ? "/cards/uploads/" . $tournament["image"] : "/cards/assets/img/placeholder.png");

    echo json_encode($tournament);
?>