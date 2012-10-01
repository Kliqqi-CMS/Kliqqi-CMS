<?php
	include_once('sidebar_tag_cloud_settings.php');
	$do_not_include_in_pages = array();	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			
			module_add_action_tpl('widget_sidebar', sidebar_tag_cloud_tpl_path . 'sidebar_tag_cloud_index.tpl');

		}
	}
?>