<?php
/*
# ------------------------------------------------------------------------
# JA T3v2 Plugin - Template framework for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - GNU/GPL V2, http://www.gnu.org/licenses/gpl2.html. For details 
# on licensing, Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JElementGFonts extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Fonts';

	function fetchElement( $name, $value, &$node, $control_name ) {
		t3_import('core/admin/util');
		
		$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(__FILE__) ));
		$uri = str_replace("/administrator", "", $uri);
		
		$gfont_group = array ('latin'=>array('Cantarell', 'Cardo', 'Crimson Text', 'Cuprum', 'Droid Sans', 'Droid Sans Mono', 'Droid Serif', 'IM Fell', 'Inconsolata', 'Josefin Sans Std Light', 'Lobster', 'Molengo', 'Neucha', 'Neuton', 'Nobile', 'OFL Sorts Mill Goudy TT', 'Old Standard TT', 'PT Sans', 'Philosopher', 'Reenie Beanie', 'Tangerine', 'Vollkorn', 'Yanone Kaffeesatz'),
						'Cyrillic'=>array('Cuprum', 'Neucha', 'PT Sans', 'Philosopher'),
						'Greek'=>array('GFS Didot','GFS Neohellenic'),
						'Khmer'=>array('Hanuman')
						);
		//embed google fonts
		if (!defined ('_GFONTS_ADDED')) {
			define ('_GFONTS_ADDED', 1);
			echo "<script type=\"text/javascript\">window.addEvent('load', function() {new Asset.css ('http://code.google.com/webfonts/css?kit=fRn5xRji3KlvfYTK4F2Aig');});</script>";
			echo "<script type=\"text/javascript\" src=\"$uri/assets/js/gfonts.js\"></script>\n";
		}
		
		$eid = $control_name.$name;
		$ename = $control_name.'['.$name.']';
		$lists = "";
		$lists .= "<select id=\"$eid.font\" name=\"$eid.font\" class=\"inputbox\">\n";
		if(in_array($name, array('gfont_logo', 'gfont_slogan'))){
			$lists .= "<option value=\"\">--- Select if logo type is text ---</option>\n";
		}
		else{
			$lists .= "<option value=\"\">--- Not applied ---</option>\n";
		}
		foreach ($gfont_group as $group=>$gfonts) {
			$lists .= "<optgroup label=\"$group\">\n";
			foreach ($gfonts as $gfont) {
				$selected = ($value == $gfont)?"selected=\"selected\"":"";
				$lists .= "<option style=\"font-family: '$gfont::Menu';font-size:2em;\" value=\"$gfont\" $selected>$gfont</option>\n";
			}
			$lists .= "</optgroup>\n";
		}
		$lists .= "</select>\n";
		//checkbox
		$lists .= "<input type=\"checkbox\" id=\"$eid.extra\" name=\"$eid.extra\" onclick=\"gfonts_showhideextra('$eid');\" \" />\n";
		$lists .= "<label for=\"$eid.extra\" class=\"editlinktip hasTip\" title=\"".JText::_('Custom CSS Desc')."\">".JText::_('Custom CSS')."</label>";
		//textarea, the extra property - hide by default. show when extra field is checked
		$lists .= "<textarea id=\"$eid.style\" cols=\"40\" rows=\"5\" name=\"$eid.style\" class=\"clearfix\" style=\"display:none; margin-top: 5px; clear: both; \"></textarea>\n";
		
		$lists .= "<input type=\"hidden\" id=\"$eid\" name=\"$ename\" value=\"$value\" rel=\"gfonts\" />\n";
		return $lists;
	}
} 