<?php

        function autocomplete($param){
            $data = "";
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.scryfall.com/cards/autocomplete?q=" . $param,
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

            for ($i=0; $i < $response["total_values"]; $i++) { 

                $data .= $response["data"][$i] . ";";
                
            }
            
            echo $data;
        }

        if (isset($_POST['autocomplet'])) { 
            autocomplete($_POST['autocomplet']);
        }
?>