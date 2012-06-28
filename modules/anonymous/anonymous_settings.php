<?php

// the path to the module. the probably shouldn't be changed unless you rename the embed_videos folder(s)
define('anonymous_path', my_pligg_base . '/modules/anonymous/');

// the language path for the module
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

define('anonymous_lang_conf', lang_loc . '/modules/anonymous/lang.conf');
define('anonymous_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the embed_videos folder(s)
define('anonymous_tpl_path', '../modules/anonymous/templates/');


define('URL_anonymous', my_pligg_base.'/module.php?module=anonymous');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('anonymous_path', anonymous_path);
	$main_smarty->assign('anonymous_conf', anonymous_lang_conf);
	$main_smarty->assign('anonymous_pligg_lang_conf', anonymous_pligg_lang_conf);
	$main_smarty->assign('anonymous_tpl_path', anonymous_tpl_path);
	$main_smarty->assign('URL_anonymous', URL_anonymous);
}

?>