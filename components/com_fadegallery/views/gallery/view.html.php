<?php
/**
 * FadeGallery Joomla! 1.6 Native Component
 * @version 1.3.5
 * @author DesignCompass corp< <admin@designcompasscorp.com>
 * @link http://www.designcompasscorp.com
 * @license GNU/GPL
 **/


// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view'); //Important to get menu parameters
class FadeGalleryViewGallery extends JView {

	function display($tpl = null)
	{
		
		//$params = &JComponentHelper::getParams( 'com_fadegallery' );
		$app		= JFactory::getApplication();
		$params=$app->getParams();
			
		$this->assignRef('params',$params);
		
				
        parent::display($tpl);
	}
	
}
?>
	