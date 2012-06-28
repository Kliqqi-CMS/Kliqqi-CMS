<?php
if(defined('mnminclude')){
	include_once('status_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$do_not_include_in_pages = array();

	$include_in_pages = array('all');
	if( do_we_load_module() ) {		
		module_add_action_tpl('tpl_header_admin_main_links', status_tpl_path . 'status_admin_main_link.tpl');
		module_add_action('comment_post_save', 'status_comment_submit', '' ) ;
		module_add_action('do_submit3', 'status_story_submit', '' ) ;

		$place = get_misc_data('status_place');		
		if ($place)
        	    module_add_action_tpl($place, status_tpl_path . '/status_list.tpl');


#		module_add_action('admin_users_save', 'users_extra_fields_admin_users_save', '');
#		module_add_action('admin_users_view', 'users_extra_fields_admin_users_view', '');
#		module_add_action('admin_users_edit', 'users_extra_fields_admin_users_edit', '');
		module_add_action('profile_save', 'status_profile_save', '');
		module_add_action('profile_show', 'status_profile_show', '');
		module_add_action_tpl('tpl_profile_center_fields', status_tpl_path . 'status_center_fields.tpl');
#		module_add_action_tpl('tpl_admin_user_edit_center_fields', users_extra_fields_tpl_path . 'admin_user_edit_center_fields.tpl');
#		module_add_action_tpl('tpl_admin_user_show_center_fields', users_extra_fields_tpl_path . 'admin_user_show_center_fields.tpl');

		include_once(mnmmodules . 'status/status_main.php');
	}

	$include_in_pages = array('module');
	if( do_we_load_module() ) {		

		$moduleName = $_REQUEST['module'];

		if($moduleName == 'status'){
			module_add_action('module_page', 'status_showpage', '');
		
			include_once(mnmmodules . 'status/status_main.php');
		}
	}
}
?>