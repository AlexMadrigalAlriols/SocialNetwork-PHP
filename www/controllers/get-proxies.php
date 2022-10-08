<?php 
require_once("cards/framework/globalController.php");
$user = &fwUser::getInstance();

if($user->get("id_user") === null){
    header("Location: /login");
}

if($id_deck){
    $deck = deckService::getDeckDetails($id_deck);

    if(!$deck || ($deck["private"] && $deck["user_id"] != $user->get("id_user"))) {
        header("Location: /decks/0");
    }

    $cards = array();
    foreach (json_decode($deck["cards"], true) as $name => $qty) {
        $card = cardService::getFirstCardOfEdition($name);

        for ($i=0; $i < $qty; $i++) { 
            $cards[] = $card[0]["Card"]["Img"];
        }
    }

} else {
    header("Location: /decks/0");
}
?>