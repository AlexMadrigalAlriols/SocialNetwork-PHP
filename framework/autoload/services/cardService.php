<?php

class cardService {
    public static function getAllCardsByUser($user_id, $intOffset, $intCount, $filters = false) {
        $model = new cardModel();
        $validator = new dataValidator();

        $where = "cards.user_id = ". $user_id;
        
        if (isset($filters["name"]) && $filters["name"] = $validator->value($filters["name"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND cards.card_name LIKE '%". $filters["name"] ."%'"; 
        }

        if (isset($filters["info"]) && $filters["info"] = $validator->value($filters["info"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND cards.card_info = '". $filters["info"] ."'"; 
        }

        if (isset($filters["colors"]) && $filters["colors"] = $validator->value($filters["colors"])->sanitizeAlphanumeric() ->notEmpty()->validate()) {
            $where .= " AND cards.color_identity LIKE '%". $filters["colors"] ."%'"; 
        }

        $results = $model->find($where, "cards.updateDate DESC", $intOffset, $intCount);

        foreach ($results as $idx => $card) {
            $request = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/". $card["id_card"], "GET"), true);
            $results[$idx]["card_img"] = $request["image_uris"]["large"];
            $results[$idx]["card_price_eur"] = ($request["prices"]["eur"] ? $request["prices"]["eur"] : "-");
            $results[$idx]["card_price_tix"] = ($request["prices"]["tix"] ? $request["prices"]["tix"] : "-");
            $results[$idx]["card_set"] = strtoupper($request["set"]);
            $results[$idx]["card_set_name"] = $request["set_name"];
        }

        if(count($results) >= 10) {
            badgeService::setUserBadges($user_id, "10_cards_collection");
        } 
        
        if(count($results) >= 50) {
            badgeService::setUserBadges($user_id, "50_cards_collection");
        } 
        
        if(count($results) >= 175) {
            badgeService::setUserBadges($user_id, "175_cards_collection");
        }
        
        return $results;
    }

    public static function getPager($user_id, $filters) {
        $model = new cardModel();
        $validator = new dataValidator();
        $where = "cards.user_id = ". $user_id;
        
        if (isset($filters["name"]) && $filters["name"] = $validator->value($filters["name"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND cards.card_name LIKE '%". $filters["name"] ."%'";
        }

        if (isset($filters["info"]) && $filters["info"] = $validator->value($filters["info"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND cards.card_info = '". $filters["info"] ."'"; 
        }

        if (isset($filters["colors"]) && $filters["colors"] = $validator->value($filters["colors"])->notEmpty()->validate()) {
            $where .= " AND cards.color_identity LIKE '%". $filters["colors"] ."%'"; 
        }

        $results = $model->find($where);

        return ceil(count($results)/gc::getSetting("cards.numPerPage"));;
    }

    public static function addCards($request, $user_id) {
        $model = new cardModel();
        $result = $model->findOne("cards.id_card = '".$request["id_card"] . "' AND cards.user_id = " . $user_id, null, 0,0,array("id_cardBD", "qty"));

        if($result){
            return $model->update($result["id_cardBD"], array("qty" => $request["qty"] + $result["qty"]));
        }

        $response = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/". $request["id_card"], "GET"), true);
        $request["color_identity"] = "";
        $request["user_id"] = $user_id;
        $request["card_name"] = $response["name"];

        foreach ($response["colors"] as $color) {
            $request["color_identity"] .= $color.",";
        }

        return $model->create($request);
    }

    public static function removeCards($request, $user_id) {
        $model = new cardModel();
        
        $result = $model->findOne("cards.user_id = " . $user_id . " AND cards.id_card = '" . $request["id_card"] . "'");

        if($result) {
            if($result["qty"] >= 1) {
                if($model->update($result["id_cardBD"], array("qty" => $result["qty"] - $request["qty"]))) {
                    $result = $model->findOne("cards.user_id = " . $user_id . " AND cards.id_card = '" . $request["id_card"] . "'");

                    if($result["qty"] == 0) {
                        return $model->delete($result["id_cardBD"]);
                    } else {
                        return 1;
                    }
                }
            } else {
                return $model->delete($result["id_cardBD"]);
            }
        }

        return 0;
    } 

    //Devuelve la cantidad de cartas que NO tiene en la coleccion
    public static function checkCardsOnCollection($card_name, $qty_need) {
        $model = new cardModel();
        $totalCards = 0;

        $result = $model->find('cards.card_name = "'. $card_name . '"');
        if(!$result) {
            return $qty_need;
        }

        foreach ($result as $idx => $card) {
            if($card["qty"] >= $qty_need) {
                return 0;
            } else {
                $totalCards += $card["qty"];
            }
        }

    }

    public static function importCards($cards, $user_id) {
        $card_list = explode("\n", $cards);
        $fullList = array();
        $error = false;
        foreach ($card_list as $card) {
            $card = trim($card);
            if($card != "Deck" && $card != "Sideboard" && $card != ""){
                $matches = array();
                $matchesQty = array();
                preg_match("/^[1-9] (.*)$/", $card, $matches);
                preg_match("/^[1-9]/", $card, $matchesQty);
                
                $match = explode("(", $matches[1]);

                if(isset($fullList[$match[0]])) {
                    $fullList[$match[0]]["qty"] = $fullList[$match[0]] + $matchesQty[0];
                    $fullList[$match[0]]["set"] = explode(")", $match[1])[0];

                } else {
                    $fullList[$match[0]] = array("qty" => $matchesQty[0], "set" => explode(")", $match[1])[0]);
                }
            }
            
        }

        foreach ($fullList as $name => $value) {
            $request = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/named?exact=". str_replace(" ", "", trim($name)), "GET"), true);
            $edition = array();

            if(isset($value["set"])) {
                    $response = json_decode(fwHttp::requestHttp($request["prints_search_uri"], "GET"), true);

                    for ($i=0; $i < $response["total_cards"]; $i++) { 
                        if($response["data"][$i]["set"] == strtolower($value["set"])) {
                            $request["id"] = $response["data"][$i]["id"];
                        }
                    }
                    
            }
            
            if($request["id"] && !cardService::addCards(array("id_card" => trim($request["id"]), "qty" => $value["qty"]), $user_id)) {
                $error = true;
            }
        }

        if($error) {
            return 0;
        }

        return 1;
    }

    public static function getCollectionPriceByUserId($user_id){
        $model = new cardModel();
        $totalPrice = 0;
        $totalPriceTix = 0;
        $totalCards = 0;
        $collection_cards = array();

        $cards = $model->find("cards.user_id = " . $user_id);
        foreach ($cards as $idx => $card) {
            $response = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/". $card["id_card"], "GET"), true);

            $totalPrice += $response["prices"]["eur"] * $card["qty"];
            $totalPriceTix += $response["prices"]["tix"] * $card["qty"];
            $totalCards += $card["qty"];
            $collection_cards[$card["card_name"]] = $card["qty"];
        }

        return array("price" => $totalPrice, "priceTix" => $totalPriceTix, "totalCards" => $totalCards, "cards" => $collection_cards);
    }
}

?>