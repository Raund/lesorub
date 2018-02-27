<?php
/*
# ------------------------------------------------------------------------
# JA Popup plugin for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# bound by Proprietary License of JoomlArt. For details on licensing, 
# Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/

defined( '_JEXEC' ) or die();
jimport( 'joomla.plugin.plugin' );
jimport('joomla.application.module.helper');
// Import library dependencies
jimport( 'joomla.event.plugin' );

/**
 * JAPopup Content Plugin
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 		1.5
 */
class plgSystemPlg_JAPopup extends JPlugin
{

	/** @var object $_modalObject  */
	var $_modalObject;
	var $_params;
	
	function plgSystemPlg_JAPopup( &$subject ){
		parent::__construct( $subject );

		// load plugin parameters
		$this->_plugin = JPluginHelper::getPlugin( 'system', 'plg_japopup' );
		$this->_params = new JParameter( $this->_plugin->params );
		// Get modal window type
		$modalWindowType = $this->_params->get("group1", "fancybox");
		
		// Require library for each Popup type
		require_once(dirname( __FILE__ ).'/plg_japopup/popupHelper.php');
		if (!file_exists(dirname( __FILE__ ).'/plg_japopup/'.$modalWindowType.'/'.$modalWindowType.'.php')) return;
		require_once( dirname( __FILE__ ).'/plg_japopup/'.$modalWindowType.'/'.$modalWindowType.'.php');
		$modalWindowType		= $modalWindowType."Class";
		$modalWindowTypeObject 	= new $modalWindowType($this->_params);
		
		// Assign modal type object
		$this->_modalObject = $modalWindowTypeObject;
	}
	
	/**
	 * Popup prepare content method
	 *
	 * @param 	string		The body string content.
	 */
	function replaceContent( $bodyContent )
	{
		global $mainframe;
		// Get plugin identifier in article content
		if (JString::strpos( $bodyContent, '{japopup' ) === false){
			$HSmethodDIRECT = false;
		}else{
			$HSmethodDIRECT = true;
		}
		
		if($HSmethodDIRECT){
			require_once(dirname( __FILE__ ).'/plg_japopup/helper.php');
			$parser = new ReplaceCallbackParsers('japopup', $this->_params);
			$bodyContent = $parser->parse($bodyContent, array($this->_modalObject, 'getContent', 'getHeaderLibrary'));
		}
		return $bodyContent;
	}
	
	function onAfterRender()
	{
		// Return if page is not html
		global $mainframe;
		
		if ( $mainframe->isAdmin() ) { return; }
		
		if (!isset($this->_plugin)) return;
		
		$_body = JResponse::getBody();
		
		// Replace {japopup} tag by appropriate content to show popup
		$_body = $this->replaceContent($_body);
		
		if ( $_body ) {
			JResponse::setBody( $_body );
		}
		return true;
	}
}
?>