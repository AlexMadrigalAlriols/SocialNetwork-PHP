<?php

class fwMySql {

	public static $bdInstance;

	var $_resource;
	var $_resultSet;
	var $_counter;

	function fwMySql($strHost, $strUserName, $strPassword, $strDatabase) {
		$this->connect($strHost, $strUserName, $strPassword, $strDatabase);
	}

    public static function &getInstance($strHost, $strUserName, $strPassword, $strDatabase) {
        if (!isset($bdInstance)) {
            $bdInstance = new fwMySql($strHost, $strUserName, $strPassword, $strDatabase);
        }

		$bdInstance->connect($strHost, $strUserName, $strPassword, $strDatabase);
        return $bdInstance;
    }

	function connect($strHost, $strUserName, $strPassword, $strDatabase) {
		if ($this->_resource = mysqli_connect($strHost, $strUserName, $strPassword, $strDatabase)) {
			mysqli_set_charset($this->_resource, "utf8mb4");
			return true;
		}

		return false;
	}

    function disconnect() {
        if ($this->_resource != null) {
            if ($this->_resultSet != null) {
                @mysqli_free_result($this->_resultSet);
                $this->_resultSet = null;
            }
        }

		mysqli_close($this->_resource);
		unset($this->_resource);
    }

    function isConnected() {
    	return ($this->_resource != false);
    }

    function query($sqlRender, $intOffset = 0, $intCount = 0) {
        $results = false;
		$i = 0;

        $this->_counter = 0;

        if (is_resource($this->_resultSet)) {
            mysqli_free_result($this->_resultSet);
            $this->_resultSet = null;
        }

		//mysqli_query("BEGIN", $this->_resource);
        if ($this->_resultSet = mysqli_query($this->_resource, $sqlRender)) {
			$results = array();
			if(!is_bool($this->_resultSet)){
				$this->_counter = @mysqli_num_rows($this->_resultSet);
			} else {
				$this->_counter = 0;
			}

			if ($this->_counter > 0) {
				if ($intOffset > $this->_counter) {
					$intOffset = 0;
				}

				if ($intOffset < $this->_counter) {
					@mysqli_data_seek($this->_resultSet, $intOffset);

					while (($row = mysqli_fetch_assoc($this->_resultSet)) && (($intCount > 0 && $i < $intCount) || ($intCount == 0))) {
						$results[] = $row;
						$i++;
					}
				}

			} else {
				$results = array();
				$this->_counter = mysqli_affected_rows($this->_resource);
			}
		}

		//mysqli_query("COMMIT", $this->_resource);
		
        return $results;
    }

	function queryOne($sqlRender) {
		$results = $this->query($sqlRender, 0, 1);

		if (count($results)) {
			return $results[0];
		} else {
			return false;
		}
	}

    function getLastInsertId() {
        return mysqli_insert_id($this->_resource);
    }

    function getNextInsertId($strTableName) {
        $results = $this->query("SHOW TABLE STATUS LIKE '$strTableName'");
        $results = $results[0];

        if ($results["Auto_increment"]) {
            return $results["Auto_increment"];
        }

        return 1;
    }

    function getLastCount() {
        return $this->_counter;
    }

	public function escape($strValue) {
		if (is_array($strValue)) {
			$return = array();

			foreach ($strValue as $k => $v) {
				$return[$k] = $this->escape($v);
			}
		} else {
			try {
				$return = mysqli_real_escape_string($this->_resource, $strValue);

				if ($return === false) {
					$return = addslashes(stripslashes($strValue)); 	
				}
			} catch (Exception $e) {
				$return = addslashes(stripslashes($strValue));
			}
		}

		return $return;
	}

	public static function getLastError() {
		return mysqli_error();
	}
}
?>