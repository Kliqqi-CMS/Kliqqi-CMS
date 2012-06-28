<?php
if(defined('mnminclude')){
	include_once('hello_world_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and shakeit.php becomes 'shakeit'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', hello_world_tpl_path . 'hello_world_admin_main_link.tpl');
	}
	

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'hello_world'){

			module_add_action('module_page', 'hello_world_showpage', '');
		
			include_once(mnmmodules . 'hello_world/hello_world_main.php');
		}
	}
}	
?>