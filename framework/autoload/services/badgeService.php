<?php 
    class badgeService {
        public static function getUserBadges($user_id) {
            $model = new userModel();
            $user_badges = array();

            if($user = $model->findOne("user_id = " . $user_id, null, array('badges'))) {
                if($badges = json_decode($user['badges'], true)) {
                    foreach ($badges as $idx => $name) {
                        if($badge = gc::getBadge($name)) {
                            $user_badges[$name] = $badge;
                        }
                    }
                    
                    return $user_badges;
                }
            }

            return array();
        }
    }
?>