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

if (!class_exists('thickboxClass')) {
	class thickboxClass extends JAPopupHelper{
		// Modal name
		var $_modal_name;
		
		// Plugin params
		var $_pluginParams;
		
		// Param in {japopup} tag
		var $_tagParams;
		
		// Constructor
		function __construct($pluginParams){
			parent::__construct("thickbox", $pluginParams);
			$this->_modal_name = "thickbox";
			$this->_pluginParams = $pluginParams;
		}
		
		/**
		 * Get Library for Thickbox
		 * @param 	Array	$pluginParams	Plugin paramaters
		 * @return 	String	Include JS, CSS string.
		 * */
		function getHeaderLibrary($bodyString){
			// Base path string
			$hs_base    = JURI::base().'plugins/system/plg_japopup/'.$this->_modal_name.'/';
			// Tag array
			$headtag    = array();				
			$headtag[] = '<script src="'.$hs_base.'js/jquery.js" type="text/javascript" ></script>';
			$headtag[] = '<script src="'.$hs_base.'js/thickbox.js" type="text/javascript" ></script>';
			$headtag[] = '<script type="text/javascript" >if (jQuery && jQuery.noConflict) jQuery.noConflict( );</script>';
			$headtag[] = '<link href="'.$hs_base.'css/thickbox.css" type="text/css" rel="stylesheet" />';
			
			$bodyString = parent::getHeaderLibrary($bodyString, '/thickbox.js', $headtag);
				
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
			$ranID = time().rand(0,100);
			$content = html_entity_decode($content);
			
			$modalGroup 	= $this->getValue("group");
			if(!empty($modalGroup))
				$relGroup = 'jagroup'.$modalGroup;
			else{
				$relGroup = '';
			}
			$arrData['group'] 	= $modalGroup;
			$arrData['rel'] 	= $relGroup;
			
			$eventStr	= "";
			if($arrData['onopen'] != "" || $arrData['onclose'] != ""){
				$arrData['onopen'] = ($arrData['onopen'] != '')?"&amp;onOpen=".$arrData['onopen']:"";
				$arrData['onclose'] = ($arrData['onclose'] != '')?"&amp;onClose=".$arrData['onclose']:"'";
				$eventStr	= $arrData['onopen'].$arrData['onclose'];
			}
			
			$type = $this->getValue("type");
			$str = "";
			
			switch ($type){
				case "ajax":{
					$arrData['href'] = $arrData['href']."?height=".$arrData['frameHeight']."&amp;width=".$arrData['frameWidth'].$eventStr;
					$str .= $this->showDataInTemplate("thickbox", "default", $arrData);
					break;
				}
				
				case "iframe":{
					$arrData['href'] =  $arrData['href']."?keepThis=true&amp;TB_iframe=true&amp;height=".$arrData['frameHeight']."&amp;width=".$arrData['frameWidth'].$eventStr;
					$str .= $this->showDataInTemplate("thickbox", "default", $arrData);
					break;
				}
				
				case "inline":{
					$arrData['href'] =  "#TB_inline?height=".$arrData['frameHeight']."&amp;width=".$arrData['frameWidth']."&amp;inlineId=".$arrData['href'].$eventStr;
					$str .= $this->showDataInTemplate("thickbox", "default", $arrData);
					break;
				}
				
				case "image":{
					$arrData['href'] =  $arrData['href']."?keepThis=true&amp;TB_iframe=true".$eventStr;
					$str .= $this->showDataInTemplate("thickbox", "default", $arrData);
					break;
				}
				
				case "slideshow":{					
					
					$show = false;					
					foreach ($modalContent as $k=>$v){
						$image_url = trim($v);
						$arrData['href'] = $image_url;
						$arrData['rel'] = "gallery-plants";
						$arrData['content'] = "";
						
						if($arrData['imageNumber'] == "all"){
							$arrData['content'] = "<img src=\"".$image_url."\" width=".$arrData['frameWidth']."/>";
						}elseif($show === false){
							$show = true;
							$arrData['content']	= $content;
						}					
						
						$str .= $this->showDataInTemplate("thickbox", "default", $arrData);
					}										
					break;
				}
				
				case "youtube":{
					$arrData['YouTubeLink'] = $arrData['href'];
					$arrData['YouTubeID']	= "youtube".$ranID;
					$arrData['href'] = "#TB_inline?height=".$arrData['frameHeight']."&amp;width=".$arrData['frameWidth']."&amp;inlineId=youtube".$ranID.$eventStr;
					$str .= $this->showDataInTemplate("thickbox", "youtube", $arrData);
					
					break;
				}
				
			}
			
			// Return value string.
			return $str;
		}		
	}
}
?>