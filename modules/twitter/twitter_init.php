<?php
if(defined('mnminclude')){
	include_once('twitter_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', twitter_tpl_path . 'twitter_admin_main_link.tpl');
		module_add_action_tpl('tpl_pligg_login_link', twitter_tpl_path . 'twitter_login.tpl');

		module_add_action('profile_save', 'twitter_profile_save', '');
		module_add_action('profile_show', 'twitter_profile_show', '');
		module_add_action_tpl('tpl_user_edit_fields', twitter_tpl_path . 'twitter_center_fields.tpl');

		include_once(mnmmodules . 'twitter/twitter_main.php');
	}

	$include_in_pages = array('login');
	if( do_we_load_module() ) {		
		module_add_action('login_success_pre_redirect', 'twitter_login', '');

		include_once(mnmmodules . 'twitter/twitter_main.php');
	}

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action('do_submit3', 'twitter_do_submit3','');
		module_add_action('link_published', 'twitter_published','');
		module_add_action_tpl('tpl_pligg_story_tools_end', twitter_tpl_path . 'twitter_story_tools_end.tpl');
		module_add_action_tpl('tpl_pligg_head_end', twitter_tpl_path . 'twitter_js.tpl');
 
		include_once(mnmmodules . 'twitter/twitter_main.php');
	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'twitter'){
			module_add_action('module_page', 'twitter_showpage', '');
		
			include_once(mnmmodules . 'twitter/twitter_main.php');
		}
	}

}
?>