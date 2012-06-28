<?php

// the path to the module. the probably shouldn't be changed unless you rename the embed_videos folder(s)
define('anonymous_comments_path', my_pligg_base . '/modules/anonymous_comments/');

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

define('anonymous_comments_lang_conf', lang_loc . '/modules/anonymous_comments/lang.conf');
define('anonymous_comments_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the embed_videos folder(s)
define('anonymous_comments_tpl_path', '../modules/anonymous_comments/templates/');
define('URL_anonymous_comments', my_pligg_base.'/module.php?module=anonymous_comments');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('anonymous_comments_path', anonymous_comments_path);
	$main_smarty->assign('anonymous_comments_lang_conf', anonymous_comments_lang_conf);
	$main_smarty->assign('anonymous_comments_pligg_lang_conf', anonymous_comments_pligg_lang_conf);
	$main_smarty->assign('anonymous_comments_tpl_path', anonymous_comments_tpl_path);
	$main_smarty->assign('URL_anonymous_comments', URL_anonymous_comments);
}
?>