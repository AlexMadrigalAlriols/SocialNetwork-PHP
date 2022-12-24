<?php

class apiService {
    public static function getAutoComplet($name){
        $request = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/autocomplete?q=". $name, "GET"), true);
        $data = "";

        if(isset($request["total_values"]) && $request["total_values"]) {
            for ($i=0; $i < $request["total_values"]; $i++) { 

                $data .= $request["data"][$i] . ";";
                
            }
        }

        return $data;
    }

    public static function getSpecificCard($card_id, $all_info = false) {
        $response = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/". $card_id, "GET"), true);

        if($all_info) {
            $response_set = json_decode(fwHttp::requestHttp($response["set_uri"], "GET"), true);

            if($response_set) {
                $response["set_info"] = $response_set;
            }

            if($response["legalities"]) {
                unset($response["legalities"]["penny"]);
                unset($response["legalities"]["oldschool"]);
                unset($response["legalities"]["premodern"]);
                unset($response["legalities"]["paupercommander"]);
                unset($response["legalities"]["future"]);
                unset($response["legalities"]["gladiator"]);
            }

            if($response["name"]) {
                $response_results = json_decode(fwHttp::requestHttp($response["prints_search_uri"], "GET"), true);

                $response["other_versions"] = $response_results;

                foreach ($response["other_versions"]["data"] as $idx => $card) {
                    if($card["id"] == $response["id"]) {
                        unset($response["other_versions"]["data"][$idx]);
                    }
                }
            }
            
            return $response;
        }
        
        return array("Img" => $response["image_uris"]["normal"]);
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
        
                    $arrayCards[] = array("id" => $data["id"], 
                                        "name"      => $data["name"],
                                        "img"       => $data["image_uris"]["normal"],
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
                "Img"       => (isset($response["image_uris"]["normal"]) ? $response["image_uris"]["normal"] : $response["card_faces"][0]["image_uris"]["normal"]),
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

    public static function searchAllCards($params) {
        $request = json_decode(fwHttp::requestHttp("https://api.scryfall.com/cards/named?fuzzy=". trim($params), "GET"), true);

        if($request && isset($request["prints_search_uri"])) {
            $response = json_decode(fwHttp::requestHttp($request["prints_search_uri"], "GET"), true);

            if($response && isset($response["total_cards"])) {
                for ($i=0; $i < $response["total_cards"]; $i++) { 
                    $data = $response["data"][$i];
        
                    $arrayCards[] = array("id" => $data["id"], 
                                        "name"      => $data["name"],
                                        "img"       => $data["image_uris"]["normal"],
                                        "set"       => strtoupper($data["set"]),
                                        "type"      => $data["type_line"],
                                        "set_name"  => $data["set_name"]
                                    );
                }

                return $arrayCards;
            }
        }

        return array();
    }
    
    public static function getManaCostImg($mana_cost) {
        $costs = str_split($mana_cost);
        $imgCosts = "";
        foreach ($costs as $key => $value) {
            if ($value == "/") {
                $imgCosts .= "/";
            }
            if ($value && $value != "{" && $value != "}" && $value != " " && $value != "/") {
                $imgCosts .= "<img src='https://c2.scryfall.com/file/scryfall-symbols/card-symbols/".$value.".svg' style='width: 17px; margin-top: -4px; margin-left: 4px;'>";
            }
        }

        return $imgCosts;
    }

    public static function getSetInfoIcon($set_url) {
        $response = json_decode(fwHttp::requestHttp($set_url, "GET"), true);

        if($icon = $response["icon_svg_uri"]) {
            return $icon;
        }

        return "";
    }
}
?>