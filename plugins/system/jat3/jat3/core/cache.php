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

/*
T3: Joomla Template Engine

*/
jimport('joomla.cache.cache');
class T3Cache extends JObject {
	var $cache = null;
	var $started = array();
	var $buffer = array();
	var $_options = null;
	function getInstance ($devmode=false) {
		//return null;
		static $instance = null;
		if (!isset ($instance)) {
			if ($devmode) {
				//no cache
				$instance = false;
				return $instance;
			}
			
			$config =& JFactory::getConfig();
			$options = array(
				'cachebase' 	=> JPATH_SITE.DS.'cache',
				'defaultgroup' 	=> 't3',
				'lifetime' 		=> $config->getValue ('cachetime') * 60,
				'handler'		=> $config->getValue ('cache_handler'),
				'caching'		=> false,
				'language'		=> $config->getValue('config.language', 'en-GB'),
				'storage'		=> 'file'
			);
	
			//$cache =& JCache::getInstance('', $options );
			$cache = new JCache ($options);
			$instance = new T3Cache();
			$instance->cache = $cache;
			$instance->_options = $options;
		}
		return $instance;
	}
	
	function store_object ($object, $key) {
		$t3cache = T3Cache::getInstance();
		if (!$t3cache) return false;
		$cache = $t3cache->cache;
		
		$path = $t3cache->_options['cachebase'].DS.$t3cache->_options['defaultgroup'];
		if (!is_dir ($path)) @JFolder::create ($path);
		$path = $path.DS.$key.'.php';
		$data = serialize ($object);
		@file_put_contents($path, $data);
	}
	
	function get_object ($key) {
		$t3cache = T3Cache::getInstance();
		if (!$t3cache) return false;
		$cache = $t3cache->cache;
		
		$object = null;
		$path = $t3cache->_options['cachebase'].DS.$t3cache->_options['defaultgroup'].DS.$key.'.php';
		if (is_file ($path)) {
			$data = @file_get_contents ($path);
			$object = unserialize ($data);
		}
		return $object;
	}
	
	function store_object_ ($object, $key) {
		$t3cache = T3Cache::getInstance();
		if (!$t3cache) return false;
		$cache = $t3cache->cache;
		
		$path = $t3cache->_options['cachebase'].DS.$t3cache->_options['defaultgroup'];
		if (!is_dir ($path)) @JFolder::create ($path);
		$path = $path.DS.$key.'.php';
		$data = var_export ($object, true);
		$data = preg_replace ('/([0-9A-z_]*)::__set_state\(/', 'T3Common::createObject(\'\1\',', $data);
		$die = '<?php defined( "_JEXEC" ) or die( "Restricted access" ); ?>';
		$data = $die. '<?php $object='.$data.'; ?>';
		@file_put_contents($path, $data);
	}
	
	function get_object_ ($key) {
		$t3cache = T3Cache::getInstance();
		if (!$t3cache) return false;
		$cache = $t3cache->cache;
		
		$object = null;
		$path = $t3cache->_options['cachebase'].DS.$t3cache->_options['defaultgroup'].DS.$key.'.php';
		if (is_file ($path)) require ($path);
		if (isset ($object)) return $object;
		return null;
	}
	
	function store ($data, $key, $force=false) {
		if (!$key) return false;
		
		$t3cache = T3Cache::getInstance();
		if (!$t3cache) return false;
		$cache = $t3cache->cache;
		if (!$cache) return false;
		if ($force) {
			$caching = $t3cache->_options['caching'];
			//$cache->_options['caching'] = true;
			$cache->setCaching(true);
			$cache->store ($data, $key);
			//$cache->_options['caching'] = $caching;
			$cache->setCaching($caching);
		} else {
			$cache->store ($data, $key);
		}
	}
	
	function get ($key, $force=false) {
		if (!$key) return false;
		
		$t3cache = T3Cache::getInstance();		
		if (!$t3cache) return false;
		$cache = $t3cache->cache;
		if (!$cache) return null;
		$result = null;
		if ($force) {
			$caching = $t3cache->_options['caching'];
			//$cache->_options['caching'] = true;
			$cache->setCaching(true);
			$result = $cache->get ($key);
			//$cache->_options['caching'] = $caching;
			$cache->setCaching($caching);
		} else {
			$result = $cache->get ($key);
		}
		return $result;
	}
	
	function clean () {
		//clear T3 cache in cache folder		
		$t3cache = T3Cache::getInstance();		
		if (!$t3cache) return false;
		$cache = $t3cache->cache;
		$cache->clean();
		//Clear css/js cached in t3-assets
		$params = T3Common::get_template_based_params();
		$cache_path = $params->get('optimize_folder', 't3-assets');
		$path = T3Path::path ($cache_path);
		if (is_dir ($path)) {
			@JFolder::delete ($path);
		}
	}
	
	function start ($key) {
		$cache = T3Cache::getInstance();
		if (!$cache) return false;
		if (isset($cache->started[$key]) && $cache->started[$key]) return false;
		$cache->started[$key] = true;

		$data = $cache->get ($key);
		if ($data) {
			$cache->started[$key] = false;
			return $data;
		}

		$cache->buffer[$key] = ob_get_clean();
		//$cache->buffer = ob_get_clean();
		ob_start();
		return false;		
	}
	
	function end ($key) {
		$cache = T3Cache::getInstance();
		if (!$cache) return false;
		if (isset($cache->started[$key]) && !$cache->started[$key]) return false;
		$cache->started[$key] = false;
		$data = ob_get_clean();
		ob_start();
		echo $cache->buffer[$key];
		//echo $cache->buffer;
		$cache->store ($data, $key);
		return $data;
	}
	
	function setCaching ($caching) {
		$t3cache = T3Cache::getInstance();		
		if (!$t3cache) return false;
		$cache = $t3cache->cache;	
		$cache->setCaching ($caching);
	}
	
	function getPageKey () {
		static $key = null;
		if ($key) return $key;
		
		$mainframe = &JFactory::getApplication();
		$messages = $mainframe->getMessageQueue();
		// Ignore cache when there're some message
		if (is_array($messages) && count($messages)) {
			$key = null;
			return null;
		}
		
		$user = &JFactory::getUser();
		if ($user->get('aid') || $_SERVER['REQUEST_METHOD'] != 'GET') {
			$key = null;
			return null; //no cache for page
		}
		
		$string = 'page';
		$uri = JRequest::getURI();
		//t3import ('core.libs.Browser');
		//$browser = new Browser();
		//$string .= $browser->getBrowser().":".$browser->getVersion();
		$browser = T3Common::getBrowserSortName()."-".T3Common::getBrowserMajorVersion();
		$params = T3Parameter::getInstance();
		$cparams = '';
		foreach($params->_params_cookie as $k=>$v)
			$cparams .= $k."=".$v.'&';
			
		$string = "page - URI: $uri; Browser: $browser; Params: $cparams";
		$key = md5 ($string);
		//Insert into cache db
		/*
		$query = "insert `#__t3_cache` (`key`, `raw`, `uri`, `browser`, `params`, `counter`) values('$key', '$string', '$uri', '$browser', '$cparams', 1) ON DUPLICATE KEY UPDATE `counter`=`counter`+1;";
		$db =& JFactory::getDBO();
		@$db->setQuery( $query );
		@$db->query();
		*/
		return $key;
	}
	
	function getPreloadKey ($template) {
		return md5 ($template);
	}
	
	function getProfileKey () {
		$profile = T3Common::get_active_profile ();
		return md5 ('profile-'.$profile);
	}
	
	function getThemeKey () {
		$themes = T3Common::get_active_themes();
		$layout = T3Common::get_active_layout();
		$string = 'theme-infos-'.$layout;
		if (is_array($themes)) $string .= print_r($themes, true);
		return md5 ($string);
	}
	
	function store_file ($data, $filename, $overwrite = false) {
		$path = JPATH_SITE.DS.'cache'.DS.'t3';
		if (!is_dir ($path)) @JFolder::create ($path);
		$path = $path.DS.$filename;
		$url = JURI::base(true).'/cache/t3/'.$filename;
		if (is_file ($path) && !$overwrite) return $url;
		@file_put_contents($path, $data);
		return is_file ($path)?$url:false;		
	}
	
	function get_file ($key) {
		$t3cache = T3Cache::getInstance();
		if (!$t3cache) return false;
		$cache = $t3cache->cache;
		
		$data = null;
		$path = $t3cache->_options['cachebase'].DS.$t3cache->_options['defaultgroup'].DS.$key.'.php';
		if (is_file ($path)) {
			$data = @file_get_contents ($path);
		}
		return $data;
	}
	
}