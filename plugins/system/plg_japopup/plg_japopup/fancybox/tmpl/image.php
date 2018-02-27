<a <?php echo $arrData['rel'];?> class="<?php echo $arrData['class']; ?>"  href="<?php echo $arrData['href']; ?>" title="<?php echo $arrData['title'] ?>" ><?php echo $arrData['content'] ?></a>
<script language="javascript" type="text/javascript"> 
/* <![CDATA[ */
jQuery(document).ready(function() {
if( ! jQuery("a.<?php echo $arrData['class']; ?>").fancybox({
		imageScale:<?php echo $arrData['imageScale']?>,
		<?php if($arrData['onopen'] != "") echo "callbackOnShow: ".$arrData['onopen'].","; ?>
		<?php if($arrData['onclose'] != "") echo "callbackOnClose: ".$arrData['onclose'].","; ?>
		centerOnScroll: <?php echo $arrData['centerOnScroll']; ?>}) ) 
	{ document.write(''); }
});
/* ]]> */
</script>