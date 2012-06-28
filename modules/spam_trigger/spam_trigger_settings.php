<?php
// the path to the module. the probably shouldn't be changed unless you rename the spam_trigger folder(s)
define('spam_trigger_path', my_pligg_base . '/modules/spam_trigger/');

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
	
define('spam_trigger_lang_conf', lang_loc . '/modules/spam_trigger/lang.conf');
define('spam_trigger_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the spam_trigger folder(s)
define('spam_trigger_tpl_path', '../modules/spam_trigger/templates/');

// don't touch anything past this line.
if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('spam_trigger_path', spam_trigger_path);
	$main_smarty->assign('spam_trigger_pligg_lang_conf', spam_trigger_pligg_lang_conf);
	$main_smarty->assign('spam_trigger_lang_conf', spam_trigger_lang_conf);
	$main_smarty->assign('spam_trigger_tpl_path', spam_trigger_tpl_path);
}

?>
