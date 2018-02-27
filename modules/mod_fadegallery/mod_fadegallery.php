<?php
/**
* Fade Javascript Image Gallery Joomla! 1.6 Native Component
* @version 1.3.5
* @author DesignCompass corp <admin@designcompasscorp.com>
* @link http://www.designcompasscorp.com
* @license GNU/GPL **/

defined('_JEXEC') or die('Restricted access');

require_once(JPATH_SITE.DS.'components'.DS.'com_fadegallery'.DS.'includes'.DS.'fadegalleryclass.php');


$fg=new FadeGalleryClass;

$galleryid=(int)$params->get( 'galleryid' );



if($galleryid!=0)
{
	$galleryrow=$fg->getGallery($galleryid);
	
	$fg_images=$fg->getFileList($galleryrow->folder, $galleryrow->filelist);
	if(count($fg_images)>0)
	{
		if($galleryrow->randomize)
			shuffle($fg_images);
	
		$fg_interval=(int)$galleryrow->interval;
		$fg_fadetime=(int)$galleryrow->fadetime;
		$fg_fadestep=(int)$galleryrow->fadestep;
		
		$width=(int)$galleryrow->width;
		$height=(int)$galleryrow->height;
		
		if($width<1)			$width=400;

		if($height<1)			$height=200;

		if($fg_interval==0)		$fg_interval=6000;
		if($fg_interval<1000)	$fg_interval=1000;
	
		if($fg_fadetime==0)		$fg_fadetime=2000;
		if($fg_fadetime<100)	$fg_fadetime=100;
		
		if($fg_fadestep==0)		$fg_fadestep=20;
		if($fg_fadestep<1)		$fg_fadestep=1;
		
		
		$fgpadding=(int)$galleryrow->padding;
		
	
	
		$objectname='fadegalleryid_'.$count;
	
		echo $fg->getDiv($fg_images,$width, $height,$objectname,$galleryrow->align,$fgpadding,$galleryrow->cssstyle,$galleryrow->thelink);
		
		
	
		echo $fg->getJavaScript($fg_images, $objectname,$fg_interval,$fg_fadetime,$fg_fadestep,$galleryrow->width,$galleryrow->height);
		
		
		//$document = &JFactory::getDocument();
		//$document->addScript( 'media/system/js/fadegallery.js' );
		//JHTML::script('fadegallery.js','media/system/js/');
		JHTML::script('fadegallery.js','media/system/js/fadegallery/');

		
	}//if(count($fg_images)>0)
}
else
{
	$fg_images=$fg->getFileList($params->get( 'folder' ), $params->get( 'filelist' ));

	if($params->get( 'randomize' ))
		shuffle($fg_images);

	$fgalign='';
	$fpadding='';

	$objectname='fdmodule'.$module->id;;

	echo $fg->getDiv($fg_images,$params->get( 'width' ), $params->get( 'height' ),$objectname,$fgalign,$fpadding,$params->get( 'cssstyle' ),$params->get( 'thelink' ));



	if(count($fg_images)>0)
	{
		//$document = &JFactory::getDocument();
		//$document->addScript( 'media/system/js/fadegallery.js' );
		JHTML::script('fadegallery.js','media/system/js/');
	
		$fg_interval=(int)$params->get( 'interval' );
		$fg_fadetime=(int)$params->get( 'fadetime' );
		$fg_fadestep=(int)$params->get( 'fadestep' );
	
		echo $fg->getJavaScript($fg_images, $objectname,$fg_interval,$fg_fadetime,$fg_fadestep,$params->get( 'width' ),$params->get( 'height' ));
	
	}
}

?>