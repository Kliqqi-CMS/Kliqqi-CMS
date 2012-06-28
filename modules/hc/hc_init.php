<?php
if(defined('mnminclude')){
	include_once('hc_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		

		module_add_action('do_submit1', 'hc_register', '');
		module_add_action('submit2_check_errors', 'hc_register_check_errors', '');

		module_add_action('story_top', 'hc_register', '');
		module_add_action('story_insert_comment', 'hc_register_check_errors', '');
		module_add_action('story_edit_comment', 'hc_register_check_errors', '');

		include_once(mnmmodules . 'hc/hc_main.php');
	}
}
?>
