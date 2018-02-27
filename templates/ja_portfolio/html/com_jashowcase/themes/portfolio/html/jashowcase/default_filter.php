<?php 
	defined ( '_JEXEC' ) or die ( 'Restricted access' );
	$filter = 1;
	$limit  = $this->limit;
	if($limit>$this->totalAll) $limit = $this->totalAll;	    	
?>
<div class="jasc-header clearfix" id="jasc-filter-wrapper">
	<?php if($this->paramsSetting->get ( 'general_is_show_cat_filter', 0 ) || $this->paramsSetting->get ( 'general_is_show_text_viewing', 0 )):?>
	<ul class="jasc-wrapper-search" id="jasc-wrapper-search">
	
	<?php //BEGIN - search with category	
	if($this->paramsSetting->get ( 'general_is_show_text_viewing', 0 )):?>
	<li id="jasc-container-tag" class="first-item">
		<span><?php echo JText::_("Viewing");?></span>
		<div id="jacs-action-tags">				
			<span><?php if($limit>1){ echo $limit." ".JText::_("items");}else{echo $limit." ".JText::_("item");}?> / <?php if($this->totalAll>1){ echo $this->totalAll." ".JText::_("items");}else{echo $this->totalAll." ".JText::_("item");}?></span>
		</div>					
	</li>
	<?php endif;//END - search with category?>
		
	<?php //BEGIN - search with category	
	if($this->paramsSetting->get ( 'general_is_show_cat_filter', 0 ) && $this->categories):?>
		<li id="jasc-container-cat">
			<?php if($this->paramsSetting->get ( 'general_is_show_text_viewing', 0 )):?>
			<span><?php echo JText::_("from");?></span>
			<?php endif;?>
			<div id="jasc-action-search-cat">			
			<?php echo $this->loadTemplate( 'categories' );?>
			</div>
		</li>					
	<?php endif;//END - search with category?>
	
	<?php //if(JRequest::getVar("subaction", '') == "showfavorites"){?>
		<li id="jasc-faback-container" style="display: none;">
			<a href='#' id='jasc-favorite-back' onclick='jascProcessAjax("backtolisting")' class="favorite-back"><b><?php echo JText::_("Back to listing");?></b></a>
			<input type="hidden" id="jasc-isshow-favorite" value="0"/>
		</li>
	<?php //}?>				
	</ul>
	<?php endif;?>
	
	<?php if($this->paramsSetting->get ( 'general_allow_add_favorites', 0 )):?>
	<ul class="jasc-choose-style">
		<li class="jasc-my-favorite" id="jacs-my-favorite">
			<?php
				if(count($this->jascFavoritesTemplate) >1):
					echo "<a href='#' id='jasc-favorite-link' onclick='jascProcessAjax(\"showfavorites\", \"".count($this->jascFavoritesTemplate)."\");return false;' class=\"favorite-on\"><b>".JText::_("My favorites")."</b> "."(<span>".(count($this->jascFavoritesTemplate))."</span>)"."</a>";
				else:
					echo "<a href='#' id='jasc-favorite-link' onclick='jascProcessAjax(\"showfavorites\", \"".count($this->jascFavoritesTemplate)."\");return false;' class=\"favorite-on\"><b>".JText::_("My favorite")."</b> "."(<span>".(count($this->jascFavoritesTemplate))."</span>)"."</a>";
				endif;
			?>			
		</li>		
	</ul>
	<?php endif;?>
</div>
<?php if($this->paramsSetting->get("general_is_use_float_header", 1)):?>
<script type="text/javascript">
if(!window.ie6){
	var floatheader = null;
	window.addEvent('load', function (){
		floatheader = $('jasc-filter-wrapper');
		var pos = $('jashowcase-main').getPosition();
		var scroll = {'x': window.getScrollLeft(), 'y': window.getScrollTop()};
		var h = pos.y - scroll.y;
		if( h<=0) {
			floatheader.addClass ('floatheader');			
			floatheader.setStyle('width', floatheader.parentNode.offsetWidth-20);			
		}
		else{
			floatheader.removeClass ('floatheader');
			floatheader.setStyle('width', 'auto');
		}			
	});
	window.addEvent('scroll', function (){		
		if (!floatheader) return;				
		var pos = $('jashowcase-main').getPosition();
		var scroll = {'x': window.getScrollLeft(), 'y': window.getScrollTop()};
		var h = pos.y - scroll.y;
		if( h<=0) {
			floatheader.addClass ('floatheader');			
			floatheader.setStyle('width', floatheader.parentNode.offsetWidth-20);			
		}
		else{
			floatheader.removeClass ('floatheader');
			floatheader.setStyle('width', 'auto');
		}		
	});
}
</script>
<?php endif;?>