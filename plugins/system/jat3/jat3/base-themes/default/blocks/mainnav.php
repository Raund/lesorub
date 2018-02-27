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
?>
<?php $this->genBlockBegin ($block) ?>
	<?php if (($jamenu = $this->loadMenu())) $jamenu->genMenu (); ?>
	<!-- jdoc:include type="menu" level="0" / -->
	<?php if ($this->hasSubmenu() && ($jamenu = $this->loadMenu())) : ?>
	<div id="ja-subnav" class="clearfix">
	<?php $jamenu->genMenu (1); ?>
	<!-- jdoc:include type="menu" level="1" / -->
	</div>
	<?php endif;?>
<?php $this->genBlockEnd ($block) ?>

<ul class="no-display">
    <li><a href="<?php echo $this->getCurrentURL();?>#ja-content" title="<?php echo JText::_("Skip to content");?>"><?php echo JText::_("Skip to content");?></a></li>
</ul>
