<?php
    require_once("cards/framework/globalController.php");
    echo publicationService::likePublication($_SESSION["iduser"], $_POST["id_publication"]);
?>