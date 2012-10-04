<?php
if(defined('mnminclude')){
	include_once('rss_import_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {	
		// add the rss_import menu options for admin	
		module_add_action_tpl('tpl_header_admin_main_links', rss_import_tpl_path . 'rss_import_admin_main_link.tpl');
	}

	
	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'rss_import'){
			module_add_action('module_page', 'rss_import_showpage', '');
			include_once(mnmmodules . 'rss_import/rss_import_main.php');
		}

		if($moduleName == 'rss_import_do_import'){
			module_add_action('module_page', 'rss_import_do_import', '');
			include_once(mnmmodules . 'rss_import/rss_import_main.php');
		}
	}
}
?>