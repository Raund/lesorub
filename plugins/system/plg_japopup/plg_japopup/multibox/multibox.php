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

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if (!class_exists('multiboxClass')) {
	class multiboxClass extends JAPopupHelper{
		// Modal name
		var $_modal_name;
		
		// Plugin params
		var $_pluginParams;
		
		// Param in {japopup} tag
		var $_tagParams;
		
		// Constructor
		function __construct($pluginParams){
			parent::__construct("multibox", $pluginParams);
			$this->_modal_name = "multibox";
			$this->_pluginParams = $pluginParams;
		}
		
		/**
		 * Get Library for MultiBox
		 * @param 	Array	$pluginParams	Plugin paramaters
		 * @return 	String	Include JS, CSS string.
		 * */
		function getHeaderLibrary($bodyString){				
			// Base path string
			$hs_base    = JURI::base().'plugins/system/plg_japopup/'.$this->_modal_name.'/';
			// Tag array
			$headtag    = array();
			$headtag[] = '<script src="'.$hs_base.'js/overlay.js" type="text/javascript" ></script>';
			$headtag[] = '<script src="'.$hs_base.'js/multibox.js" type="text/javascript" ></script>';				
			$headtag[] = '<link href="'.$hs_base.'css/multibox.css" type="text/css" rel="stylesheet" />';
								
			$bodyString = parent::getHeaderLibrary($bodyString, '/multibox.js', $headtag);
				
			return $bodyString;
		}
		
		/**
		 * Get content to display in Front-End.
		 * @param 	Array	$paras	Key and value in {japopup} tag
		 * @return 	String	HTML string to display
		 * */
		function getContent($paras, $content){			
			$arrData = parent::getCommonValue($paras, $content);
			
			// Generate random id
			$ranID = rand(0,10000);
			// To standard content
			$content = html_entity_decode($content);
			
			$eventStr	= "";
			if($arrData['onopen'] != "" || $arrData['onclose'] != ""){
				$arrData['onopen'] = ($arrData['onopen'] != '')?",onOpen: ".$arrData['onopen']:"";
				$arrData['onclose'] = ($arrData['onclose'] != '')?",onClose: ".$arrData['onclose']:"'";
				$eventStr	= $arrData['onopen'].$arrData['onclose'];
			}
			
			$str = "";
			$modalGroup 	= $this->getValue("group");
			if(!empty($modalGroup)){
				$classGroup = 'jagroup'.$modalGroup;
				$str .= '<script type="text/javascript" > if(! box'.$modalGroup.' ) {var box'.$modalGroup.' = {}; window.addEvent("domready", function(){ box'.$modalGroup.' = new MultiBox("jagroup'.$modalGroup.'", {descClassName: "multiBoxDesc", useOverlay: '.$this->_pluginParams->get("overlay").', contentColor: "'.$this->_pluginParams->get("group1-multibox-contentColor").'", showControls: '.$this->_pluginParams->get("group1-multibox-showControls").' '.$eventStr.' }); }); } </script>';
			}else{
				$classGroup = 'jagroup'.$ranID;
				$str .= '<script type="text/javascript" > var box'.$ranID.' = {}; window.addEvent("domready", function(){ box'.$ranID.' = new MultiBox("jagroup'.$ranID.'", {descClassName: "multiBoxDesc", useOverlay: '.$this->_pluginParams->get("overlay").', contentColor: "'.$this->_pluginParams->get("group1-multibox-contentColor").'", showControls: '.$this->_pluginParams->get("group1-multibox-showControls").' '.$eventStr.' }); }); </script>';
			}
			$arrData["group"] 	= $modalGroup;
			$arrData["id"] 		= "mb".$ranID;
			$arrData["class"] 	= $classGroup;
			
			
			
			$type = $this->getValue("type");
			
			switch ($type){
				case "ajax":
				case "iframe":{
					$arrData['rel'] = "type:iframe,width:".$arrData["frameWidth"].",height:".$arrData["frameHeight"];
					$str .= $this->showDataInTemplate("multibox", "default", $arrData);
					break;
				}
				
				case "inline":{
					$arrData['href'] = "#".$arrData['href'];
					$arrData['rel'] = "type:element,width:".$arrData["frameWidth"].",height:".$arrData["frameHeight"];
					$str .= $this->showDataInTemplate("multibox", "default", $arrData);
					break;
				}
				
				case "image":{
					$arrData['rel'] = "type:jpg";
					$str .= $this->showDataInTemplate("multibox", "default", $arrData);
					break;
				}
				
				case "slideshow":{					
						
					$show = false;					
					foreach ($modalContent as $k=>$v){
						$image_url = trim($v);			
						$arrData['rel'] = "type:jpg";
						$arrData['href'] = $image_url;
						$arrData['content'] = "";
						
						if($arrData['imageNumber'] == "all"){
							$arrData['content'] = "<img src=\"".$image_url."\" width=\"".$arrData["frameWidth"]."\"/>";
						}elseif($show === false){
							$show = true;
							$arrData['content']	= $content;
						}					
						
						$str .= $this->showDataInTemplate("multibox", "default", $arrData);
					}										
					break;
				}
				
				case "youtube":{
					$arrData['rel'] = "type:swf";
					$str .= $this->showDataInTemplate("multibox", "default", $arrData);
					break;
				}
				
			}
			
			// Return value string.
			return $str;
		}	
	}
}
?>