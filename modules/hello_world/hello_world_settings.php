<?php
define('hello_world_path', my_pligg_base . '/modules/hello_world/');define('hello_world_tpl_path', '../modules/hello_world/templates/');
define('URL_hello_world', 'module.php?module=hello_world');
if(is_object($main_smarty)){
	$main_smarty->assign('hello_world_path', hello_world_path);
	$main_smarty->assign('hello_world_lang_conf', hello_world_lang_conf);
	$main_smarty->assign('hello_world_tpl_path', hello_world_tpl_path);
	$main_smarty->assign('URL_hello_world', URL_hello_world);	
}
?>