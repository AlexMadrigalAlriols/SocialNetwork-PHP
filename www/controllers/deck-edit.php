<?php 
require_once("cards/framework/globalController.php");
$user = &fwUser::getInstance();

if($user->get("id_user") === null){
    header("Location: /login");
}

$formats = gc::getSetting("formats");
$cards = "Deck\n";

if($id_deck){
    $deck = deckService::getDeckDetails($id_deck);

    if(!$deck || ($deck["private"] && $deck["user_id"] != $user->get("id_user"))) {
        header("Location: /decks/0");
    }

    foreach (json_decode($deck["cards"], true) as $cardName => $cardQty) {
        $cards .= $cardQty. " " .$cardName . "\n";
    }
    if(json_decode($deck["sideboard"], true)){
        $cards .= "Sideboard\n";
        foreach (json_decode($deck["sideboard"], true) as $cardName => $cardQty) {
            $cards .= $cardQty. " " .$cardName . "\n";
        }
    }

} else {
    $deck = array("name" => "", "format" => "Standard", "private" => 0);
}

?>