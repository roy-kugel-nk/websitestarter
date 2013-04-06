<?php
/**
 * Starter class.
 * @static
 * @author roy-kugel-nk
 */
final class Starter {
	const VIEW_PARENT = "ViewClass";
	const COMMON = "Common";
	const URL_CONTROLLER = "UrlController";
	const URL_MAP = "UrlMap";
	const INIT = "Init";
	
	static private $_views;
	
	/**
	 * Start program.
	 * 
	 */
	static function start() {
		try {
			// Include needed files.
			include_once self::COMMON. ".php";
			$urlCntrName = self::URL_CONTROLLER;
			include_once Common::getPhpize( $urlCntrName );
			include_once "view/". Common::getPhpize( self::VIEW_PARENT );
			
			// Initialize something. Init class defined by user.
			$initFile = Common::getPublicDirectory(). Common::getPhpize( self::INIT );
			if ( !file_exists($initFile) ) {
				throw new ErrorException("No init file on public directory.");
			}
			include_once $initFile;
			$initClass = self::INIT;
			$init = new $initClass;
			$init->exec();
			
			// URL list defined by user.
			$urlMapFile = Common::getPublicDirectory(). Common::getPhpize( self::URL_MAP );
			if ( !file_exists($urlMapFile) ) {
				throw new ErrorException("No URL mapper file on public directory.");
			}
			
			// Init url controller.
			$urlController = new $urlCntrName( $urlMapFile, self::URL_MAP );
			
			// Check server vars and get view class.
			self::addViewClass( $urlController->getViewClass() );
			
			// Echo combined view strings.
			echo self::combineViews();
		} catch (ErrorException $ee) {
			// Echo error exception.
			echo "File : {$ee->getFile()} \nMessage : {$ee->getMessage()}\n";
		} catch (Exception $e) {
			// Echo exception.
			echo "File : {$e->getFile()} \nMessage : {$e->getMessage()}\n";
		}
		exit;
	}
	
	/**
	 * Combine view class output.
	 * 
	 * @return string $conbined Combined string.
	 */
	static function combineViews() {
		// Init.
		$combined = "";
		
		// Check view classes.
		if ( !is_null(self::$_views) ) {
			foreach (self::$_views as $viewClass) {
				
				// When view class is sub class of "ViewClass", execute onLoad() and add view string.
				if ( is_subclass_of($viewClass, self::VIEW_PARENT) ) {
					$viewClass->onLoad();
					$combined .= $viewClass->view();
				}
			}
		}
		
		return $combined;
	}
	
	/**
	 * Add view class.
	 * 
	 * @param ViewClass $object View class for access.
	 */
	static function addViewClass($object) {
		// Init.
		if ( !is_array(self::$_views) ) {
			self::$_views = array();
		}
		
		// Check object and add to array.
		if ( !is_null($object) && is_subclass_of($object, self::VIEW_PARENT) ) {
			self::$_views[] = $object;
		}
	}
}