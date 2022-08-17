<?php

class cardModel extends fwModel {

	public function __construct() {
		$this->fwModel("cards", "id_cardBD");
	}

	public function create($arrData) {
		return parent::create($arrData);
	}

	public function find($strWhere, $strOrder = null, $intOffset = 0, $intCount = 0, $arrFields = null) {
		$sqlFields = $this->generateReadFields($arrFields);
		$sql = "SELECT $sqlFields
				FROM " . $this->tableName . "
				WHERE $strWhere " . ($strOrder ? "ORDER BY $strOrder" : "");

		$return = $this->bdRead->query($sql, $intOffset, $intCount);
		$this->last = OP_READ;

		return $return;
	}
}

?>