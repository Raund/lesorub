<?php
/**
* @title		Simple image gallery module
* @version		2.1
* @website		http://www.joomshaper.com
* @copyright	Copyright (C) 2010 JoomShaper.com. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<?php foreach($list as $item) { ?>
	<a href="<?php echo $item->image ?>" rel="lightbox-atomium" title="<?php echo $title ?>">
		<img class="sp_simple_gallery" src="<?php echo $item->thumb ?>" alt="<?php echo $item->image ?>" />
	</a>
<?php } ?>