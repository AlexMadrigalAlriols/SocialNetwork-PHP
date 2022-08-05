<?php

class fwFS {

	public static function exists($strPath) {
		 return file_exists($strPath);
	}

	public static function getDirectoryContents($strPath, $strPattern = "*", $blnRecursive = false, $blnListFiles = true, $blnListFolders = true, $_level = 0) {
		$strPath = fwFS::standarizePath($strPath);
		$pattern = str_replace(".", "\.", $strPattern);
		$pattern = str_replace("*", ".*", $pattern);
		$pattern = str_replace("/", "\/*", $pattern);
		$pattern = "/(" . $pattern . ")/i";

		$contents = array();

		if (fwFS::exists($strPath) && ($handler = opendir($strPath))) {
			while (false !== ($file = readdir($handler))) {
				if ($file !== "." && $file != ".." && $file != "libs") {
					$subPath = fwFS::standarizePath($strPath . "/" . $file);
					$isDir   = is_dir($subPath);

					if (preg_match($pattern, $file)) {
						if ($isDir == true && $blnListFolders) {
							$contents[] = $subPath;
						} elseif ($isDir == false && ($blnListFiles)) {
							$contents[] = $subPath;
						}
					}

					if ($blnRecursive == true && $isDir) {
						$contents = array_merge($contents, fwFS::getDirectoryContents($subPath, $strPattern, true, $blnListFiles, $blnListFolders, ($_level + 1)));
					}
				}
			}

			closedir($handler);
		}

		if ($_level == 0) {
			$temp = array();

			foreach ($contents as $content) {
				$content = str_replace($strPath, "", $content);

				if (strpos($content, "/") === 0) {
					$content = substr($content, 1);
				}

				$temp[] = $content;
			}

			$contents = $temp;
		}

		array_multisort(array_map("strtolower", $contents), SORT_ASC, SORT_STRING, $contents);

		return $contents;
	}

	public static function standarizePath($strPath) {
		$strPath = str_replace("\\", "/", $strPath);

		while (strpos($strPath, "//") !== false) {
			$strPath = str_replace("//", "/", $strPath);
		}

		return $strPath;
	}

	public static function getFileName($strPath) {
		$strPath = fwFS::standarizePath($strPath);

		if (strrpos($strPath, "/") !== false) {
			return substr($strPath, strrpos($strPath, "/") + 1);
		} else {
			return $strPath;
		}
	}

	public static function getFileNameWithoutExtension($strPath) {
		$strPath = fwFS::standarizePath($strPath);

		if (strrpos($strPath, "/") !== false) {
			$fileName  = substr($strPath, strrpos($strPath, "/") + 1);
		} else {
			$fileName = $strPath;
		}

		return str_replace("." . fwFS::getFileExtension($strPath), "", $fileName);
	}

	public static function getFileExtension($strPath) {
		$fileName = fwFS::getFileName($strPath);

		if (strrpos($strPath, ".") !== false) {
			return substr($strPath, strrpos($strPath, ".") + 1);
		} else {
			return "";
		}
	}

	public static function tail($file, $lines = 1) {
		$f = @fopen($file, "rb");
		if ($f === false) {
			return false;
		} else {
			$buffer = ($lines < 2 ? 64 : ($lines < 10 ? 512 : 4096));
		}

		fseek($f, -1, SEEK_END);

		if (fread($f, 1) != "\n") {
			$lines -= 1;
		}

		$output = "";
		$chunk = "";

		while (ftell($f) > 0 && $lines >= 0) {
			$seek = min(ftell($f), $buffer);
			fseek($f, -$seek, SEEK_CUR);
			$output = ($chunk = fread($f, $seek)) . $output;
			fseek($f, -mb_strlen($chunk, '8bit'), SEEK_CUR);
			$lines -= substr_count($chunk, "\n");
		}

		while ($lines++ < 0) {
			$output = substr($output, strpos($output, "\n") + 1);
		}

		fclose($f);
		return trim($output);
	}
}

?>