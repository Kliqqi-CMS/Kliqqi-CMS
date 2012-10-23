<?php
if(defined('mnminclude')){
	include_once('tweet_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		include_once(mnmmodules . 'tweet/tweet_main.php');
		module_add_action('do_submit3', 'tweet_do_submit3','');
		module_add_action('link_published', 'tweet_published','');
	}

	$include_in_pages = array('module','admin_index');
	if( do_we_load_module() ) {
		module_add_action_tpl('tpl_header_admin_main_links', tweet_tpl_path . 'tweet_admin_main_link.tpl');

		$moduleName = $_REQUEST['module'];
		if($moduleName == 'tweet'){
			module_add_action('module_page', 'tweet_showpage', '');
		
			include_once(mnmmodules . 'tweet/tweet_main.php');
		}
	}
}
?>