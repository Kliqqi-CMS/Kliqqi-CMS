<?php
// the path to the module. the probably shouldn't be changed unless you rename the links folder(s)
define('links_path', my_pligg_base . '/modules/links/');

// the path to the module. the probably shouldn't be changed unless you rename the links folder(s)
define('links_lang_conf', '/modules/links/lang.conf');

// the path to the modules templates. the probably shouldn't be changed unless you rename the links folder(s)
define('links_tpl_path', '../modules/links/templates/');

// don't touch anything past this line.

if(isset($main_smarty) && is_object($main_smarty)){
	$main_smarty->assign('links_path', links_path);
	$main_smarty->assign('links_pligg_lang_conf', links_pligg_lang_conf);
	$main_smarty->assign('links_lang_conf', links_lang_conf);
	$main_smarty->assign('links_tpl_path', links_tpl_path);
}

?>
