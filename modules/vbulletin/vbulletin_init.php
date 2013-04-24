<?php
if(defined('mnminclude')){
	include_once('vbulletin_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
#		module_add_action_tpl('tpl_header_admin_links', vbulletin_tpl_path . 'vbulletin_admin_link.tpl');
		module_add_action_tpl('tpl_header_admin_main_links', vbulletin_tpl_path . 'vbulletin_admin_main_link.tpl');
		module_add_action('all_pages_top', 'vbulletin_all_pages_top', '');
		module_add_action('logout_success', 'vbulletin_logout', '');

		include_once(mnmmodules . 'vbulletin/vbulletin_main.php');
	}

#	$include_in_pages = array('login');
#	if( do_we_load_module() ) {		
#		module_add_action('login_success_pre_redirect', 'vbulletin_login', '');
#		module_add_action('logout_success', 'vbulletin_logout', '');
#
#		include_once(mnmmodules . 'vbulletin/vbulletin_main.php');
#	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'vbulletin'){
			module_add_action('module_page', 'vbulletin_showpage', '');
		
			include_once(mnmmodules . 'vbulletin/vbulletin_main.php');
		}
	}
}
?>