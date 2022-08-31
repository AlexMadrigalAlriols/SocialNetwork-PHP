<?php

class reportService {
    public static function triggerReport($user_id, $report_type, $reported_user_id = 0, $id_publication = 0, $id_deck = 0){
        $model = new reportModel();

        $request = array(
            "id_user"   => $user_id,
            "report_type"   => $report_type,
            "reported_user_id" => $reported_user_id
        );
        
        if($report_type == REPORT_PUBLICATION){
            $request["reported_publication"] = $id_publication;
        }

        if($report_type == REPORT_DECK) {
            $request["reported_deck"] = $id_deck;
        }

        $result = $model->find("reports.id_user = ". $user_id ." AND reports.report_type = '" . $report_type . "' AND reports.reported_user_id = " . $reported_user_id . " AND reports.reported_publication = " . $id_publication . " AND reports.reported_deck = " . $id_deck . " AND reports.resolved = 0");
        
        if($result){
            return 1;
        }

        return $model->create($request);
    }

    public static function getNotResolvedReports(){
        $model = new reportModel();
        return $model->find("reports.resolved = 0", "reports.report_date DESC");
    }

    public static function getAllReports(){
        $model = new reportModel();
        return $model->find("1=1");
    }

    public static function acceptReport($id_report){
        $model = new reportModel();
        $report = $model->findOne("id_report = ".$id_report);

        if($report["report_type"] == REPORT_PUBLICATION) {
            if(publicationService::deletePublication($report["reported_publication"])){
                if($model->update($id_report, array("resolved" => 1))){
                    return 1;
                }
            }
        } else if($report["report_type"] == REPORT_DECK) {
            if(deckService::deleteDeck($report["reported_deck"])){
                if($model->update($id_report, array("resolved" => 1))){
                    return 1;
                }
            }
        } else {
            if(userService::banUser($report["reported_user_id"])){
                if($model->update($id_report, array("resolved" => 1))){
                    return 1;
                }
            }
        }

        return 0;
    }

    public static function denyReport($id_report){
        $model = new reportModel();
        if($model->update($id_report, array("resolved" => 1))){
            return 1;
        }

        return 0;
    }
}

?>