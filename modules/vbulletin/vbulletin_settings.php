<?php
// the path to the module. the probably shouldn't be changed unless you rename the vbulletin folder(s)
define('vbulletin_path', my_pligg_base . '/modules/vbulletin/');

// the path to the module. the probably shouldn't be changed unless you rename the vbulletin folder(s)
define('vbulletin_lang_conf', '/modules/vbulletin/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the vbulletin folder(s)
define('vbulletin_tpl_path', '../modules/vbulletin/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('vbulletin_path', vbulletin_path);
	$main_smarty->assign('vbulletin_pligg_lang_conf', vbulletin_pligg_lang_conf);
	$main_smarty->assign('vbulletin_lang_conf', vbulletin_lang_conf);
	$main_smarty->assign('vbulletin_tpl_path', vbulletin_tpl_path);
}

?>
