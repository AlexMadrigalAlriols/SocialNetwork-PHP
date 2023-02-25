<?php

static $fwUserInstance;

class fwUser {

	private $_attributes;

	private function __construct() {
		header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM" ');
		session_id();

		if (isset($_SESSION["fwUser"])) {
			$this->_attributes = $_SESSION["fwUser"];
		} else {
			$this->_attributes = array(
				"user_id"	=> null,
				"locale"	=> "en"
			);
		}
	}

	public static function &getInstance() {
		if (!isset($fwUserInstance)) {
			$fwUserInstance = new fwUser();
		}

		return $fwUserInstance;
	}

	public function get($strKey) {
		if(array_key_exists($strKey, $this->_attributes)) {
			return $this->_attributes[$strKey];
		}
		
		return null;
	}

	public function getIdUser() {
		return $this->get("id_user");
	}

	public function getLocale() {
		return $this->get("locale");
	}

	public function set($strKey, $objValue = false) {
		if (is_array($strKey)) {
			$this->_attributes = array_merge($this->_attributes, $strKey);
		} else {
			$this->_attributes[$strKey] = $objValue;
		}

		$_SESSION["fwUser"] = $this->_attributes;
	}

	public function reset() {
		$this->_attributes = array();
		$_SESSION["fwUser"] = $this->_attributes;
	}

	public function i18n($strkey, $arrParams = array(), $blnEncode = true) {
		return fwLocale::i18n($strkey, (isset($this->_attributes["locale"]) ? $this->_attributes["locale"] : "en"), $arrParams, $blnEncode);
	}

	public function i18nJS($strkey, $arrParams = array()) {
		return str_replace("\n", "\\n", addslashes($this->i18n($strkey, $arrParams, false)));
	}
}
