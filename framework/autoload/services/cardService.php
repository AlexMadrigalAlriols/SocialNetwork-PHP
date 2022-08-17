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
            $results[$idx]["card_img"] = $request["image_uris"]["small"];
            $results[$idx]["card_price_eur"] = ($request["prices"]["eur"] ? $request["prices"]["eur"] : "-");
            $results[$idx]["card_price_tix"] = ($request["prices"]["tix"] ? $request["prices"]["tix"] : "-");
            $results[$idx]["card_set"] = strtoupper($request["set"]);
            $results[$idx]["card_set_name"] = $request["set_name"];
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

    public static function getAutoComplet($name){
        $request = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/autocomplete?q=". $name, "GET"), true);
        $data = "";

        for ($i=0; $i < $request["total_values"]; $i++) { 

            $data .= $request["data"][$i] . ";";
            
        }

        return $data;
    }
    
    public static function searchCardsOnWeb($params) {
        $request = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/named?exact=". str_replace(" ", "", trim($params)), "GET"), true);

        if($request && isset($request["prints_search_uri"])) {
            $response = json_decode(fwHttp::requestHttp($request["prints_search_uri"], "GET"), true);

            if($response && isset($response["total_cards"])) {
                for ($i=0; $i < $response["total_cards"]; $i++) { 
                    $data = $response["data"][$i];
                    $costs = str_split($data["mana_cost"]);
                    $imgCosts = "";
        
                    foreach ($costs as $key => $value) {
                        if($value && $value != "{" && $value != "}" && $value != " ") {
                            $imgCosts .= "<img src='https://c2.scryfall.com/file/scryfall-symbols/card-symbols/".$value.".svg' style='width: 17px; margin-top: -4px; margin-left: 4px;'>";
                        }
                    }
        
                    $arrayCards = array("id" => $data["id"], 
                                        "name"      => $data["name"],
                                        "img"       => $data["image_uris"]["small"],
                                        "set"       => strtoupper($data["set"]),
                                        "type"      => $data["type_line"],
                                        "cost"      => $imgCosts,
                                        "set_name"  => $data["set_name"]
                                    );
                }

                return $arrayCards;
            }
        }

        return array();
    }

    public static function getFirstCardOfEdition($params, $format = "modern") {
        $response = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/named?exact=". str_replace(" ", "", trim($params)), "GET"), true);

        if($response) {
            $costs = str_split((isset($response["mana_cost"]) ? $response["mana_cost"] : $response["card_faces"][0]["mana_cost"]));
            $imgCosts = "";
            foreach ($costs as $key => $value) {
                if ($value == "/") {
                    $imgCosts .= "/";
                }
                if ($value && $value != "{" && $value != "}" && $value != " " && $value != "/") {
                    $imgCosts .= "<img src='https://c2.scryfall.com/file/scryfall-symbols/card-symbols/".$value.".svg' style='width: 17px; margin-top: -4px; margin-left: 4px;'>";
                }
            }
    
            $arrayCards[] = array("Card"      => array(
                "Id"        => $response["id"], 
                "Name"      => $response["name"],
                "Img"       => (isset($response["image_uris"]["small"]) ? $response["image_uris"]["small"] : $response["card_faces"][0]["image_uris"]["small"]),
                "Set"       => strtoupper($response["set"]),
                "Type"      => $response["type_line"],
                "Cost"      => $imgCosts,
                "ImgArt"    => (isset($response["image_uris"]["art_crop"]) ? $response["image_uris"]["art_crop"] : $response["card_faces"][0]["image_uris"]["art_crop"]),
                "Price"     => $response["prices"]["eur"],
                "PriceTix"  => $response["prices"]["tix"],
                "Legal"     => (isset($format) ? $response["legalities"][strtolower($format)] : "legal"),
                "Set_name"  => $response["set_name"],
                "Rarity"    => $response["rarity"]
            ));

            return $arrayCards;
        }

        return array();
    }

    public static function getDoubleFacedCards($params) {
        $response = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/". $params, "GET"), true);
        
        if($response && $response["card_faces"][0]) {
            return array("Imagen" => $response["card_faces"][0]["image_uris"], "Cost" => $response["card_faces"][0]["mana_cost"]);
        }
        
        return array("Imagen" => "", "Cost" => "");
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
}

?>