<?php
class fwTime{
    public static function getPassedTime($passed_date){
        $now  = new DateTime();
        $second_date = new DateTime($passed_date);
        
        $diff = $now->diff($second_date);

        $days = $diff->format( '%dd' );
        $hours = $diff->format( '%hh' );
        $minutes = $diff->format( '%im' );
        $seconds = $diff->format( '%ss' );

        if($days != "0d") {
            return $days;
        } else if($hours != "0h") {
            return $hours;
        } else if($minutes != "0m") {
            return $minutes;
        } else {
            return $seconds;
        }

        return 0;
    }
}
?>