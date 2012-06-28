<?php

// the path to the module. the probably shouldn't be changed unless you rename the users_extra_fields folder(s)
define('users_extra_fields_path', my_pligg_base . '/modules/users_extra_fields/');
// the path to the module. the probably shouldn't be changed unless you rename the users_extra_fields folder(s)
define('users_extra_fields_lang_conf', '/modules/users_extra_fields/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the users_extra_fields folder(s)
define('users_extra_fields_tpl_path', '../modules/users_extra_fields/templates/');


// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('users_extra_fields_path', users_extra_fields_path);
	$main_smarty->assign('users_extra_fields_lang_conf', users_extra_fields_lang_conf);
	$main_smarty->assign('users_extra_fields_tpl_path', users_extra_fields_tpl_path);
}

?>