<?php
if(defined('mnminclude')){
	include_once('comment_subscription_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', comment_subscription_tpl_path . 'comment_subscription_admin_main_link.tpl');
		module_add_action('after_comment_submit', 'comment_subscription_comment_submit', '' ) ;
		module_add_action('do_submit3', 'comment_subscription_story_submit', '' ) ;

		module_add_action_tpl('tpl_pligg_head_end', comment_subscription_tpl_path . 'comment_subscription_js.tpl');
		module_add_action_tpl('tpl_pligg_story_tools_end', comment_subscription_tpl_path . 'comment_subscription_story_tools_end.tpl');

		module_add_action_tpl('tpl_pligg_story_comments_start', comment_subscription_tpl_path . 'comment_subscription_story_tools_end.tpl');


		module_add_action('profile_save', 'comment_subscription_profile_save', '');
		module_add_action('profile_show', 'comment_subscription_profile_show', '');
		module_add_action_tpl('tpl_user_edit_fields', comment_subscription_tpl_path . 'comment_subscription_center_fields.tpl');

		include_once(mnmmodules . 'comment_subscription/comment_subscription_main.php');
	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'comment_subscription'){
			module_add_action('module_page', 'comment_subscription_showpage', '');
		
			include_once(mnmmodules . 'comment_subscription/comment_subscription_main.php');
		}
	}
}
?>