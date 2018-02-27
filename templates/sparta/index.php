<?php
defined('_JEXEC') or die;

JHTML::_('behavior.framework', true);

$app = JFactory::getApplication();
?>

<?php echo '<?'; ?>xml version="1.0" encoding="<?php echo $this->_charset ?>"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
	<head>
		<jdoc:include type="head" />
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/style.css" media="all" />
		<meta name='yandex-verification' content='7076d1e69e36bffd' />
	</head>
	<body>
	<div id="warp">
		<div id="left-side">
			<img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/img/logo.jpg" alt="Компания Спарта" class="logo" />
			<div class="nav">
				<a href="http://lesorub.kiev.ua/"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/img/home.jpg" alt="" /></a>
				<a href="mailto:sueta2008@ukr.net"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/img/mail.jpg" alt="" /></a>
			
			</div>
			<jdoc:include type="modules" name="menu" style="none" />
			
			<div class="contact">
			<jdoc:include type="modules" name="contact" style="none" />
			<br />
			
		
		
		</div>
			
		   
		   
		    </div>
			
		  <!-- <div id="slogan">Индивидуальный подход к каждому человеку,<br />учитываем пожелание и рекомендации.
		          <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                 <div class="yashare-auto-init" data-yashareType="link" data-yashareL10n="ru" data-yashareQuickServices="vkontakte,facebook,odnoklassniki,lj"></div>  
         
		   </div> -->
		   
		 <div id="content">
		
			<jdoc:include type="message" />
			<jdoc:include type="component" />
			<jdoc:include type="modules" name="gallery" style="none" />
		 </div>
		    <div id="right">
			<h4>Новые услуги:</h3>
			<jdoc:include type="modules" name="rightmenu" style="none" /></div>
		  
		  <div>
		       <nofollow> <div class="logines"><a href="http://lesorub.kiev.ua/index.php?option=com_users&view=login">Управление</a></nofollow>
		        </div>
		     <!-- <div class="rec">
			     
                 <a href="http://freemarket.kiev.ua/" target=_blank onClick="img = new Image();img.src='http://freemarket.kiev.ua/?in=84413';" ><img src="http://top.freemarket.kiev.ua/button.php?id=84413" border="0" alt="Цены на компьютеры. Объявления Украины и России." width=88 height=31 /></a>

<script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?2436315"></script>
<noscript>
<a href="http://top100.rambler.ru/navi/2436315/">
<img src="http://counter.rambler.ru/top100.cnt?2436315" alt="Rambler's Top100" border="0" />
</a>

</noscript>
				</div> -->
				 
				
		   </div>
		   
		    
	</div>
	<!-- Yandex.Metrika counter -->
<div style="display:none;"><script type="text/javascript">
(function(w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter5020144 = new Ya.Metrika(5020144);
             yaCounter5020144.clickmap(true);
             yaCounter5020144.trackLinks(true);
        
        } catch(e) { }
    });
})(window, 'yandex_metrika_callbacks');
</script></div>
<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
<noscript><div><img src="//mc.yandex.ru/watch/5020144" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-114825226-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-114825226-1');
</script>

	</body>
</html>	