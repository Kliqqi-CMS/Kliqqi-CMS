<?php
if(defined('mnminclude')){
	include_once('dropbox_backup_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'
	$do_not_include_in_pages = array();

	$include_in_pages = array('module','admin_backup','admin_index','admin_widgets','admin_modules','admin_links','admin_comments','admin_users','admin_config','admin_categories','admin_page','admin_group','admin_editor');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', dropbox_backup_tpl_path . 'dropbox_backup_admin_link.tpl');
		include_once(mnmmodules . 'dropbox_backup/dropbox_backup_main.php');
	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		
		$moduleName = $_REQUEST['module'];
		if($moduleName == 'dropbox_backup'){
			module_add_action('module_page', 'dropbox_backup_showpage', '');
			include_once(mnmmodules . 'dropbox_backup/dropbox_backup_main.php');
		}
	}
}
?>