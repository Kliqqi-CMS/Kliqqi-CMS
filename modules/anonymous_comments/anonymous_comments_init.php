<?php
if(defined('mnminclude')){
	include_once('anonymous_comments_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	
	
	if( do_we_load_module() ) {		
		
		
		//module_add_action('anonymous_comments_insert_function', 'anonymous_comments_insert', '');
		module_add_action('anonymous_user_id', 'get_anonymous_user_id', '');
		module_add_action('show_comment_username', 'get_comment_username', '');
		module_add_action('anonymous_comment', 'insert_anonymous_comment', '');
		module_add_action_tpl('anonymous_comment_form', anonymous_comments_tpl_path . 'anonymous_comments.tpl');
		
		include_once(mnmmodules . 'anonymous_comments/anonymous_comments_main.php');

	}
}	
?>