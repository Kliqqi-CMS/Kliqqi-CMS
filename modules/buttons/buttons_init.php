<?php
if(defined('mnminclude')){
	include_once('buttons_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('module','admin_backup','admin_index','admin_widgets','admin_modules','admin_links','admin_comments','admin_users','admin_config','admin_categories','admin_page','admin_group','admin_editor');
	if( do_we_load_module() ) {
		module_add_action_tpl('tpl_header_admin_main_links', buttons_tpl_path . 'buttons_admin_main_link.tpl');

		$moduleName = $_REQUEST['module'];
		if($moduleName == 'buttons'){
			module_add_action('module_page', 'buttons_showpage', '');
		
			include_once(mnmmodules . 'buttons/buttons_main.php');
		}
	}
}
?>