<?php
// the path to the module. the probably shouldn't be changed unless you rename the redc folder(s)
define('redc_path', my_pligg_base . '/modules/redc/');

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
	
define('redc_lang_conf', lang_loc . '/modules/redc/lang.conf');
define('redc_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

define('redc_tpl_path', '../modules/redc/templates/');

// don't touch anything past this line.
if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('redc_path', redc_path);
	$main_smarty->assign('redc_pligg_lang_conf', redc_pligg_lang_conf);
	$main_smarty->assign('redc_lang_conf', redc_lang_conf);
	$main_smarty->assign('redc_tpl_path', redc_tpl_path);
	$main_smarty->assign('redc_places', $redc_places);
}

?>
