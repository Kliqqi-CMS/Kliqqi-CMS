<?php

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stories folder(s)
define('sidebar_tag_cloud_path', my_pligg_base . '/modules/sidebar_tag_cloud/');
// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stories folder(s)

// the path to the modules templates. the probably shouldn't be changed unless you rename the sidebar_stories folder(s)
define('sidebar_tag_cloud_tpl_path', '../modules/sidebar_tag_cloud/templates/');
// the path for smarty / template lite plugins

// don't touch anything past this line.

if(is_object($main_smarty)){
	$main_smarty->assign('sidebar_tag_cloud_path', sidebar_tag_cloud_path);

	$main_smarty->assign('sidebar_tag_cloud_tpl_path', sidebar_tag_cloud_tpl_path);
}

?>
