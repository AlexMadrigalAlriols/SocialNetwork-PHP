<?php
    require_once("cards/framework/globalController.php");
    echo publicationCommentService::getComments($_POST["id_publication"], $_SESSION["iduser"]);
?>