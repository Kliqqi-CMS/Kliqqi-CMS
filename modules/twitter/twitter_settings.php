<?php
// the path to the module. the probably shouldn't be changed unless you rename the twitter folder(s)
define('twitter_path', my_pligg_base . '/modules/twitter/');

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
	
// the path to the module. the probably shouldn't be changed unless you rename the twitter folder(s)
define('twitter_lang_conf', lang_loc .'/modules/twitter/lang.conf');
define('twitter_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the twitter folder(s)
define('twitter_tpl_path', '../modules/twitter/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('twitter_path', twitter_path);
	$main_smarty->assign('twitter_pligg_lang_conf', twitter_pligg_lang_conf);
	$main_smarty->assign('twitter_lang_conf', twitter_lang_conf);
	$main_smarty->assign('twitter_tpl_path', twitter_tpl_path);
	$main_smarty->assign('twitter_key', get_misc_data('twitter_key'));
}

?>
