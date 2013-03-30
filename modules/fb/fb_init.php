<?php
if(defined('mnminclude')){
	include_once('fb_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		//module_add_action_tpl('tpl_header_admin_links', fb_tpl_path . 'fb_admin_link.tpl');
		module_add_action_tpl('tpl_header_admin_main_links', fb_tpl_path . 'fb_admin_main_link.tpl');

		module_add_action_tpl('tpl_pligg_login_link', fb_tpl_path . 'fb_login.tpl');
		module_add_action_tpl('tpl_pligg_body_start', fb_tpl_path . 'fb_script.tpl');
		module_add_action_tpl('tpl_pligg_story_tools_end', fb_tpl_path . 'fb_story_tools_end.tpl');
		module_add_action_tpl('tpl_pligg_head_end', fb_tpl_path . 'fb_js.tpl');

		module_add_action('all_pages_top', 'fb_all_pages_top', '');

		module_add_action('profile_save', 'fb_profile_save', '');
		module_add_action('profile_show', 'fb_profile_show', '');
		module_add_action_tpl('tpl_user_edit_fields', fb_tpl_path . 'fb_center_fields.tpl');

		module_add_action('after_comment_submit', 'fb_comment_submit', '' ) ;
		include_once(mnmmodules . 'fb/fb_main.php');
	}

	$include_in_pages = array('login');
	if( do_we_load_module() ) {		
		module_add_action('login_success_pre_redirect', 'fb_login', '');
		module_add_action('logout_success', 'fb_logout', '');

		include_once(mnmmodules . 'fb/fb_main.php');
	}

	$include_in_pages = array('submit');
	if( do_we_load_module() ) {		
		module_add_action('do_submit3', 'fb_do_submit3','');
		module_add_action_tpl('tpl_pligg_submit_step1_middle', fb_tpl_path . 'fb_permlink.tpl');
		module_add_action_tpl('tpl_pligg_submit_step3_end', fb_tpl_path . 'fb_checkbox.tpl');

		include_once(mnmmodules . 'fb/fb_main.php');
	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'fb'){
			module_add_action('module_page', 'fb_showpage', '');
		
			include_once(mnmmodules . 'fb/fb_main.php');
		}
	}

}
?>