<?php
// the path to the module. the probably shouldn't be changed unless you rename the dropbox_backup folder(s)
define('dropbox_backup_path', my_pligg_base . '/modules/dropbox_backup/');

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
	
define('dropbox_backup_lang_conf', lang_loc . '/modules/dropbox_backup/lang.conf');
define('dropbox_backup_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

define('dropbox_backup_tpl_path', '../modules/dropbox_backup/templates/');

// don't touch anything past this line.
if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('dropbox_backup_path', dropbox_backup_path);
	$main_smarty->assign('dropbox_backup_pligg_lang_conf', dropbox_backup_pligg_lang_conf);
	$main_smarty->assign('dropbox_backup_lang_conf', dropbox_backup_lang_conf);
	$main_smarty->assign('dropbox_backup_tpl_path', dropbox_backup_tpl_path);
}

?>
