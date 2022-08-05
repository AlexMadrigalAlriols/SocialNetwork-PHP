<?php

class fwModel {

	protected $bdWrite;
	protected $bdRead;
	protected $tableName;
	protected $idField;
	protected $last;

	public function fwModel($strTableName, $strIdField) {
		$my_write = array(
 			"host"	=> gc::getSetting("mysql.host"),
 			"user"	=> gc::getSetting("mysql.user"),
 			"pass"	=> gc::getSetting("mysql.pass"),
 			"db"	=> gc::getSetting("mysql.db"),
		);

		$my_read = array(
			"host"	=> gc::getSetting("mysql.host"),
			"user"	=> gc::getSetting("mysql.user"),
			"pass"	=> gc::getSetting("mysql.pass"),
			"db"	=> gc::getSetting("mysql.db"),
		);

		$this->bdWrite = fwMySql::getInstance($my_write["host"], $my_write["user"], $my_write["pass"], $my_write["db"]);
		$this->bdRead = fwMySql::getInstance($my_read["host"], $my_read["user"], $my_read["pass"], $my_read["db"]);
		$this->tableName = $strTableName;
		$this->idField = $strIdField;

		$this->last = null;
	}

	public function create($arrData) {
		$sqlFields = "";
		$sqlValues = "";

		foreach ($arrData as $k => $v) {
			$sqlFields .= ($sqlFields ? "," : "") . $k;
			$sqlValues .= ($sqlValues ? "," : "") . "'" . $this->bdWrite->escape($v) . "'";
		}

		$sql = "INSERT INTO " . $this->tableName ." ($sqlFields) VALUES ($sqlValues)";

		$this->bdWrite->query($sql);
		$this->last = OP_WRITE;

		return $this->getLastInsertId();
	}

	/**
	* Load one model by id(s)
	* @param 	$id 		Integer or array of identifiers
	* @param 	$arrFields	Restrict fields to query
	*
	* @return 	Array with model data
	*/
	public function load($id, $arrFields = null) {
		$sqlFields = $this->generateReadFields($arrFields);
		$sqlIds = $this->generateIdFields(is_array($id) ? $id : array($this->idField => $id));

		if ($sqlIds) {
			$sql = "SELECT $sqlFields FROM " . $this->tableName . " WHERE " . $sqlIds;

			$return = $this->bdRead->queryOne($sql);
			$this->last = OP_READ;

			return $return;
		}

		return false;
	}

	public function find($strWhere, $strOrder = null, $intOffset = 0, $intCount = 0, $arrFields = null) {
		$sqlFields = $this->generateReadFields($arrFields);
		$sql = "SELECT $sqlFields FROM " . $this->tableName . " WHERE $strWhere " . ($strOrder ? "ORDER BY $strOrder" : "");
		
		$return = $this->bdRead->query($sql, $intOffset, $intCount);
		$this->last = OP_READ;

		return $return;
	}

	public function findOne($strWhere, $strOrder = null, $arrFields = null) {
		$results = $this->find($strWhere, $strOrder, 0, 1, $arrFields);

		if (count($results)) {
			return $results[0];
		} else {
			return false;
		}
	}

	/**
	* Update one model by id(s)
	* @param 	$id 		Integer or array of identifiers
	* @param 	$arrData	Fields => values to update
	*
	* @return 	Bool
	*/
	public function update($id, $arrData) {
		$sqlFields = "";
		$sqlIds = $this->generateIdFields(is_array($id) ? $id : array($this->idField => $id));

		if ($sqlIds && $arrData && is_array($arrData)) {
			foreach ($arrData as $k => $v) {
				$sqlFields .= ($sqlFields ? "," : "") . $k . "='" . $this->bdWrite->escape($v) . "'";
			}

			$sql = "UPDATE " . $this->tableName . " SET " . $sqlFields . " WHERE " .$sqlIds;

			$return = $this->bdWrite->query($sql);
			$this->last = OP_WRITE;
			return ($this->bdWrite->getLastCount() > 0);
		}

		return false;
	}

	/**
	* Delete one model by id(s)
	* @param 	$id 		Integer or array of identifiers
	* @param 	$arrData	Fields => values to update
	*
	* @return 	Bool
	*/
	public function delete($id, $strWhere = false) {
		$sqlIds = $this->generateIdFields(is_array($id) ? $id : array($this->idField => $id));

		if($strWhere){
			$sqlIds = $strWhere;
		}

		if ($sqlIds) {
			$sql = "DELETE FROM " . $this->tableName . " WHERE " . $sqlIds;

			$this->bdWrite->query($sql);
			$this->last = OP_WRITE;

			return true;
		}

		return false;
	}

	/**
	* Exec a raw sql query
	* @param 	$sql 		SQL query to exec
	*
	* @return 	Array with results
	*/
	public function exec($sql, $intOffset = 0, $intCount = 0) {
		$return = $this->bdRead->query($sql, $intOffset, $intCount);
		$this->last = OP_READ;

		return $return;
	}

    public function getLastInsertId() {
        return $this->bdWrite->getLastInsertId();
    }

    public function getNextInsertId() {
    	return $this->bdWrite->getNextInsertId($this->tableName);
    }

    public function getLastCount() {
    	if ($this->last == OP_WRITE) {
    		return $this->bdWrite->getLastCount();
    	} elseif ($this->last == OP_READ) {
    		return $this->bdRead->getLastCount();
    	}

        return false;
    }

	protected function generateIdFields($arrIds) {
		$return = "";

		if ($arrIds && is_array($arrIds)) {
			foreach ($arrIds as $k => $v) {
				$return .= ($return ? " AND " : "") . (strpos($k, ".") === false ? $this->tableName . "." . $k : $k) . "='" . $this->bdWrite->escape($v) . "'";
			}
		}

		return ($return ? "(" . $return . ")" : "");
	}

    protected function generateReadFields($arrFields) {
		$return = "";
		
		if ($arrFields && is_array($arrFields)) {
			foreach ($arrFields as $f) {
				$return .= ($return ? "," : "") . $f;
			}
		} else {
			$return = $this->tableName . ".*";
		}
		
		return $return;
    }
}

?>