<?php

class reportModel extends fwModel {

	public function __construct() {
		$this->fwModel("reports", "id_report");
	}

	public function create($arrData) {
		return parent::create($arrData);
	}

	public function find($strWhere, $strOrder = null, $intOffset = 0, $intCount = 0, $arrFields = null) {
		$sqlFields = $this->generateReadFields($arrFields);
		$sql = "SELECT $sqlFields, users.name, users.username, users.profile_image
				FROM " . $this->tableName . " 
				LEFT JOIN users ON users.user_id = reports.id_user
				WHERE $strWhere " . ($strOrder ? "ORDER BY $strOrder" : "");

		$return = $this->bdRead->query($sql, $intOffset, $intCount);
		$this->last = OP_READ;

		return $return;
	}

	public function findByUser($id_user) {
		if($result = $this->find("notifications.user_id='$id_user'", "notifications.notification_date ASC")){
			return $result;
		}

		return false;
	}
}

?>