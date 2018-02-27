<?php
/*
# ------------------------------------------------------------------------
# JA Tabs Plugins for Joomla 1.5
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

if (!defined ('_JEXEC')) {
	define( '_JEXEC', 1 );
	$path = dirname(dirname(dirname(dirname(__FILE__))));
	define('JPATH_BASE', $path );

	if (strpos(php_sapi_name(), 'cgi') !== false && !empty($_SERVER['REQUEST_URI'])) {
		//Apache CGI
		$_SERVER['PHP_SELF'] =  rtrim(dirname(dirname(dirname($_SERVER['PHP_SELF']))), '/\\');
	} else {
		//Others
		$_SERVER['SCRIPT_NAME'] =  rtrim(dirname(dirname(dirname($_SERVER['SCRIPT_NAME']))), '/\\');
	}
	
	define( 'DS', DIRECTORY_SEPARATOR );
	require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
	JDEBUG ? $_PROFILER->mark( 'afterLoad' ) : null;

	$mainframe =& JFactory::getApplication('site');
	
	// set the language
	$mainframe->initialise();
	// SSL check - $http_host returns <live site url>:<port number if it is 443>
	JPluginHelper::importPlugin('system', null, false);
	// trigger the onStart events
	$mainframe->triggerEvent( 'onStart' );
}

$tab = '';
if(isset($_REQUEST['tab'])){
	$tab = $_REQUEST['tab'];
}

switch ($_REQUEST ['type']) {
  case 'content':
	writeContentArticle($tab);
    break;
  case 'modules':
  	writeContentModules($tab);
    break;
}

function writeContentArticle($tab){
	$row = array();
	$row = getArticle($tab);
	if(!$row){
		return;
	}
	
	if(isset($_REQUEST['view']) && $_REQUEST['view']=='fulltext'){
	  	$row->text = $row->introtext.$row->fulltext;
	}else{
		$row->text = $row->introtext;
	}
	 
	jimport('joomla.plugin.helper');
	JPluginHelper::importPlugin('content');
	
	$app = &JFactory::getApplication();
	$pparams = new JParameter('');
	$app->triggerEvent('onPrepareContent', array($row, $pparams, 0));
	echo $row->text;
}

function writeContentModules($tab){	
	jimport('joomla.application.module.helper');
	$module = getModule($tab);	
	if(!$module) return;
	echo JModuleHelper::renderModule($module);	
}


/**
 * Load published modules
 *
 * @access	private
 * @return	array
 */
function getModule($id){
	global $mainframe;

	$modules =& JModuleHelper::_load();
	$total  = count($modules);
	for ($i = 0; $i < $total; $i++){
		// Match the name of the module
		if ($modules[$i]->id == $id){
			$module = $modules[$i];			
			return $module;
		}
	}
	
	return;	
}

function getList($ids='', $catid=''){
	global $mainframe;
	$db 	=& JFactory::getDBO();
	$user 	=& JFactory::getUser();
	$aid	= $user->get('aid', 0);

	$contentConfig	= &JComponentHelper::getParams( 'com_content' );
	$noauth			= !$contentConfig->get('shownoauth');

	jimport('joomla.utilities.date');
	$date = new JDate();
	$now = $date->toMySQL();

	$nullDate = $db->getNullDate();

	// query to determine article count
	$query = 'SELECT a.* ' .		
		' FROM #__content AS a' .
		' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
		' INNER JOIN #__sections AS s ON s.id = a.sectionid';
	$query .=	" WHERE a.id = $ids";
		
	$db->setQuery($query);
	$rows = $db->loadObjectList();
	return $rows[0];
}

function getArticle($id=''){
	global $mainframe;
	$db 	=& JFactory::getDBO();
	$user 	=& JFactory::getUser();
	$aid	= $user->get('aid', 0);

	$contentConfig	= &JComponentHelper::getParams( 'com_content' );
	$noauth			= !$contentConfig->get('shownoauth');

	jimport('joomla.utilities.date');
	$date = new JDate();
	$now = $date->toMySQL();

	$nullDate = $db->getNullDate();

	// query to determine article count
	$query = 'SELECT a.* ' .		
		' FROM #__content AS a' .
		' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
		' INNER JOIN #__sections AS s ON s.id = a.sectionid';
	$query .=	" WHERE a.id=". (int)$id;
		
	$db->setQuery($query);
	return $db->loadObject();
}
?>