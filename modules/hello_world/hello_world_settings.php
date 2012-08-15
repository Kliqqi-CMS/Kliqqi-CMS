<?php
define('hello_world_path', my_pligg_base . '/modules/hello_world/');
define('hello_world_tpl_path', '../modules/hello_world/templates/');

if(is_object($main_smarty)){
	$main_smarty->assign('hello_world_path', hello_world_path);
	$main_smarty->assign('hello_world_tpl_path', hello_world_tpl_path);
}

?>