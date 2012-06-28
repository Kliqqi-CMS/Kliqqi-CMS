<?php
if(defined('mnminclude')){
	include_once('links_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		//module_add_action_tpl('tpl_header_admin_links', links_tpl_path . 'links_admin_link.tpl');
		module_add_action_tpl('tpl_header_admin_main_links', links_tpl_path . 'links_admin_main_link.tpl');
		module_add_action('show_comment_content', 'links_show_comment_content', '');
		module_add_action('lib_link_summary_fill_smarty', 'links_summary_fill_smarty', '');


		include_once(mnmmodules . 'links/links_main.php');
	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'links'){
			module_add_action('module_page', 'links_showpage', '');
		
			include_once(mnmmodules . 'links/links_main.php');
		}
	}
}
?>