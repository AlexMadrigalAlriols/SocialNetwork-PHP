<?php
    define("PATH_GLOBAL_AUTO", realpath(dirname(__FILE__)) . "/");
    header("Set-Cookie: cross-site-cookie=whatever; SameSite=None; Secure");
    
    class gc{
        public static $settings = array();
        public static $badges = array();
        public static $autoloadPaths = array();
        public static $autoloadCache = null;
        public static $localePaths = array();
        
        public static function addSettingsFile($absolutePath) {
            include($absolutePath);
            gc::setSettings($settings);
        }
    
        public static function setSettings($array) {
            gc::$settings = array_merge(gc::$settings, $array);
        }

        public static function getSettings() {
            return gc::$settings;
        }
    
        public static function getSetting($key) {
            return gc::$settings[$key];
        }

        public static function addBadgesFile($absolutePath) {
            include($absolutePath);
            gc::setBadges($badges);
        }
    
        public static function setBadges($array) {
            gc::$badges = array_merge(gc::$badges, $array);
        }

        public static function getBadge($key) {
            if(isset(gc::$badges[$key])) {
                return gc::$badges[$key];
            }
            
            return false;
        }

        public static function getBadges() {
            return gc::$badges;
        }

        public static function addAutoloadPath($absolutePath) {
            gc::$autoloadPaths[] = $absolutePath;
            gc::$autoloadCache = null;
        }

        public static function addLocalePath($absolutePath) {
            gc::$localePaths[] = $absolutePath;
        }

        public static function autoload($className) {
            if (gc::$settings["site.devel"]) {
                gc::$autoloadCache = array();

                include_once(PATH_GLOBAL_AUTO . "autoload/misc/fwFS.php");
                
                foreach (gc::$autoloadPaths as $p) {
                    $contents = fwFS::getDirectoryContents($p, "*.php", true, true, false);

                    foreach ($contents as $file) {
                        if (!isset(gc::$autoloadCache[strtolower(fwFS::getFileNameWithoutExtension($file))])) {
                            gc::$autoloadCache[strtolower(fwFS::getFileNameWithoutExtension($file))] = $p . $file;
                        }
                    }
                }
            }

            if (isset(gc::$autoloadCache[strtolower($className)])) {
                include_once(gc::$autoloadCache[strtolower($className)]);
            }
        }
    }

    spl_autoload_register(array("gc", "autoload"));
    date_default_timezone_set("Europe/Madrid");

    include(PATH_GLOBAL_AUTO ."data/constants.php");

    gc::addAutoloadPath(PATH_GLOBAL_AUTO . "autoload/");
    gc::addLocalePath(PATH_GLOBAL_AUTO . "locale/");
    gc::addSettingsFile(PATH_GLOBAL_AUTO . "data/settings.php");
    gc::addBadgesFile(PATH_GLOBAL_AUTO . "data/badges.php");
?>