<?php

class tournamentService {
    public static function getAllTournamentsByShop($user_id, $intOffset = false, $intCount = false, $filters = false, $public = false) {
        $model = new tournamentModel();
        $validator = new dataValidator();

        $where = "tournaments.id_user = ". $user_id;
        
        if($public) {
            $where .= " AND tournaments.start_date >= '" . date("Y-m-d h:i:s") . "'";
        }
        
        if (isset($filters["city"]) && $filters["city"] = $validator->value($filters["city"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND tournaments.ubication LIKE '%". $filters["city"] ."%'"; 
        }

        if (isset($filters["country"]) && $filters["country"] = $validator->value($filters["country"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND tournaments.ubication LIKE '%". $filters["country"] ."%'"; 
        }

        if (isset($filters["format"]) && $filters["format"] = $validator->value($filters["format"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND tournaments.format = '". $filters["format"] ."'"; 
        }

        if (isset($filters["start_date"]) && $filters["start_date"] = $validator->value($filters["start_date"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND tournaments.start_date > '". $filters["start_date"] ."'"; 
        }

        if($intOffset !== false && $intCount !== false) {
            $results = $model->find($where, "tournaments.updatedDate DESC", $intOffset, $intCount);
            
        } else {
            $results = $model->find($where, "tournaments.updatedDate DESC");
        }

        return $results;
    }

    public static function getTournamentById($id_tournament, $user_id = false) {
        $model = new tournamentModel();

        $result = $model->findOne("tournaments.id_tournament = ". $id_tournament);

        if(!$result || ($user_id && $result["id_user"] != $user_id)) {
            return false;
        }

        return $result;
    }

    public static function getPager($user_id, $filters = false) {
        $model = new tournamentModel();
        $validator = new dataValidator();
        $where = "tournaments.id_user = ". $user_id;
        
        if (isset($filters["name"]) && $filters["name"] = $validator->value($filters["name"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND tournaments.name LIKE '%". $filters["name"] ."%'"; 
        }

        if (isset($filters["format"]) && $filters["format"] = $validator->value($filters["format"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND tournaments.format = '". $filters["format"] ."'"; 
        }

        if (isset($filters["start_date"]) && $filters["start_date"] = $validator->value($filters["start_date"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND tournaments.start_date > '". $filters["start_date"] ."'"; 
        }

        $results = $model->find($where);

        return ceil(count($results)/gc::getSetting("cards.numPerPage"));;
    }

    public static function tournamentSearch($filters) {
        $model = new tournamentModel();
        $validator = new dataValidator();
        $where = "1=1";
        
        $where .= " AND tournaments.start_date >= '" . date("Y-m-d h:i:s") . "'";

        if (isset($filters["info"]) && $filters["info"] = $validator->value($filters["info"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND tournaments.ubication LIKE '%". $filters["info"] ."%'"; 
        }

        if (isset($filters["format"]) && $filters["format"] = $validator->value($filters["format"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND tournaments.format = '". $filters["format"] ."'"; 
        }

        if (isset($filters["date"]) && $filters["date"] = $validator->value($filters["date"])->sanitizeAlphanumeric()->notEmpty()->validate()) {
            $where .= " AND tournaments.start_date > '". $filters["date"] ."'"; 
        }
        
        return $model->find($where, "tournaments.updatedDate DESC");
    }

    public static function createTournament($request, $user_id, $files = false, $prices = false) {
        $model = new tournamentModel();

        if(isset($files["name"]["image"])){
            $request["image"] = fwFiles::uploadFiles($files, "image");
        }

        if($prices) {
            $request["prices"] = json_encode($prices);
        }

        $request["id_user"] = $user_id;
        if($model->create($request)) {
            return 1;
        }

        return 0;
    }

    public static function editTournament($id_tournament, $request, $user_id, $files = false, $prices = false) {
        $model = new tournamentModel();

        $result = $model->findOne("tournaments.id_tournament =".$id_tournament);

        if($result["id_user"] == $user_id) {
            if($files["name"]["image"]){
                $request["image"] = fwFiles::uploadFiles($files, "image");
            }

            if($prices) {
                $request["prices"] = json_encode($prices);
            }
    
            if($model->update($id_tournament, $request)) {
                return 1;
            }
        }

        return 0;
    }

    public static function deleteTournament($id_tournament) {
        $model = new tournamentModel();

        if($model->delete($id_tournament)) {
            return 1;
        }

        return 0;
    }

    public static function countShopTournaments($id_shop) {
        $model = new tournamentModel();
        $tournaments = $model->find("tournaments.id_user = ". $id_shop);

        return count($tournaments);
    }
}

?>