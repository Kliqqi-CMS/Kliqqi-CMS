<?php

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
define('send_announcement_lang_conf', lang_loc .'/modules/send_announcement/lang.conf');
define('send_announcement_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('send_announcement_path', my_pligg_base . '/modules/send_announcement/');

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('send_announcement_lang_conf', '/modules/send_announcement/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('send_announcement_tpl_path', '../modules/send_announcement/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	//$main_smarty->assign('send_announcement_path', send_announcement_path);
	//$main_smarty->assign('send_announcement_lang_conf', send_announcement_lang_conf);
	//$main_smarty->assign('send_announcement_tpl_path', send_announcement_tpl_path);
}

?>