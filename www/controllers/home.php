<?php
    require_once("cards/framework/globalController.php");
    $error = array();

    if(!isset($_SESSION["iduser"])){
        header("Location: /login");
    }

    if(isset($_POST["command_publish"]) && $_POST["command_publish"]){
        $validator = new dataValidator();

        if(!$validator->value($_POST["publication"]["publication_message"])->notEmpty()->sanitizeAlphanumeric()->validate()){
            $error[] = "El mensaje no es valido, vuelve a probar.";
        }
        
        if(!count($error) && publicationService::addPublication($_SESSION["iduser"], $_POST, $_FILES["publication"])){
            header("Location: /");
        } else {
            header("Location: /?error=1");
        }
    }

    if(isset($_POST["commandFollowSuggested"]) && $_POST["commandFollowSuggested"]){
        if(userService::followUser($_SESSION["iduser"], $_POST["commandFollowSuggested"])){
            header("Location: /?success=1");
        }
    }
    
    $publications = publicationService::findPublicationsFeed($_SESSION["iduser"]);

    $suggested_users = userService::getSuggestedUsers($_SESSION["iduser"]);
?>