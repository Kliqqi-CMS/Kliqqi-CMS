<?php

// the path to the module. the probably shouldn't be changed unless you rename the messaging folder(s)
define('simple_messaging_path', my_pligg_base . '/modules/simple_messaging/');

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

define('simple_messaging_lang_conf', lang_loc . '/modules/simple_messaging/lang.conf');
define('simple_messaging_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. this probably shouldn't be changed unless you rename the messaging folder(s)
define('simple_messaging_tpl_path', '../modules/simple_messaging/templates/');
// the path to the images folder. this probably shouldn't be changed unless you rename the messaging folder(s)
define('simple_messaging_img_path', my_pligg_base . '/modules/simple_messaging/images/');

define('URL_simple_messaging_inbox', my_pligg_base.'/module.php?module=simple_messaging&view=inbox');
define('URL_simple_messaging_compose', my_pligg_base.'/module.php?module=simple_messaging&view=compose&to=');
define('URL_simple_messaging_viewmsg', my_pligg_base.'/module.php?module=simple_messaging&view=viewmsg&msg_id=');
define('URL_simple_messaging_viewsentmsg', my_pligg_base.'/module.php?module=simple_messaging&view=viewsentmsg&msg_id=');
define('URL_simple_messaging_delmsg', my_pligg_base.'/module.php?module=simple_messaging&view=delmsg&msg_id=');
define('URL_simple_messaging_reply', my_pligg_base.'/module.php?module=simple_messaging&view=reply&msg_id=');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('simple_messaging_path', simple_messaging_path);
	$main_smarty->assign('simple_messaging_lang_conf', simple_messaging_lang_conf);
	$main_smarty->assign('simple_messaging_pligg_lang_conf', simple_messaging_pligg_lang_conf);
	$main_smarty->assign('simple_messaging_tpl_path', simple_messaging_tpl_path);
	$main_smarty->assign('simple_messaging_img_path', simple_messaging_img_path);
	$main_smarty->assign('URL_simple_messaging_inbox', URL_simple_messaging_inbox);
	$main_smarty->assign('URL_simple_messaging_compose', URL_simple_messaging_compose);
	$main_smarty->assign('URL_simple_messaging_viewmsg', URL_simple_messaging_viewmsg);
	$main_smarty->assign('URL_simple_messaging_viewsentmsg', URL_simple_messaging_viewsentmsg);
	$main_smarty->assign('URL_simple_messaging_delmsg', URL_simple_messaging_delmsg);
	$main_smarty->assign('URL_simple_messaging_reply', URL_simple_messaging_reply);

}

?>
