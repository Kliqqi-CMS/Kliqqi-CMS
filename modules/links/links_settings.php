<?php

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

define('links_lang_conf', lang_loc . '/modules/links/lang.conf');
define('links_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the module. the probably shouldn't be changed unless you rename the links folder(s)
define('links_path', my_pligg_base . '/modules/links/');

// the path to the modules templates. the probably shouldn't be changed unless you rename the links folder(s)
define('links_tpl_path', '../modules/links/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('links_path', links_path);
	$main_smarty->assign('links_pligg_lang_conf', links_pligg_lang_conf);
	$main_smarty->assign('links_lang_conf', links_lang_conf);
	$main_smarty->assign('links_tpl_path', links_tpl_path);
}

?>
