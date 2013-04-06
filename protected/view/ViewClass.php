<?php
/**
 * Super class for view.
 * Functions for extends.
 * 
 * @author roy-kugel-nk
 */
class ViewClass
{
	private $_fileName;
	
	/**
	 * Magic method for getter.
	 * 
	 * @param string $name Getter method name.
	 * @return mix
	 */
	final function __get($name) {
		$getter = "get{$name}";
		return $this->$getter();
	}
	
	/**
	 * Magic method for setter.
	 * 
	 * @param string $name Setter method name.
	 * @param mix $value Parameter for setter.
	 * @return mix
	 */
	final function __set($name, $value) {
		$setter = "set{$name}";
		$this->$setter($value);
	}
	
	/**
	 * Set current view file name.
	 * @param string $fileName
	 */
	final function setFileName($fileName) {
		$this->_fileName = $fileName;
	}
	
	/**
	 * Get current view file name.
	 * @return string
	 */
	final function getFileName() {
		return $this->_fileName;
	}
	
	/**
	 * Invoked when onload.
	 * 
	 * @param mix $param Parameters.
	 */
	function onLoad($param = null) {
		// Do nothing.
	}
	
	/**
	 * Return string.
	 * @return string
	 */
	function view() {
		// Init.
		$output = "";
		$htmlFile = str_replace(".php", ".html", $this->getFileName());
		
		// Check html file.
		if ( file_exists($htmlFile) ) {
			$output = file_get_contents($htmlFile);
			
			// Execute php script in html file.
			if ( preg_match_all("@\<\?\=(.*?)\?\>@", $output, $matches, PREG_SET_ORDER) !== false ) {
				foreach ( $matches as $match ) {
					$ret = "";
					$exec = $match[1];
					eval("\$ret = {$exec};");
					$output = str_replace($match[0], $ret, $output);
				}
			}
		}
		
		// Return string.
		return $output;
	}
}