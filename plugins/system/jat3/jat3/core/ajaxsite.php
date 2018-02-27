<?php
/*
# ------------------------------------------------------------------------
# JA T3v2 Plugin - Template framework for Joomla 1.5
# ------------------------------------------------------------------------
# Copyright (C) 2004-2010 JoomlArt.com. All Rights Reserved.
# @license - GNU/GPL V2, http://www.gnu.org/licenses/gpl2.html. For details 
# on licensing, Please Read Terms of Use at http://www.joomlart.com/terms_of_use.html.
# Author: JoomlArt.com
# Websites: http://www.joomlart.com - http://www.joomlancers.com.
# ------------------------------------------------------------------------
*/
class T3AjaxSite {
	function gzip () {
		$file = JRequest::getVar ('file');
		$filepath = T3Path::path ($file);
		if (!is_file ($filepath)) return;
		jimport ('joomla.filesystem.file');
		$data = @JFile::read ($filepath);
		if (!$data) return;
		
		$type = JRequest::getCmd ('type', 'css');
		if ($type == 'js') $type = 'javascript';
		JResponse::setHeader( 'Content-Type', "text/$type;", true );
		//set cache time
		JResponse::setHeader( 'Cache-Control', "private", true );
   		$offset = 365 * 24 * 60 * 60; //whenever the content is changed, the file name is changed also. Therefore we could set the cache time long.
   		JResponse::setHeader( 'Expires', gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT", true );
		JResponse::allowCache(true);
		JResponse::setBody ($data);
		echo JResponse::toString(1);
	}
}