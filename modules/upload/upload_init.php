<?php
if(defined('mnminclude')){
	include_once('upload_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and new.php becomes 'new'
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
		module_add_action('rss_item', 'upload_rss_item', '');
		module_add_action('comment_rss_item', 'upload_comment_rss_item', '');

	        $settings = get_upload_settings();

		module_add_action('admin_story_delete', 'upload_delete', '');
		module_add_action('comment_deleted', 'upload_comment_delete', '');

		$place = get_misc_data('upload_place');		
		$fileplace = get_misc_data('upload_fileplace');		
        	module_add_action_tpl($place, upload_tpl_path . '/upload_thumb.tpl');
        	module_add_action_tpl($fileplace, upload_tpl_path . '/upload_links.tpl');

		module_add_action_tpl('tpl_header_admin_main_links', upload_tpl_path . 'upload_admin_main_link.tpl');

		if ($settings['allow_comment']) {
		    module_add_action('show_comment_content', 'upload_comment_track', '');

        	    module_add_action_tpl($settings['commentplace'], upload_tpl_path . '/upload_comment_thumb.tpl');
        	    module_add_action_tpl($settings['commentfilelist'], upload_tpl_path . '/upload_links.tpl');
		}
	}

	$include_in_pages = array('submit','story','edit');
	if( do_we_load_module() ) {		
		include_once(mnmmodules . 'upload/upload_main.php');
        
        	module_add_action_tpl('tpl_pligg_submit_step2_after_form', upload_tpl_path . '/upload_files.tpl');

	        $settings = get_upload_settings();
		if ($settings['allow_comment']) {
		    module_add_action('after_comment_submit', 'upload_do_comment_submit','');        		     
		    module_add_action('after_comment_edit', 'upload_do_comment_submit','');        		     
        	    module_add_action_tpl('tpl_pligg_story_comments_form_end', upload_tpl_path . '/upload_comments.tpl');
		}
	}

	$include_in_pages = array('editlink');
	if( do_we_load_module() ) {		
        
		module_add_action('edit_link_hook', 'upload_edit_link','');        		        
		include_once(mnmmodules . 'upload/upload_main.php');
        
        	module_add_action_tpl('tpl_pligg_submit_step2_after_form', upload_tpl_path . '/upload_files.tpl');
//        	module_add_action_tpl('submit_step_2_pre_extrafields', upload_tpl_path . '/edit_files.tpl');
	}

}
?>