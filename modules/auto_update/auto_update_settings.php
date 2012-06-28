<?php
// the path to the module. the probably shouldn't be changed unless you rename the auto_update folder(s)
define('auto_update_path', my_pligg_base . '/modules/auto_update/');
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
define('auto_update_lang_conf', lang_loc . '/modules/auto_update/lang.conf');
define('auto_update_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");
// the path to the modules templates. the probably shouldn't be changed unless you rename the auto_update folder(s)
define('auto_update_tpl_path', '../modules/auto_update/templates/');
// the path for smarty / template lite plugins
define('auto_update_plugins_path', 'modules/auto_update/plugins');

// don't touch anything past this line.
if(is_object($main_smarty)){
	$main_smarty->assign('auto_update_path', auto_update_path);
	$main_smarty->assign('auto_update_lang_conf', auto_update_lang_conf);
	$main_smarty->assign('auto_update_pligg_lang_conf', auto_update_pligg_lang_conf);
	$main_smarty->assign('auto_update_tpl_path', auto_update_tpl_path);
}
?>
