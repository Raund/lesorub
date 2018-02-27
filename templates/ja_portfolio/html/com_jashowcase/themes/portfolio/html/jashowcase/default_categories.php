<?php defined ( '_JEXEC' ) or die ( 'Restricted access' );?>
<?php 
	$txtTitle = '';
	$txtFormSearch='';
	$currentID = ( int ) $this->paramsSetting->get ( 'catid', 0 );
	$currentID 	   = JRequest::getVar( 'catid', $currentID );
	$isShowAnyCat  = $this->paramsSetting->get ( 'general_is_show_cat_filter-1-general_is_any_cat_text', 0 );			
?>
<?php if(count($this->categories)==1):?>
	<a href="<?php echo JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$this->categories[0]->id);?>" id="jasc-current-search" class="jasc-search" title="<?php echo $this->categories[0]->title;?>"><?php echo $this->categories[0]->title;?></a>
	<input type="hidden" name="catid" id="catid" value="<?php echo $currentID;?>"/>	
<?php else:
	$txtFormSearch  = '<ul id="jasc-cat-elements">';
	if($isShowAnyCat)
		$txtFormSearch .= '<li><a href="#" onclick="jascProcessAjax(\'cat\',0)" class="jasc-menu-link" title="'.JText::_("Display all categories.").'">'.JText::_("All Categories").'</a></li>';
		
	for($i=0; $i<count($this->categories); $i++ ) :
		$category = $this->categories[$i];
		if($category->id != $currentID){
			if($txtTitle == ""){
				$txtTitle = '<a href="#" id="jasc-current-search" class="jasc-search" title="'.JText::_("Click here to select a category.").'">'.JText::_("All Categories").'</a>';
			}	
			
			//if($category->level >=3 && ($category->alias == "magento-themes" || $category->alias == "joomla!-templates" || $category->alias == "drupal-themes"))	
			//$txtFormSearch .= '<li><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a></li>';	
			if($i < (count($this->categories) - 1)){			
				//if level of next menu is equal this level 
			  	if($category->level == $this->categories[$i+1]->level){$txtFormSearch .= '<li><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a></li>';}
			  	else if($category->level > $this->categories[$i+1]->level){
			  		$txtFormSearch .= '<li><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a></li>';		  	
			  		for($j = 2 ; $j < $category->level; $j ++){$txtFormSearch .= "</ul>";}						  			
			  	}else{
			  		$txtFormSearch .= '<li><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a><ul>';		  							  		
			  	}		  	
			}else{
			//if this Item is last item in array
				if($this->categories[$i-1]->level <= $this->categories[$i]->level){
		  			$txtFormSearch .= '<li><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a></li>';
		  			for($j = 2 ; $j < $this->categories[$i]->level; $j ++){$txtFormSearch .= "</ul>";}		
		  		}else{$txtFormSearch .= '<li><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a></li>';						  	}	  		
			}	
		}else{
			$txtTitle = '<a href="#" id="jasc-current-search" class="jasc-search" title="'.$category->title.'" onclick="return false;">'.$category->title.'</a>';
			//$txtFormSearch .= '<li class="jacs-cat-active"><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a></li>';
			if($i < (count($this->categories) - 1)){			
				//if level of next menu is equal this level 
			  	if($category->level == $this->categories[$i+1]->level){$txtFormSearch .= '<li class="jacs-cat-active"><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a></li>';}
			  	else if($category->level > $this->categories[$i+1]->level){
			  		$txtFormSearch .= '<li class="jacs-cat-active"><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a></li>';		  	
			  		for($j = 2 ; $j < $category->level; $j ++){$txtFormSearch .= "</ul>";}						  			
			  	}else{
			  		$txtFormSearch .= '<li class="jacs-cat-active"><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a><ul>';		  							  		
			  	}		  	
			}else{
				//if this Item is last item in array
				if($this->categories[$i-1]->level <= $this->categories[$i]->level){
		  			$txtFormSearch .= '<li class="jacs-cat-active"><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a></li>';
		  			for($j = 2 ; $j < $this->categories[$i]->level; $j ++){$txtFormSearch .= "</ul>";}		
		  		}else{$txtFormSearch .= '<li class="jacs-cat-active"><a href="'.JRoute::_("index.php?option=com_jashowcase&view=jashowcaseajax&Itemid=".$this->Itemid."&catid=".$category->id).'" onclick="jascProcessAjax(\'cat\','.$category->id.');return false;" class="jasc-menu-link" title="'.$category->title.'">'.$category->title.'</a></li>';						  	}	  		
			}
		}
		
	endfor;		
	$txtFormSearch .= '</ul>';
	$txtTitle .= '<input type="hidden" name="catid" id="catid" value="'.$currentID.'"/>';			
?>
<?php echo $txtTitle;?>
<div id="jasc-search-cat" style="display: none;">
<?php echo $txtFormSearch;?>
</div>
<?php endif;?>