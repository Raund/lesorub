<?php
/*
# ------------------------------------------------------------------------
# JA Portfolio Template
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
?>
<?php $this->genBlockBegin ($block) ?>    

	<?php if($this->countModules('footnav')) : ?>
	<div class="ja-footnav">
		<jdoc:include type="modules" name="footnav" />
	</div>
	<?php endif; ?>

	<div class="ja-copyright">
		<jdoc:include type="modules" name="footer" />
	</div>
	
	<?php 
	$t3_logo = $this->getParam ('setting_t3logo', 't3-logo-light', 't3-logo-dark');
	if ($t3_logo != 'none') : ?>
	<div id="ja-poweredby" class="<?php echo $t3_logo ?>">
		<a href="http://t3.joomlart.com" title="Powered By T3 Framework" target="_blank">Powered By T3 Framework</a>
	</div>  	
	<?php endif; ?>
<?php $this->genBlockEnd ($block) ?>