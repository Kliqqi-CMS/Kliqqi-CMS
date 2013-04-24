<?php
if(defined('mnminclude')){
	include_once('welcome_email_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'
	$include_in_pages = array('register');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		

		module_add_action('register_success_pre_redirect', 'welcome_email_send', '');
				
		include_once(mnmmodules . 'welcome_email/welcome_email_main.php');
	}
}	
?>