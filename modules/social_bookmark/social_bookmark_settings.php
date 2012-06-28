<?php

// the path to the module. the probably shouldn't be changed unless you rename the social_bookmark folder(s)
define('social_bookmark_path', my_pligg_base . '/modules/social_bookmark/');
// the path to the module. the probably shouldn't be changed unless you rename the module_store folder(s)
if(!defined('lang_loc')){
	// determine if we're in root or another folder like admin
		$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
		$path = substr($_SERVER["SCRIPT_NAME"], 0, $pos);
		if ($path == "/"){$path = "";}
		
		if($path != my_pligg_base){
			define('lang_loc', '..');
		} else {
			define('lang_loc', '.');
		}
}
define('social_bookmark_lang_conf', lang_loc . '/modules/social_bookmark/lang.conf');
define('social_bookmark_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the social_bookmark folder(s)
define('social_bookmark_tpl_path', '../modules/social_bookmark/templates/');
// the path for smarty / template lite plugins
define('social_bookmark_plugins_path', 'modules/social_bookmark/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('social_bookmark_path', social_bookmark_path);
	$main_smarty->assign('social_bookmark_lang_conf', social_bookmark_lang_conf);
	$main_smarty->assign('social_bookmark_tpl_path', social_bookmark_tpl_path);
}

?>
