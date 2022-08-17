<?php

class publicationsModel extends fwModel {

	public function __construct() {
		$this->fwModel("publications", "id_publication");
	}

	public function create($arrData) {
		return parent::create($arrData);
	}

	public function find($strWhere, $strOrder = null, $intOffset = 0, $intCount = 0, $arrFields = null) {
		$sqlFields = $this->generateReadFields($arrFields);
		$sql = "SELECT $sqlFields, users.name, users.username, users.profile_image, 
			decks.deck_img, decks.name as 'deck_name', decks.format, decks.colors, decks.totalPrice, decks.priceTix
				FROM " . $this->tableName . "
				LEFT JOIN users ON users.user_id = publications.id_user
				LEFT JOIN decks ON decks.id_deck = publications.publication_deck
				WHERE $strWhere " . ($strOrder ? "ORDER BY $strOrder" : "");

		$return = $this->bdRead->query($sql, $intOffset, $intCount);
		$this->last = OP_READ;

		return $return;
	}

	public function findByUser($id_user) {
		return $this->find("id_user='$id_user'", "publications.publication_date DESC");
	}

	public function update($id, $arrData) {
		return parent::update($id, $arrData);
	}
}

?>