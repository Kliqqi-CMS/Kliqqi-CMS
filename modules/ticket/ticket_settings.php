<?php
// the path to the module. the probably shouldn't be changed unless you rename the ticket folder(s)
define('ticket_path', my_pligg_base . '/modules/ticket/');
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
define('ticket_lang_conf', lang_loc . '/modules/ticket/lang.conf');
define('ticket_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// the path to the modules templates. the probably shouldn't be changed unless you rename the ticket folder(s)
define('ticket_tpl_path', '../modules/ticket/templates/');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('ticket_path', ticket_path);
	$main_smarty->assign('ticket_lang_conf', ticket_lang_conf);
	$main_smarty->assign('ticket_tpl_path', ticket_tpl_path);
	$main_smarty->assign('ticket_pligg_lang_conf', ticket_pligg_lang_conf);
}
?>
