<?php
    require_once("cards/framework/globalController.php");
    echo publicationCommentService::commentPublication($_SESSION["iduser"], $_POST);
?>