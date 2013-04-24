<?php
if(defined('mnminclude')){
	include_once('karma_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', karma_tpl_path . 'karma_admin_main_link.tpl');

		module_add_action('do_submit3', 'karma_do_submit3','');
		module_add_action('link_published', 'karma_published','');
		module_add_action('after_comment_submit', 'karma_comment_submit','');
		module_add_action('link_insert_vote_post', 'karma_vote','');
		module_add_action('comment_insert_vote_post', 'karma_comment_vote','');

		module_add_action('story_discard', 'karma_story_discard','');
		module_add_action('admin_story_delete', 'karma_story_discard','');
		module_add_action('story_spam', 'karma_story_spam','');
		module_add_action('comment_deleted', 'karma_comment_deleted','');
		module_add_action('comment_spam', 'karma_comment_spam','');
		module_add_action('link_remove_vote_post', 'karma_unvote','');

		include_once(mnmmodules . 'karma/karma_main.php');
	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];
		if($moduleName == 'karma'){
			module_add_action('module_page', 'karma_showpage', '');
		
			include_once(mnmmodules . 'karma/karma_main.php');
		}
	}
}
?>