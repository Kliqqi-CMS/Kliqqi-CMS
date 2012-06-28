<?php

// the path to the module. the probably shouldn't be changed unless you rename the admin_language folder(s)
define('admin_language_path', my_pligg_base . '/modules/admin_language/');

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
	
define('admin_language_lang_conf', lang_loc . '/modules/admin_language/lang.conf');
define('admin_language_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the admin_language folder(s)
define('admin_language_tpl_path', '../modules/admin_language/templates/');


// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('admin_language_path', admin_language_path);
	$main_smarty->assign('admin_language_lang_conf', admin_language_lang_conf);
	$main_smarty->assign('admin_language_pligg_lang_conf', admin_language_pligg_lang_conf);
	$main_smarty->assign('admin_language_tpl_path', admin_language_tpl_path);
}

?>
