<?php
if(defined('mnminclude')){
	include_once('admin_help_english_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index'
	
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', admin_help_english_tpl_path . 'admin_help_english_admin_main_link.tpl');
		module_add_action_tpl('tpl_pligg_admin_legend_before', admin_help_english_tpl_path . 'admin_help_legend.tpl');
	}
	

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'admin_help_english'){
			module_add_action('module_page', 'admin_help_english_showpage', '');		
			include_once(mnmmodules . 'admin_help_english/admin_help_english_main.php');
		}
		
		
	}
}	
?>