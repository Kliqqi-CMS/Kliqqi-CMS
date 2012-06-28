<?php
if(defined('mnminclude')){
	include_once('simple_messaging_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		

		module_add_action('all_pages_top', 'get_new_messages', '');

		// show the inbox link in the menus on the top
		module_add_action_tpl('tpl_pligg_sidebar2_end', simple_messaging_tpl_path . 'inbox_link_in_menu.tpl');


		if(isset($_REQUEST['module'])){$moduleName = $_REQUEST['module'];}else{$moduleName = '';}

		if($moduleName == 'simple_messaging'){
			module_add_action('module_page', 'simple_messaging_showpage', '');
		
		}
	
		include_once(mnmmodules . 'simple_messaging/simple_messaging_main.php');
	}
}
?>
