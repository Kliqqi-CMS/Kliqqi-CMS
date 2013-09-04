<?php
	include_once('sidebar_saved_settings.php');
	$do_not_include_in_pages = array();	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = sidebar_saved_plugins_path;
			module_add_action_tpl('widget_sidebar', sidebar_saved_tpl_path . 'sidebar_saved_index.tpl',array('weight'=>1));
		}
	}
?>
