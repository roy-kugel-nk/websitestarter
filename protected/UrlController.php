<?php
/**
 * URL controller.
 * 
 * @author roy-kugel-nk
 */
class UrlController
{
	private $_urllist;
	private $_mapClass;
	
	/**
	 * Init url mapper class.
	 * 
	 * @param string $file File name for url mapper.
	 * @param string $className Class name for url mapper.
	 * @throws ErrorException
	 */
	function __construct( $file, $className = null ) {
		if ( is_null($file) || is_null($className) || !file_exists($file) ) {
			throw new ErrorException(__CLASS__ . " : No url map file.");
		}
		
		include $file;
		$this->_mapClass = new $className;
	}
	
	function getViewClass() {
		// URI.
		$uri = preg_replace("@/$@", '', $_SERVER['REQUEST_URI']). '/';
		
		// Search view class.
		foreach ( $this->_mapClass->_maps as $k=>$cls ) {
			$ptn = "@^{$k}$@";
			if ( preg_match($ptn, $uri, $match) !== 0 ) {
				// Get file including view class.
				$viewClassFile = Common::getPublicDirectory(). Common::getPhpize($cls);
				
				// Include.
				include $viewClassFile;
				$viewClass = new $cls;
				$viewClass->FileName = $viewClassFile;
				
				// Return class.
				return $viewClass;
			}
		}
		
		return null;
	}
}