<?php
    require_once("cards/framework/globalController.php");
    echo publicationService::getPublicationDetails($_POST["id_publication"]);
?>