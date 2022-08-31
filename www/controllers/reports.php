<?php 
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();

    if($user->get("id_user") === null || !$user->get("admin")){
        header("Location: /");
    }

    if(isset($_GET["all"])){
        $reports = reportService::getAllReports();
    } else {
        $reports = reportService::getNotResolvedReports();
    }

    if(isset($_POST["command_accept"])) {
        if(reportService::acceptReport($_POST["command_accept"])){
            header("Location: /reports?success=1");
        }
    }

    if(isset($_POST["command_deny"])) {
        if(reportService::denyReport($_POST["command_deny"])){
            header("Location: /reports?success=1");
        }
    }
?>