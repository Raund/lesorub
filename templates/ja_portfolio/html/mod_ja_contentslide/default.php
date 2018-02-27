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
	$modPath    = 'modules/mod_ja_contentslide/assets/images/';
	//Images
	$image_path = $modPath;
	if ( file_exists (JPATH_SITE.DS.$tmplimages.'re-left.png') ) {
		$image_path = $tmplimages;
	}
	$image_path = str_replace( '\\', '/', $image_path );
			
?>
	 <script type="text/javascript">
		//<!--[CDATA[
		function contentSliderInit () {
			var container =  $('ja-contentslider-<?php echo $module->id;?>'); 		
			var options={
				w: <?php echo $params->get( 'xwidth' ); ?>,
				h: <?php echo $params->get( 'xheight' ); ?>,
				num_elem: <?php echo  $params->get( 'numElem' ); ?>,
				mode: '<?php  echo  $mode; ?>', //horizontal or vertical
				direction: '<?php echo $params->get( 'direction' ); ?>', //horizontal: left or right; vertical: up or down
				total: <?php echo $total; ?>,
				url: '<?php echo JURI::base(); ?>modules/mod_ja_contentslide/mod_ja_contentslide.php',
				wrapper:  container.getElement("div.ja-contentslider-center"),
				duration: <?php echo $params->get( 'animationtime' ); ?>,
				interval: <?php echo $params->get( 'delaytime' ); ?>,
				modid: <?php echo $module->id;?>,
				running: false,
				auto: <?php echo $params->get( 'auto' );?>
			};		
			
			var jscontentslider = new JS_ContentSlider( options ); 
			
			var elems = container.getElement(".ja-contentslider-center").getElementsByClassName ('content_element');
			for(i=0;i<elems.length;i++){ 
				jscontentslider.update (elems[i].innerHTML, i);
			}
			jscontentslider.setPos(null);
			if(jscontentslider.options.auto){
				jscontentslider.nextRun();
			}
			<?php
			if( $params->get( 'showbutton' ) || ($params->get( 'showbutton' ) == '') ) {
			if ($mode == 'vertical') {
			?>
			container.getElement(".ja-contentslide-up-img").onmouseover = function(){setDirection('down',0, jscontentslider);};
			container.getElement(".ja-contentslide-up-img").onmouseout = function(){setDirection('down',1, jscontentslider);};
			container.getElement(".ja-contentslide-down-img").onmouseover = function(){setDirection('up',0, jscontentslider);};
			container.getElement(".ja-contentslide-down-img").onmouseout = function(){setDirection('up',1, jscontentslider);};
		<?php
		} else {
		?>
			container.getElement(".ja-contentslide-left-img").onmouseover = function(){setDirection('right',0, jscontentslider);};
			container.getElement(".ja-contentslide-left-img").onmouseout = function(){setDirection('right',1, jscontentslider);};
			container.getElement(".ja-contentslide-right-img").onmouseover = function(){setDirection('left',0, jscontentslider);};
			container.getElement(".ja-contentslide-right-img").onmouseout = function(){setDirection('left',1, jscontentslider);};
			<?php
			} }
			?>
	
		}
		
		window.addEvent( 'load', contentSliderInit );
		
		// window.addEvent( 'load', contentSliderInit);
	
		function setDirection(direction,ret, jscontentslider){
			jscontentslider.options.direction = direction;
			if(ret){
			//	$('ja-contentslide-'+direction+'-img').src = '<?php echo JURI::base().$image_path; ?>re-'+direction+'.gif';
				jscontentslider.options.interval = <?php echo $delaytime; ?>;
				jscontentslider.options.duration = <?php echo $animationtime; ?>;
				jscontentslider.options.auto = <?php echo $auto; ?>;
				jscontentslider.nextRun();
			}
			else{
		///		$('ja-contentslide-'+direction+'-img').src = '<?php echo JURI::base().$image_path; ?>re-'+direction+'-hover.gif';
				jscontentslider.options.interval = 500;
				jscontentslider.options.duration = 500;
				jscontentslider.options.auto = 1;
				jscontentslider.nextRun();
			}
		}
		//]]-->
				//	alert(.innerHTML ) ;
	 </script>
	
		<div id="ja-contentslider-<?php echo $module->id;?>"  class="ja-contentslider clearfix" >
			<?php if( $params->get( 'showbutton' ) || ($params->get( 'showbutton' ) == '') ) { ?>
			<div class="ja-contentslider-left"><img class="ja-contentslide-<?php if($mode=='vertical') { echo 'up';} else { echo 'left';} ?>-img" src="<?php echo JURI::base().$image_path; ?>re-<?php if($mode=='vertical') { echo 'up';} else { echo 'left';} ?>.png" alt="<?php if($mode=='vertical') { echo 'up';} else { echo 'left';} ?> direction" title="<?php if($mode=='vertical') { echo 'up';} else { echo 'left';} ?> direction" /></div>
			<?php } ?>

			<div class="ja-contentslider-center-wrap clearfix">
         		 <div class="ja-contentslider-center">
				 	<?php foreach( $contents  as $contn ) { ?>
						<?php
									
							$link = modJaContentslideHelper::articleLink( $contn );
												 
							$image = modJaContentslideHelper::replaceImage( $contn, $params->get( 'numchar' ),
																		$params->get( 'showimages' ), 
																		$params->get( 'iwidth' ), 
																		$params->get( 'iheight' ) );									 
							
						?>
						<div class="content_element" style="display:none;">
						
								<?php if(  $params->get( 'showimages' ) ) { ?>
									<div class="ja_slideimages clearfix">
										<?php echo '<a href="'.$link.'" title="">'.$image.'</a>'; ?>
									</div>
								<?php } ?>
								
							<?php if( $params->get( 'showtitle' ) ) { ?>
									<div class="ja_slidetitle">
										<?php  echo ($params->get( 'link_titles' ) ) ? '<a href="'.$link.'" title="">'.$contn->title.'</a>' : $contn->title;?>
									</div>
							<?php } ?>

								<?php if(  $params->get( 'showintrotext' ) ) { ?>
									<div class="ja_slideintro">
										<?php echo ( $params->get('numchar') ) ? $contn->introtext1 : $contn->introtext; ?>
									</div>
								<?php } ?>
								
								<?php if( $params->get('showreadmore') ){ ?>
									<div class="ja-slidereadmore">
										<a href="<?php echo $link;?>'" class="readon"><?php echo JTEXT::_('READMORE');?></a>
									</div>
								<?php } // endif;?>
							</div>
						<?php } //endforeach; ?>
					</div>
				</div>
				
		<?php if( $params->get( 'showbutton' ) || ($params->get( 'showbutton' ) == '') ) { ?>
		<div class="ja-contentslider-right"><img class="ja-contentslide-<?php if($mode=='vertical') { echo 'down';} else { echo 'right';} ?>-img" src="<?php echo JURI::base().$image_path; ?>re-<?php if($mode=='vertical') { echo 'down';} else { echo 'right';} ?>.png" alt="<?php if($mode=='vertical') { echo 'down';} else { echo 'right';} ?> direction" title="<?php if($mode=='vertical') { echo 'down';} else { echo 'right';} ?> direction" /></div>
			<?php } ?>
		<?php
	} else { ?>
		<div id="ja-contentslide-error"><?php echo JText::_('JA Content Slide Error: There is not any content in this category')?></div>
    <?php } ?>
</div>	