<?php
if(defined('mnminclude')){
	include_once('anonymous_story_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
	
	if( do_we_load_module() ) {		
		
		module_add_action('anonymous_story_user_id', 'get_anonymous_story_user_id', '');
		include_once(mnmmodules . 'anonymous_story/anonymous_story_main.php');
	}
}	
?>