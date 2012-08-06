<?php
#ini_set('display_errors', 1);
#error_reporting(E_ALL ^ E_NOTICE);

if(defined('mnminclude')){
	include_once('redc_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		include_once(mnmmodules . 'redc/redc_main.php');
		module_add_action('register_check_errors', 'redc_check_errors','');
		module_add_action('register_check_field', 'redc_check_field','');
	}

	$include_in_pages = array('module','admin_index','admin_widgets','admin_modules','admin_links','admin_comments','admin_users','admin_config','admin_categories','admin_page','admin_group','admin_editor');
	if( do_we_load_module() ) {
		module_add_action_tpl('tpl_header_admin_main_links', redc_tpl_path . 'redc_admin_main_link.tpl');

		$moduleName = $_REQUEST['module'];
		if($moduleName == 'redc'){
			module_add_action('module_page', 'redc_showpage', '');
		
			include_once(mnmmodules . 'redc/redc_main.php');
		}
	}
}
?>