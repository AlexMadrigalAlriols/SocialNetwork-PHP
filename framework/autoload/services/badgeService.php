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
        
        public static function setUserBadges($user_id, $new_badges) {
            $model = new userModel();
            
            if($user = $model->findOne("user_id = " . $user_id, null, array('badges'))) {
                if($badges = json_decode($user['badges'], true)) {
                    if(is_array($new_badges)) {
                        $badges = array_merge($badges, $new_badges);
                    } else {
                        $badges[] = $new_badges;
                    }
                    

                    if($model->update($user_id, array("badges" => json_encode($badges)))) {
                        return true;
                    }
                }
            }

            return false;
        }

        public static function checkIfOwnBadge($name) {

        }
    }
?>