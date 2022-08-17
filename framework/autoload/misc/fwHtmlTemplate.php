<?php

class fwHtmlTemplate {

	/**
	* Render any html template including each data key as variable
	*/	
	public static function render($file, $data) {
		extract($data);

		$_buffer = "";

		if (fwFS::exists($file)) {
			ob_start();
			include($file);
			$_buffer = ob_get_contents();
			ob_end_clean();
		}

		return $_buffer;
	}
}

?>