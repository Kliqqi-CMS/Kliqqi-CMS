<?php

// the path to the module. the probably shouldn't be changed unless you rename the admin_help_english folder(s)
define('admin_help_english_path', my_pligg_base . '/modules/admin_help_english/');

// the path to the modules templates. the probably shouldn't be changed unless you rename the admin_help_english folder(s)
define('admin_help_english_tpl_path', '../modules/admin_help_english/templates/');

// the path where the localized docs are found
define('admin_help_english_doc_path', '../modules/admin_help_english/docs/');

define('URL_admin_help_english', 'module.php?module=admin_help_english');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('admin_help_english_path', admin_help_english_path);
	$main_smarty->assign('admin_help_english_lang_conf', admin_help_english_lang_conf);
	$main_smarty->assign('admin_help_english_tpl_path', admin_help_english_tpl_path);
	$main_smarty->assign('admin_help_english_doc_path', admin_help_english_doc_path);
	$main_smarty->assign('URL_admin_help_english', URL_admin_help_english);	
}

?>