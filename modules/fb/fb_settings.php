<?php
// the path to the module. the probably shouldn't be changed unless you rename the fb folder(s)
define('fb_path', my_pligg_base . '/modules/fb/');

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
	
// the path to the module. the probably shouldn't be changed unless you rename the fb folder(s)
define('fb_lang_conf', lang_loc .'/modules/fb/lang.conf');
define('fb_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the fb folder(s)
define('fb_tpl_path', '../modules/fb/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('fb_path', fb_path);
	$main_smarty->assign('fb_pligg_lang_conf', fb_pligg_lang_conf);
	$main_smarty->assign('fb_lang_conf', fb_lang_conf);
	$main_smarty->assign('fb_tpl_path', fb_tpl_path);
	$main_smarty->assign('fb_key', get_misc_data('fb_key'));
}

?>
