<?php 
    class decks{
        public function addDeck($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $cards = json_encode($datos[4]);
            $cartas = explode("\n", $datos[4]);
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
                        $side[str_replace("'", "''", $matches[1])] = $matchesQty[0];
                    } else {
                        if(isset($fullList[$matches[1]])) {
                            $fullList[str_replace("'", "''", $matches[1])] = $fullList[str_replace("'", "''", $matches[1])] + $matchesQty[0];
                        } else {
                            $fullList[str_replace("'", "''", $matches[1])] = $matchesQty[0];
                        }
                    }

                } else if($carta == "Sideboard") {
                    $esSide = true;
                }
                
            }

            $cards = json_encode($fullList);
            $sideboard = json_encode($side);

            if(isset($datos[8])) {
                
                if($datos[6] <= 0.00){
                    $sql = "UPDATE decks SET name = '$datos[1]', format = '$datos[2]', cards = '$cards', private = '$datos[5]', priceTix = $datos[7] WHERE id_deck='$datos[8]'";
                } else {
                    $sql = "UPDATE decks SET name = '$datos[1]', format = '$datos[2]', cards = '$cards', private = '$datos[5]', totalPrice = $datos[6], priceTix = $datos[7] WHERE id_deck='$datos[8]'";
                }
                
            } else {
                $sql="INSERT into decks (user_id,
                                    name,
                                    format,
                                    deck_img,
                                    cards,
                                    private,
                                    totalPrice,
                                    sideboard,
                                    priceTix)
                            values ('$datos[0]','$datos[1]','$datos[2]', '$datos[3]', '$cards', '$datos[5]', '$datos[6]', '$sideboard', '$datos[7]')";
            }

            return mysqli_query($conexion, $sql);
        }

        public function deleteDeck($datos){
            $c=new conectar();
			$conexion=$c->conexion();
            $sql="DELETE FROM decks WHERE id_deck='$datos[0]'";

            return mysqli_query($conexion,$sql);
        }

        public function getAllDecks($datos) {
            $c=new conectar();
            $conexion=$c->conexion();

            $allDecks = array();

            $sql="SELECT id_deck, name, format, colors, deck_img, cards, sideboard, totalPrice, updatedDate FROM `decks` WHERE user_id = $datos[0] ORDER BY updatedDate DESC limit $datos[1],$datos[2];";

            if ($resultado = mysqli_query($conexion, $sql)) {

                while ($fila = mysqli_fetch_row($resultado)) {
                    $allDecks[] = array("Deck" => array(
                            "Id" => $fila[0], 
                            "Name" => $fila[1], 
                            "Format" => $fila[2], 
                            "Colors" => $fila[3],
                            "Img" => $fila[4],
                            "Cards" => $fila[5],
                            "Sideboard" => $fila[6],
                            "TotalPrice" => $fila[7]
                        ));
                }
            
                mysqli_free_result($resultado);
            }
            return json_encode($allDecks);
        }

        public function getDeckByName($name, $user) {
            $c=new conectar();
            $conexion=$c->conexion();
            $sql = "SELECT id_deck from decks where name LIKE '%$name%' AND user_id = '$user'";
            
            if($result = mysqli_query($conexion,$sql)) {
                while ($fila = mysqli_fetch_row($result)) {
                    if($fila[0] != "") {
                        return true;
                    }
                }
            }

            return false;
        }

        public function getDetailsByName($datos, $name = "none", $format = "none") {
            $c=new conectar();
            $conexion=$c->conexion();
            $allDecks = array();
            
            $sql ="SELECT id_deck, name, format, colors, deck_img, cards, sideboard, totalPrice, updatedDate FROM `decks` WHERE user_id = $datos[0] ";
            if($name != "none"){
                $sql .= "AND name LIKE '%$name%' ";
            }

            if($format != "none"){
                $sql .= "AND format = '$format' ";
            }
            
            $sql .= "ORDER BY updatedDate DESC limit $datos[1],$datos[2]";
            
            if ($resultado = mysqli_query($conexion, $sql)) {

                while ($fila = mysqli_fetch_row($resultado)) {
                    $allDecks[] = array("Deck" => array(
                            "Id" => $fila[0], 
                            "Name" => $fila[1], 
                            "Format" => $fila[2], 
                            "Colors" => $fila[3],
                            "Img" => $fila[4],
                            "Cards" => $fila[5],
                            "Sideboard" => $fila[6],
                            "TotalPrice" => $fila[7]
                        ));
                }
            
                mysqli_free_result($resultado);
            }
            return json_encode($allDecks);
        }

        public function getDeckById($id) {
            $c=new conectar();
            $conexion=$c->conexion();
            $sql = "SELECT name,user_id,format,totalPrice,cards,updatedDate,private,sideboard,priceTix from decks where id_deck = '$id'";
            $allDecks = array();
            $user = '';
            
            if($result = mysqli_query($conexion,$sql)) {
                while ($fila = mysqli_fetch_row($result)) {
                    $sql="SELECT name FROM `users` WHERE user_id= '$fila[1]'";
                    $result = mysqli_query($conexion, $sql);
        
                    while($filaUser = mysqli_fetch_Row($result)){
                        $user = $filaUser[0];
                    }

                    if($fila[0] != "") {
                        $allDecks[] = array(
                            "Deck" => array(
                            "Name" => $fila[0], 
                            "User_id" => $fila[1],
                            "Format" => $fila[2], 
                            "Price" => $fila[3],
                            "Cards" => json_decode($fila[4]),
                            "Date" => $fila[5],
                            "Private" => $fila[6],
                            "Sideboard" => json_decode($fila[7]),
                            "PriceTix" => $fila[8],
                            "UserName" => $user
                        ));
                    }
                }
            }

            return json_encode($allDecks);
        }

        public function getPriceByIdDeck($datos) {
            $c=new conectar();
            $conexion=$c->conexion();
            $sql = "SELECT name,user_id,format,totalPrice,cards,updatedDate,private,sideboard,priceTix from decks where id_deck = '$datos[1]'";
            $allDecks = array();
            $allCards = array();
            $allSide = array();

            if($result = mysqli_query($conexion,$sql)) {
                while ($fila = mysqli_fetch_row($result)) {
                    $allDecks[] = array(
                        "Deck" => array(
                        "Name" => $fila[0], 
                        "User_id" => $fila[1], 
                        "Format" => $fila[2], 
                        "Price" => $fila[3],
                        "Cards" => json_decode($fila[4]),
                        "Date" => $fila[5],
                        "Private" => $fila[6],
                        "Sideboard" => json_decode($fila[7]),
                        "PriceTix" => $fila[8]
                    ));
                }
            }

            foreach ($allDecks[0]["Deck"]["Cards"] as $card => $value) {
                $sql = "SELECT id_card,qty from cards where card_name = '$card'";
                
                if($result = mysqli_query($conexion,$sql)) {
                    if(mysqli_num_rows($result) != 0){
                        while ($fila = mysqli_fetch_row($result)) {
                            if(isset($allCards[$card])){
                                $allCards[$card] = intval(($allCards[$card] - $fila[1]));
                            } else {
                                $allCards[$card] = intval(($value - $fila[1]));
                            }
                        }
                    } else {
                        $allCards[$card] = $value;
                    }

                }

                if($allCards[$card] <= 0) {
                    unset($allCards[$card]);
                }
            }

            foreach ($allDecks[0]["Deck"]["Sideboard"] as $card => $value) {
                $sql = "SELECT id_card,qty from cards where card_name = '$card'";
                
                if($result = mysqli_query($conexion,$sql)) {
                    if(mysqli_num_rows($result) != 0){
                        while ($fila = mysqli_fetch_row($result)) {
                            if(isset($allSide[$card])){
                                $allSide[$card] = intval(($allSide[$card] - $fila[1]));
                            } else {
                                $allSide[$card] = intval(($value - $fila[1]));
                            }
                        }
                    } else {
                        $allSide[$card] = $value;
                    }

                }
                
                if($allSide[$card] <= 0) {
                    unset($allSide[$card]);
                }
            }

            $allDecks[0]["Deck"]["Cards"] = $allCards;
            $allDecks[0]["Deck"]["Sideboard"] = $allSide;
            return json_encode($allDecks);
        }
    }

?>