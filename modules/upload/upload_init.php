<?php
if(defined('mnminclude')){
	include_once('upload_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();


	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];
		if($moduleName == 'upload'){
			module_add_action('module_page', 'upload_showpage', '');
		
			include_once(mnmmodules . 'upload/upload_main.php');
		}
	}

	$include_in_pages = array('all');
	if( do_we_load_module() ) {
		include_once(mnmmodules . 'upload/upload_main.php');
		module_add_action('lib_link_summary_fill_smarty', 'upload_track', '');
		module_add_action('admin_story_delete', 'upload_delete', '');

		$place = get_misc_data('upload_place');		
		$fileplace = get_misc_data('upload_fileplace');		
        	module_add_action_tpl($place, upload_tpl_path . '/upload_thumb.tpl');
        	module_add_action_tpl($fileplace, upload_tpl_path . '/upload_links.tpl');
		module_add_action_tpl('tpl_header_admin_main_links', upload_tpl_path . 'upload_admin_main_link.tpl');
	}

	$include_in_pages = array('submit','story');
	if( do_we_load_module() ) {		
//		module_add_action('do_submit2', 'upload_do_submit2','');        		     
		include_once(mnmmodules . 'upload/upload_main.php');
        
        	module_add_action_tpl('tpl_pligg_submit_step2_start', upload_tpl_path . '/upload_files.tpl');
//        	module_add_action_tpl('submit_step_2_pre_extrafields', upload_tpl_path . '/upload_files.tpl');
	}

	$include_in_pages = array('editlink');
	if( do_we_load_module() ) {		
        
		module_add_action('edit_link_hook', 'upload_edit_link','');        		        
		include_once(mnmmodules . 'upload/upload_main.php');
        
        	module_add_action_tpl('tpl_pligg_submit_step2_start', upload_tpl_path . '/upload_files.tpl');
//        	module_add_action_tpl('submit_step_2_pre_extrafields', upload_tpl_path . '/edit_files.tpl');
	}

}
?>