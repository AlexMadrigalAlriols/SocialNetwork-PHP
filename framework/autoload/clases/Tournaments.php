<?php 
    class tournaments{
        public function addTournament($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="INSERT into Tournaments (tournament_name,
                                    tournament_site,
                                    tournament_used_deck,
                                    tournament_score,
                                    user_id,
                                    tournament_format)
                        values ('$datos[1]','$datos[2]','$datos[4]','$datos[3]', '$datos[0]', '$datos[5]')";

            if(mysqli_query($conexion, $sql)) {
                return mysqli_insert_id($conexion);
            } else {
                return -1;
            }
        }

        public function deleteDeck($datos){
            $c=new conectar();
			$conexion=$c->conexion();
            $sql="DELETE FROM tournaments WHERE id_torunament='$datos[0]'";

            return mysqli_query($conexion,$sql);
        }

        public function getAllTournaments($datos, $name, $location, $date, $deck_id) {
            $c=new conectar();
            $conexion=$c->conexion();

            $allTournaments = array();

            $sql="SELECT id_tournament, tournament_name, tournament_site, tournament_used_deck, tournament_score, tournament_format, tournament_date FROM `Tournaments` WHERE user_id = $datos[0] ";
            
            if($name != "none"){
                $sql .= "AND tournament_name LIKE '%$name%' ";
            }

            if($location != "none"){
                $sql .= "AND tournament_site LIKE '%$location%' ";
            }

            if($date != "none"){
                $sql .= "AND tournament_date > '$date' ";
            }

            if($deck_id != "none"){
                $sql .= "AND tournament_used_deck = '$deck_id' ";
            }
            
            $sql .= "ORDER BY tournament_date DESC limit $datos[1],$datos[2]";

            if ($resultado = mysqli_query($conexion, $sql)) {

                while ($fila = mysqli_fetch_row($resultado)) {
                    if($fila[3] != -1){
                        $sql="SELECT name FROM `decks` WHERE id_deck= $fila[3]";
                        $result = mysqli_query($conexion, $sql);
    
                        while($filaDeck = mysqli_fetch_Row($result)){
                            $deck = $filaDeck[0];
                        }
                    } else {
                        $deck = "---";
                    }

                    $date = new DateTime($fila[6]);
                    
                    $allTournaments[] = array("Tournament" => array(
                        "Id" => $fila[0], 
                        "Name" => $fila[1], 
                        "Site" => $fila[2], 
                        "Deck" => $deck,
                        "Score" => $fila[4],
                        "Format" => $fila[5],
                        "Date"  => $date->format('d/m/Y'),
                    ));
                }
            
                mysqli_free_result($resultado);
            }
            return json_encode($allTournaments);
        }

        public function addRound($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="INSERT into Rounds (games_status,
                                    opponent_deck,
                                    tournament_id)
                        values ('$datos[0]','$datos[1]','$datos[2]')";

            if(mysqli_query($conexion, $sql)) {
                return mysqli_insert_id($conexion);
            } else {
                return -1;
            }
            
        }
        
        public function addGame($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql="INSERT into Games (game_num,
                                    game_info,
                                    game_Result,
                                    round_id)
                        values ('$datos[0]','$datos[1]','$datos[2]','$datos[3]')";

            if(mysqli_query($conexion, $sql)) {
                return mysqli_insert_id($conexion);
            } else {
                return -1;
            }
            
        }

        public function getTournamentById($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $tournamentDetails = array();

            $sql="SELECT id_tournament, tournament_name, tournament_site, tournament_used_deck, tournament_score, tournament_format, tournament_date, user_id FROM `Tournaments` WHERE id_tournament = $datos[0]";

            if ($resultado = mysqli_query($conexion, $sql)) {

                while ($fila = mysqli_fetch_row($resultado)) {
                    if($fila[3] != -1){
                        $sql="SELECT name FROM `decks` WHERE id_deck= $fila[3]";
                        $result = mysqli_query($conexion, $sql);
    
                        while($filaDeck = mysqli_fetch_Row($result)){
                            $deck = $filaDeck[0];
                        }
                    } else {
                        $deck = "---";
                    }

                    $sql="SELECT name FROM `users` WHERE user_id= $fila[7]";
                    $result = mysqli_query($conexion, $sql);

                    while($filaUsers = mysqli_fetch_Row($result)){
                        $user = $filaUsers[0];
                    }

                    $sql="SELECT round_id FROM `Rounds` WHERE tournament_id=$fila[0]";
                    $result = mysqli_query($conexion, $sql);
                    $round = false;
                    
                    while($filaUsers = mysqli_fetch_Row($result)){
                        $round = true;
                    }

                    $date = date_create($fila[6]);
                    $tournamentDetails[] = array(
                            "Tournament" => array(
                                "Id" => $fila[0],
                                "Name" => $fila[1],
                                "Site" => $fila[2],
                                "Deck" => $deck,
                                "Deck_id" => $fila[3],
                                "Score" => $fila[4],
                                "User_Id" => $fila[7],
                                "Format" => $fila[5],
                                "Rounds" => $round,
                                "Date"  =>  date_format($date, "d-m-Y"),
                                "User"  => $user
                    ));
                }
            
                mysqli_free_result($resultado);
            }

            return json_encode($tournamentDetails);
        }

        public function getRoundByTournamentId($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $roundsDetails = array();

            $sql="SELECT round_id,games_status, opponent_deck FROM `Rounds` WHERE tournament_id = '$datos[0]'";

            if ($resultado = mysqli_query($conexion, $sql)) {

                while ($fila = mysqli_fetch_row($resultado)) {

                    $roundsDetails[] = array(
                            "Round" => array(
                                "Id"    => $fila[0],
                                "Status" => $fila[1],
                                "Opp_Deck" => $fila[2]
                    ));
                }
            
                mysqli_free_result($resultado);
            }

            return json_encode($roundsDetails);
        }
        
        public function getGamesByRoundId($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $gameDetails = array();

            $sql="SELECT game_id,game_info, game_result FROM `Games` WHERE round_id = '$datos[0]'";

            if ($resultado = mysqli_query($conexion, $sql)) {

                while ($fila = mysqli_fetch_row($resultado)) {

                    $gameDetails[] = array(
                            "Game" => array(
                                "Id"    => $fila[0],
                                "Game_info" => $fila[1],
                                "Game_result" => $fila[2]
                    ));
                }
            
                mysqli_free_result($resultado);
            }

            return json_encode($gameDetails);
        }

        public function updateTournament($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql = "UPDATE Tournaments SET tournament_name = '$datos[1]', tournament_site = '$datos[2]', tournament_used_deck = '$datos[4]', tournament_score = '$datos[3]', tournament_format = '$datos[5]' WHERE id_tournament = '$datos[6]'";

            return mysqli_query($conexion, $sql);
        }

        public function updateRound($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql = "UPDATE Rounds SET games_status = '$datos[0]', opponent_deck = '$datos[1]' WHERE round_id = '$datos[2]'";

            if(mysqli_query($conexion, $sql)) {
                return $datos[2];
            }
            
        }

        public function updateGame($datos){
            $c=new conectar();
            $conexion=$c->conexion();

            $sql = "UPDATE Games SET game_num = '$datos[0]', game_info = '$datos[1]', game_result = '$datos[2]' WHERE game_id = '$datos[3]'";

            return mysqli_query($conexion, $sql);
        }
    }

?>