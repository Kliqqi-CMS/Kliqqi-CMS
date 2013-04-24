<?php
if(defined('mnminclude')){
	include_once('spam_trigger_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'
	$do_not_include_in_pages = array();


	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];
		if($moduleName == 'spam_trigger'){
			module_add_action('module_page', 'spam_trigger_showpage', '');
		
			include_once(mnmmodules . 'spam_trigger/spam_trigger_main.php');
		}
	}

	$include_in_pages = array('all');
	if( do_we_load_module() ) {
		include_once(mnmmodules . 'spam_trigger/spam_trigger_main.php');
		module_add_action_tpl('tpl_header_admin_main_links', spam_trigger_tpl_path . 'spam_trigger_admin_main_link.tpl');
		module_add_action_tpl('tpl_pligg_content_start', spam_trigger_tpl_path . 'story.tpl');
	}

	$include_in_pages = array('submit');
	if( do_we_load_module() ) {		
		module_add_action('do_submit3', 'spam_trigger_do_submit3','');
		include_once(mnmmodules . 'spam_trigger/spam_trigger_main.php');
	}

	$include_in_pages = array('story','edit');
	if( do_we_load_module() ) {		

		module_add_action('story_insert_comment', 'spam_trigger_comment','');
		module_add_action('after_comment_edit', 'spam_trigger_comment_submit','');        		     
		module_add_action_tpl('tpl_pligg_story_comments_individual_end', spam_trigger_tpl_path . 'comments.tpl');
		include_once(mnmmodules . 'spam_trigger/spam_trigger_main.php');
	}

	$include_in_pages = array('editlink');
	if( do_we_load_module() ) {		
		module_add_action('edit_link_hook', 'spam_trigger_editlink','');        		        
		include_once(mnmmodules . 'spam_trigger/spam_trigger_main.php');
	}

}
?>