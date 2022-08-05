<?php
    require_once("cards/framework/globalController.php");
    echo publicationService::likePublication($_POST["user_id"], $_POST["id_publication"]);
?>