<?php

class deckService {
    public static function getAllDecksFromUser($user_id, $intOffset = false, $intCount = false, $filters = false) {
        $model = new deckModel();
        $validator = new dataValidator();

        $where = "decks.user_id = ". $user_id;
        
        if (isset($filters["name"]) && $filters["name"] = $validator->value($filters["name"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND decks.name LIKE '%". $filters["name"] ."%'"; 
        }

        if (isset($filters["format"]) && $filters["format"] = $validator->value($filters["format"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND decks.format = '". $filters["format"] ."'"; 
        }

        if (isset($filters["color"]) && $filters["color"] = $validator->value($filters["color"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND decks.colors LIKE '%". $filters["color"] ."%'"; 
        }

        if($intOffset && $intCount) {
            $results = $model->find($where, "updatedDate DESC", $intOffset, $intCount);
        } else {
            $results = $model->find($where, "updatedDate DESC");
        }

        if($results) {
            return $results;
        }

        return 0;
    }

    public static function getDeckDetails($id_deck) {
        $model = new deckModel();

        return $model->findOne("decks.id_deck = ".$id_deck);
    }

    public static function getPager($user_id, $filters = false) {
        $model = new deckModel();
        $validator = new dataValidator();
        $where = "decks.user_id = ". $user_id;
        
        if (isset($filters["name"]) && $filters["name"] = $validator->value($filters["name"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND decks.name LIKE '%". $filters["name"] ."%'"; 
        }

        if (isset($filters["format"]) && $filters["format"] = $validator->value($filters["format"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND decks.format = '". $filters["format"] ."'"; 
        }

        if (isset($filters["color"]) && $filters["color"] = $validator->value($filters["color"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND decks.colors LIKE '%". $filters["color"] ."%'"; 
        }

        $results = $model->find($where);

        return ceil(count($results)/gc::getSetting("cards.numPerPage"));;
    }

    public static function deleteDeck($deck_id) {
        $model = new deckModel();

        if($model->delete($deck_id)){
            return 1;
        } else {
            return 0;
        }
    }

    public static function isDeckOwner($user_id, $deck_id) {
        $model = new deckModel();

        if($model->find("decks.id_deck = " . $deck_id . " AND decks.user_id = " . $user_id)) {
            return 1;
        }

        return 0;
    }

    public static function addDeck($request, $user_id) {
        $model = new deckModel();
        $deck_list = deckService::getDeckList($request["cards"]);
        $prices = deckService::getDeckPriceAndColors($deck_list["cards"], $deck_list["sideboard"]);
        $request["user_id"] = $user_id;
        $request["totalPrice"] = $prices["eur"];
        $request["priceTix"] = $prices["tix"];  
        $request["colors"]  = json_encode($prices["colors"]);

        $request = array_merge($request, $deck_list);
        if($model->create($request)) {
            return 1;
        }

        return 0;
    }

    public static function editDeck($request) {
        $model = new deckModel();
        
        $deck_list = deckService::getDeckList($request["cards"]);
        $request = array_merge($request, $deck_list);

        $prices = deckService::getDeckPriceAndColors($deck_list["cards"], $deck_list["sideboard"]);
        $request["totalPrice"] = $prices["eur"];
        $request["priceTix"] = $prices["tix"];  
        $request["colors"]  = json_encode($prices["colors"]);

        if($model->update($request["id_deck"], $request)) {
            return 1;
        }

        return 0;
    }

    //Desglosar decklist
    public static function getDeckList($deck_list) {
        $cartas = explode("\n", $deck_list);
        $fullList = array();
        $esSide = false;
        $side = array();
        foreach ($cartas as $carta) {
            if($carta != "Deck" && $carta != "Sideboard" && $carta != ""){
                $matches = array();
                $matchesQty = array();
                preg_match("/^[1-9] (.*)$/", $carta, $matches);
                preg_match("/^[1-9]/", $carta, $matchesQty);
                
                if($esSide){
                    $side[$matches[1]] = $matchesQty[0];
                } else {
                    if(isset($fullList[$matches[1]])) {
                        $fullList[$matches[1]] = $fullList[$matches[1]] + $matchesQty[0];
                    } else {
                        $fullList[$matches[1]] = $matchesQty[0];
                    }
                }

            } else if($carta == "Sideboard") {
                $esSide = true;
            }
            
        }

        return array("cards" => json_encode($fullList), "sideboard" =>json_encode($side));
    }

    public static function getDeckPriceAndColors($deck_list, $sideboard) {
        $colors = array();
        $cardsToCheck = json_decode($deck_list, true);
        $totalPrice = 0;
        $totalPriceTix = 0;

        foreach ($cardsToCheck as $cardName => $qty) {
            $response = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/named?exact=". str_replace(" ", "", trim($cardName)), "GET"), true);

            if($response) {
                $totalPrice += ($response["prices"]["eur"] * $qty);
                $totalPriceTix += ($response["prices"]["tix"] * $qty);

                $costs = str_split((isset($response["mana_cost"]) ? $response["mana_cost"] : $response["card_faces"][0]["mana_cost"]));
                foreach ($costs as $key => $value) {
                    if ($value && $value != "{" && $value != "}" && $value != " " && $value != "/") {
                        if(!in_array($value, $colors) && in_array($value, gc::getSetting("cards.colors"))) {
                            $colors[] = $value;
                        }
                    }
                }
            }
        }

        $sideToCheck = json_decode($sideboard, true);
        
        if (count($sideToCheck)) {
            foreach ($sideToCheck as $cardName => $qty) {
                $response = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/named?exact=". str_replace(" ", "", trim($cardName)), "GET"), true);
    
                if($response) {
                    $totalPrice += ($response["prices"]["eur"] * $qty);
                    $totalPriceTix += ($response["prices"]["tix"] * $qty);
                    
                    $costs = str_split((isset($response["mana_cost"]) ? $response["mana_cost"] : $response["card_faces"][0]["mana_cost"]));
                    foreach ($costs as $key => $value) {
                        if ($value && $value != "{" && $value != "}" && $value != " " && $value != "/") {
                            if(!in_array($value, $colors) && in_array($value, gc::getSetting("cards.colors"))) {
                                $colors[] = $value;
                            }
                        }
                    }
                }
            }
        }

        return array("eur" => $totalPrice, "tix" => $totalPriceTix, "colors" => $colors);
    }

    public static function getPriceByIdDeck($id_deck) {
        $model = new deckModel();
        $deck = deckService::getDeckDetails($id_deck);
        $missingCards = array();
        $missingSide = array();
        $totalCardsMissing = 0;
        $totalPrice = 0;
        $totalPriceTix = 0;

        foreach (json_decode($deck["cards"], true) as $name => $qty) {
            if($qty_missing = cardService::checkCardsOnCollection($name, $qty)) {
                $card = apiService::getFirstCardOfEdition($name, "modern")[0];

                $totalPrice += ($card["Card"]["Price"] * $qty_missing);
                $totalPriceTix += ($card["Card"]["PriceTix"] * $qty_missing);

                $missingCards[$name] = $qty_missing;
                $totalCardsMissing += $qty_missing;
            }
        }

        foreach (json_decode($deck["sideboard"], true) as $name => $qty) {
            if($qty_missing = cardService::checkCardsOnCollection($name, $qty)) {
                $card = apiService::getFirstCardOfEdition($name, "modern")[0];

                $totalPrice += ($card["Card"]["Price"] * $qty_missing);
                $totalPriceTix += ($card["Card"]["PriceTix"] * $qty_missing);

                $missingSide[$name] = $qty_missing;
                $totalCardsMissing += $qty_missing;
            }
        }

        return array("deck" => $deck, "missing_cards_count" => $totalCardsMissing, "total_price" => $totalPrice, "total_price_tix" => $totalPriceTix, "missing_cards" => $missingCards, "missing_side" => $missingSide);
    }
}

?>