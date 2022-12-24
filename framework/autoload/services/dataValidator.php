<?php

class dataValidator {

	private $value;

	public function __construct() {}

    public function value($value) {
		$this->value = trim($value);
		return $this;
	}

	public function validate() {
		return $this->value;
	}

	public function notEmpty() {
		$this->value = (empty($this->value) ? false : $this->value);
		return $this;
	}

	public function minLength($length) {
		$this->value = (strlen($this->value) < $length ? false : $this->value);
		return $this;
	}

	public function maxLength($length) {
		$this->value = (strlen($this->value) > $length ? false : $this->value);
		return $this;
	}

	public function trim() {
		$this->value = trim($this->value);
		return $this;
	}

	public function email() {
		$this->value = (is_string(filter_var($this->value, FILTER_VALIDATE_EMAIL)) ? $this->value : false);
		return $this;
	}

	public function url() {
		if (preg_match("/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/i", $this->value)) {
			return $this;
		} else {
			$this->value = false;
		}

	}

	public function date($format = "Y-m-d") {
		$parsed = date_parse_from_format($format, $this->value);
		$this->value = (!$parsed || ($parsed && count($parsed["errors"])) ? false : $this->value);
		return $this;
	}

	public function username() {
		$this->value = preg_replace("/[^a-z0-9_-]+/", "", strtolower($this->value));
		return $this;
	}

	public function sanitizeAlphanumeric() {
		$this->value = preg_replace("/[^ña-z0-9ÑA-Z _-]+/", "", $this->value);
		return $this;
	}

	public function equals($value) {
		$this->value = ($this->value === $value ? $this->value : false);
		return $this;
	}

	public function greaterThan($value) {
		$this->value = ($this->value > $value ? $this->value : false);
		return $this;
	}

	public function inArray($array) {
		$this->value = (in_array($this->value, $array) ? $this->value : false);
		return $this;
	}
}
