<?php

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stories_u folder(s)
define('sidebar_stories_u_path', my_pligg_base . '/modules/sidebar_stories_u/');
// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stories_u folder(s)
define('sidebar_stories_u_lang_conf', '/modules/sidebar_stories_u/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the sidebar_stories_u folder(s)
define('sidebar_stories_u_tpl_path', '../modules/sidebar_stories_u/templates/');
// the path for smarty / template lite plugins
define('sidebar_stories_u_plugins_path', 'modules/sidebar_stories_u/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('sidebar_stories_u_path', sidebar_stories_u_path);
	$main_smarty->assign('sidebar_stories_u_lang_conf', sidebar_stories_u_lang_conf);
	$main_smarty->assign('sidebar_stories_u_tpl_path', sidebar_stories_u_tpl_path);
}

?>
