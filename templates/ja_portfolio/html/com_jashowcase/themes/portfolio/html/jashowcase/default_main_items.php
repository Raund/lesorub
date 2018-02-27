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
  defined ( '_JEXEC' ) or die ( 'Restricted access' );
  
  $cols = $this->cols;
  $div_width= round ( 100/$cols, 1 );
  $end = $this->paramsSetting->get('general_show_description-1-max_chars', '256'); 
?>
<?php	
	if( !isset($this->categories) && empty($this->categories) ){		 
		$showMessage = true;		
	}
?>

  <?php if( count($this->themes) ) : ?>
  <?php  
      $i = 1;
      foreach ($this->themes as $item) :
	    $item->description = JascHelper::trimString( $item->description, 0, $end  );
        if ($i == 1) echo "<div class=\"ja-showcase-row clearfix\">";
        if ($cols == 1) $class = 'full';
        else if ($i == 1) $class = 'left';
        else if ($i < $cols) $class = 'center';
        else $class = 'right';
		$this->assign("item", $item);
        echo "<div id=\"ja_showcase_item_".$item->id."\" class=\"ja-showcase-$class\" style=\"width: {$div_width}%\">";        
        	echo $this->loadTemplate('item');                        
        echo "</div>";
        if ($i == $cols) echo "</div>";
        $i = ($i < $cols)?$i+1:1;
      endforeach; 
      if ($i>1) echo "</div>";
   ?>
   <?php elseif( isset($showMessage) && $showMessage ): ?>
  	<div class="ja-showcase-inner"><h3><?php echo JText::_('NO RESULT FOR THIS CATEGORY'); ?></h3></div>
   <?php endif ;    $itemid = JRequest::getVar('Itemid', 0);?>