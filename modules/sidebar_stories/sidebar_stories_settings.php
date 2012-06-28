<?php

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stories folder(s)
define('sidebar_stories_path', my_pligg_base . '/modules/sidebar_stories/');
// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stories folder(s)
define('sidebar_stories_lang_conf', '/modules/sidebar_stories/lang.conf');
// the path to the modules templates. the probably shouldn't be changed unless you rename the sidebar_stories folder(s)
define('sidebar_stories_tpl_path', '../modules/sidebar_stories/templates/');
// the path for smarty / template lite plugins
define('sidebar_stories_plugins_path', 'modules/sidebar_stories/plugins');

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('sidebar_stories_path', sidebar_stories_path);
	$main_smarty->assign('sidebar_stories_lang_conf', sidebar_stories_lang_conf);
	$main_smarty->assign('sidebar_stories_tpl_path', sidebar_stories_tpl_path);
}

?>
