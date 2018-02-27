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
?>
<div class="ja-showcase module clearfix">	
	<div class="jasc-item-header">
		<div class="jasc-tools-wrap clearfix">
			<h3 class="<?php echo $this->item->params->get('suffix_class');?>"><span><?php echo $this->item->name; ?></span></h3>    	
		</div>
		
		<!-- check for show description -->
		<?php if($this->paramsSetting->get('general_show_description') && $this->item->description!='') :?>
		
	  	<div class="jasc-item-desc"><?php echo htmlentities($this->item->description);?></div>
		<?php endif;?>
	
	</div>
		
	<div class='ja-showcase-thumb'>
		<?php  echo $this->item->imageThumb;?>
	</div>
	<div class="jasc-item-rating clearfix">
		<strong><?php echo JText::_("Rating");?>:</strong>
		<div class="jasc-item-rating-list">
			<div class="jasc-current-rating" style="width: <?php 				
				if( $this->item->rating ) {					
					echo number_format(intval($this->item->rating[1])/intval($this->item->rating[2]), 2)*20;
				} else echo "0"; ?>%;">&nbsp;</div>
		</div>
	</div>
	
	<div class="jasc-item-price clearfix">
		<strong><?php echo JText::_("Price");?>:</strong>
			<span class="jasc-current-price">
				<?php if(isset($this->item->extra_fields["Price"])){
					echo $this->item->extra_fields["Price"]; 	
				}?>				
			</span>
	</div>
	
	<div class="jasc-tools clearfix"> 		
	  	<?php if ($this->paramsSetting->get('general_show_more_info') && $this->item->info_url ) :?>
			<span class="jasc-more-info">
				<a href="<?php echo $this->item->info_url; ?>" title="<?php echo JText::_('MORE INFO');?>" target="_<?php echo $this->paramsSetting->get('general_show_more_info-1-general_open_more');?>" class="more_info">
					<?php echo JText::_('MORE INFO');?>
				</a>
			</span>
		<?php endif;?>
		
		<?php if($this->paramsSetting->get('general_show_live_demo') && $this->item->demo_url) :?>					
			<span class="jasc-demo">
				<a href="<?php echo $this->item->demo_url;?>" title="<?php echo JText::_('LIVE DEMO');?>" target="_<?php echo $this->paramsSetting->get('general_show_live_demo-1-general_open_live');?>" class="live_demo">
					<?php echo JText::_('LIVE DEMO');?>
				</a>
			</span>
	  <?php endif; ?>
	  
	  
	  <?php if($this->paramsSetting->get('general_allow_add_favorites')) :?>	
	  <span id="jasc-action-favorites-<?php echo $this->item->id;?>" class="jasc-action-favorites">
			<?php 
			 $styleAdd    = '';
			 $styleRemove = '';
			 if(isset($this->jascFavoritesTemplate) && in_array($this->item->id, $this->jascFavoritesTemplate)):
				$styleAdd       = 'style="display:none;"';				
			 else:
			    $styleRemove    = 'style="display:none;"';
			 endif;			 	
			?>		
			<a href="javascript:void(0)" <?php echo $styleRemove;?> class="jasc-favorites-active" onclick="saveToFavorites('remove',<?php echo $this->item->id;?>);return false;" title="<?php echo JText::_("Remove from my favorites");?>"><?php echo JText::_("Remove from my favorites");?></a>
			<a href="javascript:void(0)" <?php echo $styleAdd;?> class="jasc-favorites-unactive" onclick="saveToFavorites('save',<?php echo $this->item->id;?>);return false;" title="<?php echo JText::_("Add to favorites");?>"><?php echo JText::_("Add to favorites");?></a>			
  		</span> 
  		<?php endif;?>  		  	
    </div>	
</div>