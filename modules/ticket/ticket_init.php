<?php
	include_once('ticket_settings.php');

	// tell pligg what pages this modules should be included in
	$do_not_include_in_pages = array();
	
	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		if(is_object($main_smarty)){
			module_add_action_tpl('tpl_pligg_story_tools_end', ticket_tpl_path . 'ticket_index.tpl');
		}
	}
?>