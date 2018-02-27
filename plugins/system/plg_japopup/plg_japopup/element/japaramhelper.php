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

// Ensure this file is being included by a parent file
defined('_JEXEC') or die( 'Restricted access' );

/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JElementJaparamhelper extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Japaramhelper';

	function fetchElement( $name, $value, &$node, $control_name ) {
		if (substr($name, 0, 1) == '@'  ) {
			$name = substr($name, 1);
			if (method_exists ($this, $name)) {
				return $this->$name ($name, $value, $node, $control_name);
			}
		}
		return; 
	}
	function fetchTooltip( $label, $description, &$node, $control_name, $name )
	{
		return;
	}
	
	/**
	 * render title.
	 */
	function title( $name, $value, &$node, $control_name ) {	
		$_title			= ( isset( $node->_attributes['label'] ) ) ? $node->_attributes['label'] : '';
		$_description	= ( isset( $node->_attributes['description'] ) ) ? $node->_attributes['description'] : '';
		$_url			= ( isset( $node->_attributes['url'] ) ) ? $node->_attributes['url'] : '';
		$class			= ( isset( $node->_attributes['class'] ) ) ? $node->_attributes['class'] : '';
		$group			= ( isset( $node->_attributes['group'] ) ) ? $node->_attributes['group'] : '';
		$group			= $group ? "id='params$group-group'":"";
		if ( $_title ) {
			$_title = html_entity_decode( JText::_( $_title ) );
		}

		if ( $_description ) { $_description = html_entity_decode( JText::_( $_description ) ); }
		if ( $_url ) { $_url = " <a target='_blank' href='{$_url}' >[".html_entity_decode( JText::_( "Demo" ) )."]</a> "; }

		$html = '
		<h4 class="block-head '.$class.'" '.$group.'>'.$_title.$_url.'</h4>
		<div class="block-des '.$class.'">'.$_description.'</div>
		';

		return $html;
	}
	
	function radio( $name, $value, &$node, $control_name ){
		$options = array ();
		foreach ($node->children() as $option)
		{
			$val	= $option->attributes('value');
			$text	= $option->data();
			$_url	= $option->attributes('url');
			if ( $_url ) { $_url = " <a target='_blank' href='{$_url}' >[".html_entity_decode( JText::_( "Website" ) )."]</a> "; }
			
			$options[] = JHTML::_( 'select.option', $val, JText::_( $text ) );
		}

		return JHTML::_('select.radiolist', $options, ''.$control_name.'['.$name.']', '', 'value', 'text', $value, $control_name.$name );
	}
	/**
	 * render js to control setting form.
	 */
	function group( $name, $value, &$node, $control_name ){ 
		$attributes = $node->attributes(); // echo '<pre>'.print_r($attributes); die;
		$groups = array();
		if( isset($attributes['value']) && $attributes['value'] != "" ){
			$groups = split("[|]", $attributes['value']);
		}
		
		if (!defined ('_JA_PARAM_HELPER')) {
			define ('_JA_PARAM_HELPER', 1);
			$uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(__FILE__) ));
			$uri = str_replace("/administrator", "", $uri);
			
			JHTML::stylesheet('japaramhelper.css', $uri."/");
			JHTML::script('japaramhelper.js', $uri."/");
		}
?>
<script type="text/javascript">
		window.addEvent( "domready", function(){
			<?php foreach ($groups as $group):?>
			initjapramhelpergroup( "<?php echo $group; ?>", { hideRow:<?php echo(isset($attributes['hiderow']) ? $attributes['hiderow']:false) ?>} );
			<?php endforeach;?>
		} );
</script>
<?php		
	return;
	}
} 