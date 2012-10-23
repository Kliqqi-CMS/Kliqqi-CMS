<?php
// the path to the module. the probably shouldn't be changed unless you rename the tweet folder(s)
define('tweet_path', my_pligg_base . '/modules/tweet/');

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
	
define('tweet_lang_conf', lang_loc . '/modules/tweet/lang.conf');
define('tweet_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

define('tweet_tpl_path', '../modules/tweet/templates/');

// don't touch anything past this line.
if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('tweet_path', tweet_path);
	$main_smarty->assign('tweet_pligg_lang_conf', tweet_pligg_lang_conf);
	$main_smarty->assign('tweet_lang_conf', tweet_lang_conf);
	$main_smarty->assign('tweet_tpl_path', tweet_tpl_path);
	$main_smarty->assign('tweet_places', $tweet_places);
}

?>
