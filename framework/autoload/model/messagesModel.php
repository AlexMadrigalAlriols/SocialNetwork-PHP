<?php

class messagesModel extends fwModel {

	public function __construct() {
		$this->fwModel("messages", "id_message");
	}

	public function create($arrData) {
		return parent::create($arrData);
	}

	public function find($strWhere, $strOrder = null, $intOffset = 0, $intCount = 0, $arrFields = null) {
		$sqlFields = $this->generateReadFields($arrFields);
		$sql = "SELECT $sqlFields, users.name, users.username, users.profile_image
				FROM " . $this->tableName . "
				LEFT JOIN users ON users.user_id = messages.id_user_destination
				WHERE $strWhere " . ($strOrder ? "ORDER BY $strOrder" : "");

		$return = $this->bdRead->query($sql, $intOffset, $intCount);
		$this->last = OP_READ;

		return $return;
	}

	public function findByUser($id_user) {
		return $this->find("id_user='$id_user'", "messages.date_sent ASC");
	}

	public function update($id, $arrData) {
		return parent::update($id, $arrData);
	}
}

?>