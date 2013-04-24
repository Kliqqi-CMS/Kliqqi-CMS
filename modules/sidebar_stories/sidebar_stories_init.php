<?php
	include_once('sidebar_stories_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'
	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = sidebar_stories_plugins_path;
			module_add_action_tpl('widget_sidebar', sidebar_stories_tpl_path . 'sidebar_stories_index.tpl');
		}
	}
?>
