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

// no direct access
defined('_JEXEC') or die('Restricted access');
/**
 *  Module Content Silder
 * 
 * @package		Joomla.
 * @subpackage	Modules.
 * @author (@see http://joomlart.com).
 */

if( $total ){ 
	global $mainframe;
	$tmplPath   = 'templates'.DS.$mainframe->getTemplate().DS;
	$tmplimages = $tmplPath.'images'.DS;
	$modPath    = 'modules/mod_jacontentslider2/assets/images/';
	//Images
	$image_path = $modPath;
	if ( file_exists (JPATH_SITE.DS.$tmplimages.'re-left.gif') ) {
		$image_path = $tmplimages;
	}
	$image_path = str_replace( '\\', '/', $image_path );
			
?>
<?php
	$cateArr = array();
	foreach ($contents as $contn) {
		if (isset($contn->cateName) && !isset($cateArr[$contn->catid])) {
			$cateArr[$contn->catid] = $contn->cateName;
		}
	}
	if ($showAll == 0) {
		$firstCid = array_keys($cateArr);
		$firstCid = $firstCid[0];
	}
	else {
		$firstCid = 0;
	}
?>
<script type="text/javascript">
	//<!--[CDATA[
	function contentSliderInit (cid) {
		cid = parseInt(cid);
		var containerID = 'ja-contentslider-<?php echo $module->id;?>';
		var container =  $(containerID);
		
		$$('.jsslide').each(function(el){
			el.remove();
		});
		if(cid == 0) {
			var elems = container.getElement(".ja-contentslider-center").getElements('div[class*=content_element]');
		}else{
			var elems = container.getElement(".ja-contentslider-center").getElements('div[class*=jaslide2_'+cid+']');
		}
		var total = elems.length;

		var options={
			w: <?php echo $xwidth; ?>,
			h: <?php echo $xheight; ?>,
			num_elem: <?php echo  $numElem; ?>,
			mode: '<?php  echo  $mode; ?>', //horizontal or vertical
			direction: '<?php echo $direction; ?>', //horizontal: left or right; vertical: up or down
			total: total,
			url: '<?php echo JURI::base(); ?>modules/mod_jacontentslider2/mod_jacontentslider2.php',
			wrapper:  container.getElement("div.ja-contentslider-center"),
			duration: <?php echo $animationtime; ?>,
			interval: <?php echo $delaytime; ?>,
			modid: <?php echo $module->id;?>,
			running: false,
			auto: <?php echo $auto;?>
		};		
		
		var jscontentslider = new JS_ContentSlider2( options );
		
		for(i=0;i<elems.length;i++){
			jscontentslider.update (elems[i].innerHTML, i);
		}
		jscontentslider.setPos(null);
		if(jscontentslider.options.auto){
			jscontentslider.nextRun();
		}
		
		<?php if( $params->get( 'showbutton' ) || ($params->get( 'showbutton' ) == '') ): ?>
		  <?php if($params->get( 'scroll_when', 'click' ) == 'click'): ?>
			<?php if ($mode == 'vertical'): ?>
			container.getElement(".ja-contentslide-up-img").onclick = function(){setDirection2('down', jscontentslider);};
			container.getElement(".ja-contentslide-down-img").onclick = function(){setDirection2('up', jscontentslider);};
			<?php else: ?>
			container.getElement(".ja-contentslide-left-img").onclick = function(){setDirection2('right', jscontentslider);};
			container.getElement(".ja-contentslide-right-img").onclick = function(){setDirection2('left', jscontentslider);};
			<?php endif; //vertical? ?>
		  <?php else: ?>
			<?php if ($mode == 'vertical'): ?>
			container.getElement(".ja-contentslide-up-img").onmouseover = function(){setDirection('down',0, jscontentslider);};
			container.getElement(".ja-contentslide-up-img").onmouseout = function(){setDirection('down',1, jscontentslider);};
			container.getElement(".ja-contentslide-down-img").onmouseover = function(){setDirection('up',0, jscontentslider);};
			container.getElement(".ja-contentslide-down-img").onmouseout = function(){setDirection('up',1, jscontentslider);};
			<?php else: ?>
			container.getElement(".ja-contentslide-left-img").onmouseover = function(){setDirection('right',0, jscontentslider);};
			container.getElement(".ja-contentslide-left-img").onmouseout = function(){setDirection('right',1, jscontentslider);};
			container.getElement(".ja-contentslide-right-img").onmouseover = function(){setDirection('left',0, jscontentslider);};
			container.getElement(".ja-contentslide-right-img").onmouseout = function(){setDirection('left',1, jscontentslider);};
			<?php endif; //vertical? ?>
		  <?php endif; //scroll event ?>
		<?php endif; //show control? ?>

		// add tooltips
		if(!$('ja-contentslider-tips-<?php echo $module->id;?>')) {
			var divobj = new Element('DIV', {
									 'id':'ja-contentslider-tips-<?php echo $module->id;?>', 
									 'class': 'tooltips',
									 'styles': {
										'position': 'absolute',
										'display': 'none'
									}});
			divobj.inject(document.body);
		}
		
		
		/**active tab**/
		container.getElement('.ja-button-control').getElements('a').each(function(el){
			var css = (el.getProperty('rel') == cid) ? 'active' : '';
			el.className = css;
		});
	}
	window.addEvent( 'domready', function(){ contentSliderInit(<?php echo $firstCid; ?>); } );
	function setDirection(direction,ret, jscontentslider) {
		jscontentslider.options.direction = direction;
		if(ret){
			jscontentslider.options.interval = <?php echo $delaytime; ?>;
			jscontentslider.options.duration = <?php echo $animationtime; ?>;
			jscontentslider.options.auto = <?php echo $auto; ?>;
			jscontentslider.nextRun();
		}
		else{
			jscontentslider.options.interval = 500;
			jscontentslider.options.duration = 500;
			jscontentslider.options.auto = 1;
			jscontentslider.nextRun();
		}
	}
	function setDirection2(direction, jscontentslider) {
		jscontentslider.options.direction = direction;
		jscontentslider.options.interval = 500;
		jscontentslider.options.duration = 200;
		jscontentslider.options.auto = 1;
		jscontentslider.nextRun();
		jscontentslider.options.auto = 0;
	}
	//]]-->
</script>

<div id="ja-contentslider-<?php echo $module->id;?>"  class="ja-contentslider clearfix" >
  <!--toolbar-->
  <div class="ja-button-control">
    <?php if ($showAll == 1) { ?>
    <a href="javascript:contentSliderInit(0)" rel="0"><?php echo JText::_('All'); ?></a>
    <?php } ?>
    <?php foreach ($cateArr as $key=>$value) {?>
    <?php if(!empty($value)): ?>
    <a href="javascript:contentSliderInit('<?php echo $key;?>')" rel="<?php echo $key;?>"><?php echo $value; ?></a>
    <?php endif; ?>
    <?php } ?>
    <?php if( $params->get( 'showbutton' ) || ($params->get( 'showbutton' ) == '') ) { ?>
    <div class="ja-contentslider-right ja-contentslide-right-img" title="<?php echo JText::_('Next'); ?>">&nbsp;</div>
    <?php } ?>
    <?php if( $params->get( 'showbutton' ) || ($params->get( 'showbutton' ) == '') ) { ?>
    <div class="ja-contentslider-left ja-contentslide-left-img" title="<?php echo JText::_('Previous'); ?>">&nbsp;</div>
    <?php } ?>
    <?php
			} else { ?>
    <div id="ja-contentslide-error"><?php echo JText::_('JA Content Slide Error: There is not any content in this category')?></div>
    <?php } ?>
  </div>
  
  <!--items-->
  <div class="ja-contentslider-center-wrap clearfix">
    <div class="ja-contentslider-center">
      <?php 
	foreach( $contents  as $contn ) { 
		$link = $contn->link;
		$image = modJacontentslider2Helper::replaceImage( $contn, $params->get( 'numchar' ),
													$params->get( 'showimages' ), 
													$params->get( 'iwidth' ), 
													$params->get( 'iheight' ) );
		
	?>
      <div class="content_element jaslide2_<?php echo $contn->catid; ?>" style="display:none;">
        <?php if( $params->get( 'showtitle' ) ) { ?>
        <div class="ja_slidetitle">
          <?php  echo ($params->get( 'link_titles' ) ) ? '<a href="'.$link.'" title="">'.$contn->title.'</a>' : $contn->title;?>
        </div>
        <?php } ?>
        <?php /* if ($contn->featured == 1) { ?>
	  <span class="featured">&nbsp;</span>
	  <?php } */?>
        <?php if(  $params->get( 'showimages' ) ) { ?>
        <div class="ja_slideimages tooltips clearfix">
          <div class="ja_slideimages_inner">
            <div class="content">
              <?php echo $image; ?>
            </div>
          </div>
        </div>
        <?php } ?>
        <?php if(  $params->get( 'showintrotext' ) ) { ?>
        <div class="ja_slideintro"> <?php echo ( $params->get('numchar') ) ? $contn->introtext1 : $contn->introtext; ?> </div>
        <?php } ?>
        <?php if( $params->get('showreadmore') ){ ?>
        <div class="ja-slidereadmore"> <a href="<?php echo $link;?>" class="readon"><?php echo JTEXT::_('READMORE');?></a> </div>
        <?php } // endif;?>
        <?php if (isset($contn->demoUrl) && $contn->demoUrl != '') { ?>
        <div class="ja-slideDemo"> <a href="<?php echo $contn->demoUrl;?>" class="readon"><?php echo $contn->demoUrl;?></a> </div>
        <?php } ?>
        <?php if($params->get( 'source' ) == 'k2'):?>
        <div class="ja-contentslider-tips" style="display:none;">
          <div class="ja-cs-tooltips">
            <h3>
              <?php $tmp = explode("-",$contn->title); echo trim($tmp[0]); ?>
            </h3>
            <div class="ja-tooltips-ct">
              <ul>
                <li><strong><?php echo JText::_('Category'); ?>: </strong><?php echo $contn->cateName; ?></li>
                <li><strong><?php echo JText::_('Release'); ?>: </strong><?php echo $contn->release; ?></li>
                <li><strong><?php echo JText::_('Download'); ?>: </strong><?php echo $contn->totaldownloads; ?></li>
                <?php $rating = $contn->rating; ?>
                <li class="ja-rating-wrap clearfix"><strong><?php echo JText::_('Rating'); ?>: </strong>
                  <div class="ja-item-rating">
                    <div style="width: <?php
                        if( $rating ) {
                            echo number_format(intval($rating[1])/intval($rating[2]), 2)*20;
                        } else echo "0"; ?>%;" class="ja-current-rating"></div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <?php } //endforeach; ?>
    </div>
  </div>
</div>
