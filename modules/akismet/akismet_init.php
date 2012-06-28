<?php
if(defined('mnminclude')){
	include_once('akismet_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		

/*		module_add_action('all_pages_top', 'akismet_top', '');

		$canIhaveAccess = 0;
		$canIhaveAccess = $canIhaveAccess + checklevel('god');

		if($canIhaveAccess == 1)
		{
			// show the inbox link in the menus on the top
			module_add_action_tpl('tpl_sidebar_logged_in_just_below_profile', akismet_tpl_path . 'spam_link_in_menu.tpl');
		}

		module_add_action_tpl('tpl_header_admin_main_links', akismet_tpl_path . 'akismet_admin_main_link.tpl');
*/
		module_add_action('do_submit3', 'akismet_check_submit', '');
		module_add_action('comment_save', 'akismet_save_comment', '');
		module_add_action('profile_save', 'akismet_save_profile', '');

		if(isset($_REQUEST['module'])){$moduleName = $_REQUEST['module'];}else{$moduleName = '';}

		if($moduleName == 'akismet'){
			module_add_action('module_page', 'akismet_showpage', '');
		
		}

		include_once(mnmmodules . 'akismet/akismet_main.php');
	}
}
?>
