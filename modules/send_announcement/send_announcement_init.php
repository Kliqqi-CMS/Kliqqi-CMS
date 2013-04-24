<?php
if(defined('mnminclude')){
	include_once('send_announcement_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'	
	$do_not_include_in_pages = array();	
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', send_announcement_tpl_path . 'sendannouncement_admin_main_link.tpl');
	}
	
	$include_in_pages = array('module');
	if( do_we_load_module() ) {	

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'sendannouncement'){
			
			module_add_action('module_page', 'sendannouncement_showpage', '');
				
			include_once(mnmmodules . 'send_announcement/send_announcement_main.php');
	
		}
	}
}
?>