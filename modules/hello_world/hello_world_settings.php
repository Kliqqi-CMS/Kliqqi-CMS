<?php

// the path to the module. the probably shouldn't be changed unless you rename the hello_world folder(s)
define('hello_world_path', my_pligg_base . '/modules/hello_world/');

// the path to the modules templates. the probably shouldn't be changed unless you rename the hello_world folder(s)
define('hello_world_tpl_path', '../modules/hello_world/templates/');

define('URL_hello_world', 'module.php?module=hello_world');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('hello_world_path', hello_world_path);
	$main_smarty->assign('hello_world_lang_conf', hello_world_lang_conf);
	$main_smarty->assign('hello_world_tpl_path', hello_world_tpl_path);
	$main_smarty->assign('URL_hello_world', URL_hello_world);	
}

?>