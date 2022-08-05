<?php 
    class cards{
        public function addCard($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $fecha=date('Y-m-d');
            $sql = "SELECT id_cardBD from cards where id_card = '$datos[0]' AND user_id = '$datos[5]'";
            
            if($result = mysqli_query($conexion,$sql)) {
                while ($fila = mysqli_fetch_row($result)) {
                    if($fila[0] != "") {
                        $sql = "UPDATE cards SET qty = (qty + '$datos[3]') WHERE id_cardBD='$fila[0]'";
                        return mysqli_query($conexion, $sql);
                    }
                }
            }

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.scryfall.com/cards/'.$datos[0],
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
            $cardColor = $response["colors"];
            $colors = " ";

            foreach ($cardColor as $color) {
                $colors .= $color.",";
            }

            $sql="INSERT into cards (id_card,
                                    card_name,
                                    user_id,
                                    qty,
                                    card_info,
                                    color_identity)
                            values ('$datos[0]','$datos[1]','$datos[2]', '$datos[3]', '$datos[4]', '$colors')";

            return mysqli_query($conexion, $sql);
        }

        public function deleteCard($datos){
            $c=new conectar();
			$conexion=$c->conexion();

            $sql="UPDATE cards SET qty = (qty - '$datos[2]') where user_id='$datos[1]' and id_card='$datos[0]'";
            
            if($result = mysqli_query($conexion,$sql)){
                $sql="SELECT qty FROM cards WHERE user_id='$datos[1]' and id_card='$datos[0]'";
                
                if($result = mysqli_query($conexion,$sql)) {
                    while ($fila = mysqli_fetch_row($result)) {
                        if($fila[0] <= 0){
                            $sql="DELETE FROM cards WHERE user_id='$datos[1]' and id_card='$datos[0]'";
                            $result = mysqli_query($conexion,$sql);
                        }
                    }
                }
            }

            return $result;
        }

        public function getAllCards($datos, $name = "none", $info = "none", $colors = "all") {
            $c=new conectar();
            $conexion=$c->conexion();
            $allCards = array();

            $sql="SELECT id_card,qty,card_info FROM `cards` WHERE user_id = '$datos[0]' ";
            
            if($name != "none"){
                $sql .= "AND card_name LIKE '%$name%' ";
            }

            if($info != "none"){
                $sql .= "AND card_info LIKE '%$info%' ";
            }

            if($colors != "all"){
                $sql .= "AND color_identity LIKE '%$colors%' ";
            }
            
            $sql .= "limit $datos[1],$datos[2]";
            
            if ($resultado = mysqli_query($conexion, $sql)) {

                while ($fila = mysqli_fetch_row($resultado)) {
                    $allCards[] = array("Card" => array("Id" => $fila[0], "Qty" => $fila[1], "Info" => $fila[2]));
                }
            
                mysqli_free_result($resultado);
            }
            
            return json_encode($allCards);
        }

        public function getCard($datos) {
            $arrayImg = array();
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.scryfall.com/cards/'.$datos[0],
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

            $arrayImg[] = array("Card" => array("Id" => $response["id"], 
                "Name" => $response["name"],
                "Img" => $response["image_uris"]["small"],
                "Price" => ($response["prices"]["eur"] != null ? $response["prices"]["eur"] : "--"),
                "tixPrice" => ($response["prices"]["tix"] != null ? $response["prices"]["tix"] : "--"),
                "Set" => strtoupper($response["set"]),
                "Set_name" => $response["set_name"]
            ));

            curl_close($curl);
            
            return json_encode($arrayImg);
        }

        public function getFirstCard($datos) {
            $arrayImg = array();

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.scryfall.com/cards/named?exact='.$datos[0],
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
            
            $costs = str_split((isset($response["mana_cost"]) ? $response["mana_cost"] : cards::getDoubleFaced($response["id"])["Cost"]));
            $imgCosts = "";
            
            foreach ($costs as $key => $value) {
                if($value == "/"){
                    $imgCosts .= "/";
                }
                if($value && $value != "{" && $value != "}" && $value != " " && $value != "/") {
                    $imgCosts .= "<img src='https://c2.scryfall.com/file/scryfall-symbols/card-symbols/".$value.".svg' style='width: 17px; margin-top: -4px; margin-left: 4px;'>";
                }
            }

            $arrayImg[] = array("Card"      => array("Id" => $response["id"], 
                "Name"      => $response["name"],
                "Img"       => (isset($response["image_uris"]["small"]) ? $response["image_uris"]["small"] : cards::getDoubleFaced($response["id"])["Imagen"]),
                "Set"       => strtoupper($response["set"]),
                "Type"      => $response["type_line"],
                "Cost"      => $imgCosts,
                "ImgArt"    => $response["image_uris"]["art_crop"],
                "Price"     => $response["prices"]["eur"],
                "PriceTix"  => $response["prices"]["tix"],
                "Legal"     => (isset($datos[1]) ? $response["legalities"][strtolower($datos[1])] : "legal"),
                "Set_name"  => $response["set_name"],
                "Rarity"   => $response["rarity"]
            ));

            return json_encode($arrayImg);
        }

        public function getDoubleFaced($datos) {
            $arrayImg = array();
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.scryfall.com/cards/'.$datos,
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
            
            return array("Imagen" => $response["card_faces"][0]["image_uris"]["small"], "Cost" => $response["card_faces"][0]["mana_cost"]);
        }

        public function getPriceCard($name) {
            $arrayImg = array();
    
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.scryfall.com/cards/named?exact='.$name,
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
    
            $arrayCard[] = array("Card"      => array("Id" => $response["id"], 
                "Name"      => $response["name"],
                "Price"     => $response["prices"]["eur"],
                "PriceTix"  => $response["prices"]["tix"]
            ));
    
            return json_encode($arrayCard);
        }

        public function getCardsPerMonth($datos){
            $c=new conectar();
            $conexion=$c->conexion();
            $sql="SELECT id_card,updateDate FROM `cards` WHERE user_id = '$datos[0]'";
            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $may = 0;
            $jun = 0;
            $jul = 0;
            $aug = 0;
            $sep = 0;
            $oct = 0;
            $nov = 0;
            $dec = 0;

            if ($resultado = mysqli_query($conexion, $sql)) {
                while ($fila = mysqli_fetch_row($resultado)) {
                    if(explode("-", $fila[1])[1] == '01'){
                        $jan++;
                    } else if(explode("-", $fila[1])[1] == '02'){
                        $feb++;
                    } else if(explode("-", $fila[1])[1] == '03'){
                        $mar++;
                    } else if(explode("-", $fila[1])[1] == '04'){
                        $apr++;
                    } else if(explode("-", $fila[1])[1] == '05'){
                        $may++;
                    } else if(explode("-", $fila[1])[1] == '06'){
                        $jun++;
                    } else if(explode("-", $fila[1])[1] == '07'){
                        $jul++;
                    } else if(explode("-", $fila[1])[1] == '08'){
                        $aug++;
                    } else if(explode("-", $fila[1])[1] == '09'){
                        $sep++;
                    } else if(explode("-", $fila[1])[1] == '10'){
                        $oct++;
                    } else if(explode("-", $fila[1])[1] == '11'){
                        $nov++;
                    } else if(explode("-", $fila[1])[1] == '12'){
                        $dec++;
                    }
                }
            
                mysqli_free_result($resultado);
            }
            return json_encode(array("jan" => $jan, "feb" => $feb, "mar" => $mar, "apr" => $apr, "may" => $may,
            "jun" => $jun,"jul" => $jul,"aug" => $aug,"sep" => $sep,"oct" => $oct,"nov" => $nov,"dec" => $dec));
        }
    }

    

?>