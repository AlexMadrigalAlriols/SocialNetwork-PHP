<?php

class tournamentModel extends fwModel {

	public function __construct() {
		$this->fwModel("tournaments", "id_tournament");
	}

	public function create($arrData) {
		return parent::create($arrData);
	}

	public function find($strWhere, $strOrder = null, $intOffset = 0, $intCount = 0, $arrFields = null) {
		$sqlFields = $this->generateReadFields($arrFields);
		$sql = "SELECT $sqlFields, users.username
				FROM " . $this->tableName . "
				LEFT JOIN users ON users.user_id = tournaments.id_user
				WHERE $strWhere " . ($strOrder ? "ORDER BY $strOrder" : "");
				
		$return = $this->bdRead->query($sql, $intOffset, $intCount);

		$this->last = OP_READ;

		return $return;
	}
}

?>