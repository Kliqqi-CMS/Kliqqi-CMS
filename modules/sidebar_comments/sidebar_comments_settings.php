<?php

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_comments folder(s)
define('sidebar_comments_path', my_pligg_base . '/modules/sidebar_comments/');
// the path to the modules templates. the probably shouldn't be changed unless you rename the sidebar_comments folder(s)
define('sidebar_comments_tpl_path', '../modules/sidebar_comments/templates/');
// the path for smarty / template lite plugins
define('sidebar_comments_plugins_path', 'modules/sidebar_comments/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('sidebar_comments_path', sidebar_comments_path);
	$main_smarty->assign('sidebar_comments_tpl_path', sidebar_comments_tpl_path);
}

?>
