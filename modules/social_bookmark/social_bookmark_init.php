<?php
	include_once('social_bookmark_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'
	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			module_add_action_tpl('tpl_pligg_story_tools_end', social_bookmark_tpl_path . 'social_bookmark_index.tpl');
		}
	}
?>