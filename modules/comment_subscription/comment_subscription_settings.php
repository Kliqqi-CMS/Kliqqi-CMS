<?php
// the path to the module. the probably shouldn't be changed unless you rename the comment_subscription folder(s)
define('comment_subscription_path', my_pligg_base . '/modules/comment_subscription/');

// the path to the module. the probably shouldn't be changed unless you rename the comment_subscription folder(s)
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

define('comment_subscription_lang_conf', '/modules/comment_subscription/lang.conf');
define('comment_subscription_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the comment_subscription folder(s)
define('comment_subscription_tpl_path', '../modules/comment_subscription/templates/');

// don't touch anything past this line.
if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('comment_subscription_path', comment_subscription_path);
	$main_smarty->assign('comment_subscription_pligg_lang_conf', comment_subscription_pligg_lang_conf);
	$main_smarty->assign('comment_subscription_lang_conf', comment_subscription_lang_conf);
	$main_smarty->assign('comment_subscription_places', $comment_subscription_places);
	$main_smarty->assign('comment_subscription_tpl_path', comment_subscription_tpl_path);
}

?>
