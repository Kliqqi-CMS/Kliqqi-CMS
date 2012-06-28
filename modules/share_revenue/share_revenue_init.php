<?php
if(defined('mnminclude')){
	include_once('share_revenue_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();
		
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			$main_smarty->plugins_dir[] = share_revenue_plugins_path;
		}
		module_add_action_tpl('tpl_pligg_content_start', share_revenue_tpl_path . 'show_ads.tpl');
		module_add_action_tpl('tpl_header_admin_main_links', share_revenue_tpl_path . 'admin_access.tpl');		
		
	}
}
?>