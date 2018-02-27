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
<div id="ja-header" class="main clearfix">
	<?php
	$siteName = $this->sitename();
	if ($this->getParam('logoType')=='image'): ?>
	<h1 class="logo">
		<a href="index.php" title="<?php echo $siteName; ?>"><span><?php echo $siteName; ?></span></a>
	</h1>
	<?php else:
	$logoText = (trim($this->getParam('logoType-text-logoText'))=='') ? $siteName : $this->getParam('logoType-text-logoText');
	$sloganText = (trim($this->getParam('logoType-text-sloganText'))=='') ? JText::_('SITE SLOGAN') : $this->getParam('logoType-text-sloganText');?>
	<div class="logo-text">
		<h1><a href="index.php" title="<?php echo $siteName; ?>"><span><?php echo $logoText; ?></span></a></h1>
		<p class="site-slogan"><?php echo $sloganText;?></p>
	</div>
	<?php endif; ?>
</div>
	