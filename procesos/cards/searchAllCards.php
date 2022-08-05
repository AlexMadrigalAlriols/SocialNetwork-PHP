<?php
if(isset($_GET['searchercard'])){
    $arrayImg = array();

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.scryfall.com/cards/named?exact='.$_GET['searchercard'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json'
    ),
    ));

    $response = json_decode(curl_exec($curl), true);

    curl_close($curl);
    if($_GET['searchercard'] != "Plains") {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $response['prints_search_uri'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json'
        ),
        ));
    
        $response = json_decode(curl_exec($curl), true);

        for ($i=0; $i < $response["total_cards"]; $i++) { 
            $data = $response["data"][$i];
            $costs = str_split($data["mana_cost"]);
            $imgCosts = "";

            foreach ($costs as $key => $value) {
                if($value && $value != "{" && $value != "}" && $value != " ") {
                    $imgCosts .= "<img src='https://c2.scryfall.com/file/scryfall-symbols/card-symbols/".$value.".svg' style='width: 17px; margin-top: -4px; margin-left: 4px;'>";
                }

            }

            $arrayImg[] = array("Card"      => array("Id" => $data["id"], 
                                "Name"      => $data["name"],
                                "Img"       => $data["image_uris"]["small"],
                                "Set"       => strtoupper($data["set"]),
                                "Type"      => $data["type_line"],
                                "Cost"      => $imgCosts,
                                "Set_name"  => $data["set_name"]
                            ));
        }

    } else {
        $costs = str_split($response["mana_cost"]);
        $imgCosts = "";

        foreach ($costs as $key => $value) {
            if($value && $value != "{" && $value != "}" && $value != " ") {
                $imgCosts .= "<img src='https://c2.scryfall.com/file/scryfall-symbols/card-symbols/".$value.".svg' style='width: 17px; margin-top: -4px; margin-left: 4px;'>";
            }
        }

        $arrayImg[] = array("Card"      => array("Id" => $response["id"], 
        "Name"      => $response["name"],
        "Img"       => $response["image_uris"]["small"],
        "Set"       => strtoupper($response["set"]),
        "Type"      => $response["type_line"],
        "Cost"      => $imgCosts,
        "Set_name"  => $response["set_name"]
    ));
    }

    print_r(json_encode($arrayImg));
}

?>