<?php

// the path to the module. the probably shouldn't be changed unless you rename the share_revenue folder(s)
define('rss_import_path', my_pligg_base . '/modules/rss_import/');

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
define('rss_import_lang_conf', lang_loc . '/modules/rss_import/lang.conf'); 
define('rss_import_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf"); 

// the path to the modules templates. the probably shouldn't be changed unless you rename the rss_import folder(s)
define('rss_import_tpl_path', '../modules/rss_import/templates/');
define('rss_import_tpl_path_2', 'modules/rss_import/templates/');
// the path for smarty / template lite plugins
define('rss_import_plugins_path', '../modules/rss_import/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('rss_import_path', rss_import_path);
	$main_smarty->assign('rss_import_lang_conf', rss_import_lang_conf);
	$main_smarty->assign('rss_import_pligg_lang_conf', rss_import_pligg_lang_conf);
	$main_smarty->assign('rss_import_tpl_path', rss_import_tpl_path);
	$main_smarty->assign('rss_import_tpl_path_2', rss_import_tpl_path_2);	
}

?>
