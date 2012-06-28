<?php
	include_once('auto_update_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = auto_update_plugins_path;

			module_add_action_tpl('tpl_pligg_admin_body_start', auto_update_tpl_path . 'auto_update.tpl');
			include_once(mnmmodules . 'auto_update/auto_update_main.php');
		}
	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'auto_update'){
			module_add_action('module_page', 'auto_update_showpage', '');
			module_add_action_tpl('tpl_pligg_admin_breadcrumbs', auto_update_tpl_path . 'auto_update_breadcrumb.tpl');
		
			include_once(mnmmodules . 'auto_update/auto_update_main.php');
		}
	}
?>
