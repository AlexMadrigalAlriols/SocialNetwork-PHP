<?php
class fwTime{
    public static function getPassedTime($passed_date, $total_name = false){
        $now  = new DateTime();
        $second_date = new DateTime($passed_date);
        $diff = $now->diff($second_date);

        if($total_name) {
            $years = $diff->format( '%y year' );
            $days = $diff->format( '%d day/s' );
            $hours = $diff->format( '%h hour' );
            $minutes = $diff->format( '%i minutes' );
            $seconds = $diff->format( '%s seconds' );
        } else {
            $years = $diff->format( '%yy' );
            $days = $diff->format( '%dd' );
            $hours = $diff->format( '%hh' );
            $minutes = $diff->format( '%im' );
            $seconds = $diff->format( '%ss' );
        }

        if($years != "0y" && $years != "0 year") {
            return $years;
        } else if($days != "0d" && $days != "0 day/s") {
            return $days;
        } else if($hours != "0h" && $hours != "0 hour") {
            return $hours;
        } else if($minutes != "0m" && $minutes != "0 minutes") {
            return $minutes;
        } else {
            return $seconds;
        }

        return 0;
    }

    public static function getMonths(&$user) {
        $months = array();

        for($i = 1; $i <= 12; $i++) {
            $months[sprintf('%02d', strval($i))] = $user->i18n("month.". sprintf('%02d', strval($i)));
        }

        return $months;
    }
}
?>