<?php
if(defined('mnminclude')){
	include_once('admin_language_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		//module_add_action_tpl('tpl_header_admin_links', admin_language_tpl_path . 'admin_language_admin_link.tpl');
		module_add_action_tpl('tpl_header_admin_main_links', admin_language_tpl_path . 'admin_language_admin_main_link.tpl');
	}
	

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'admin_language'){
			module_add_action_tpl('tpl_pligg_admin_head_end', admin_language_tpl_path . 'admin_language_javascript.tpl');
			module_add_action('module_page', 'admin_language_showpage', '');
		
			include_once(mnmmodules . 'admin_language/admin_language_main.php');
		}
	}
}
?>