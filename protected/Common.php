<?php
/**
 * Common functions.
 * 
 * @author roy-kugel-nk
 */
class Common
{
	/**
	 * Get phpized string.
	 * 
	 * @param string $className Class name.
	 * @return string  Phpized string.
	 */
	static function getPhpize($className) {
		return "{$className}.php";
	}
	
	/**
	 * Get document root.
	 * @return string Document root with "/" finished.
	 */
	static function getDocumentRoot() {
		// Replace to fix slash.
		return preg_replace("@/$@", '', $_SERVER["DOCUMENT_ROOT"]). '/';
	}
	
	/**
	 * Get public directory.
	 * 
	 * @return string $publicDirectory
	 */
	static function getPublicDirectory() {
		$root = self::getDocumentRoot();
		$publicDirectory = $root. "public/";
		return $publicDirectory;
	}
	
	/**
	 * Get protected directory.
	 * 
	 * @return string $protectedDirectory
	 */
	static function getProtectedDirectory() {
		$root = self::getDocumentRoot();
		$protectedDirectory = $root. "protected/";
		return $protectedDirectory;
	}
}