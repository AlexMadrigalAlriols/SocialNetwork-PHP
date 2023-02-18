<?php

class fwLocale {

	static $fwLocaleResources;

	public static function i18n($strkey, $strLcId, $arrParams = array(), $blnEncode = true) {
		$locales = gc::getSetting("locales");
		
		if (!isset(fwLocale::$fwLocaleResources)) {
			fwLocale::$fwLocaleResources = array();

			foreach (gc::$localePaths as $path) {
				foreach ($locales as $lcid) {
					include($path . $lcid . ".php");

					fwLocale::$fwLocaleResources[$lcid] = array();
					fwLocale::$fwLocaleResources[$lcid] = (is_array(fwLocale::$fwLocaleResources[$lcid]) ? array_merge(fwLocale::$fwLocaleResources[$lcid], $locale) : $locale);
				}
			}
		}

		$strLcId = (in_array($strLcId, $locales) ? $strLcId : $locales[0]);
		$return = (fwLocale::$fwLocaleResources[$strLcId][$strkey] ? fwLocale::$fwLocaleResources[$strLcId][$strkey] : "Not found: " . $strkey);

        if (count($arrParams)) {
            for ($i = 0; $i < count($arrParams); $i++) {
                $return = preg_replace("/%" . ($i + 1) . "/", "" . $arrParams[$i], $return);
            }
        }
		
		return ($blnEncode ? (htmlentities(stripslashes($return), ENT_COMPAT | ENT_HTML401, "ISO-8859-1")) : $return);
	}
}