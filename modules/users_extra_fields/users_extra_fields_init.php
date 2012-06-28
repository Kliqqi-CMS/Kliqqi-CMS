<?php
if(defined('mnminclude')){
	include_once('users_extra_fields_settings.php');

	// tell pligg what pages this modules should be included in
	// pages are <script name> minus .php
	// index.php becomes 'index' and upcoming.php becomes 'upcoming'
	$include_in_pages = array('all');
	$do_not_include_in_pages = array();

	if( do_we_load_module() ) {

		module_add_action('story_top', 'users_extra_fields_story_top', '');

		module_add_action('admin_users_save', 'users_extra_fields_admin_users_save', '');
		module_add_action('admin_users_view', 'users_extra_fields_admin_users_view', '');
		module_add_action('admin_users_edit', 'users_extra_fields_admin_users_edit', '');

		module_add_action('profile_save', 'users_extra_fields_profile_save', '');
		module_add_action('profile_show', 'users_extra_fields_profile_show', '');

		module_add_action_tpl('tpl_profile_center_fields', users_extra_fields_tpl_path . 'profile_center_fields.tpl');
		module_add_action_tpl('tpl_admin_user_edit_center_fields', users_extra_fields_tpl_path . 'admin_user_edit_center_fields.tpl');
		module_add_action_tpl('tpl_admin_user_show_center_fields', users_extra_fields_tpl_path . 'admin_user_show_center_fields.tpl');

		// ***********************************************
		// call the extended profile display templates
		// we add a module_add_action_tpl for every tpl file we create
		// ***********************************************


		// to load the Age template field ** 1 **
		module_add_action_tpl('tpl_show_extra_profile_age', users_extra_fields_tpl_path . 'profile_extend_age.tpl');

		// to load the Gender template field ** 2 **
		module_add_action_tpl('tpl_show_extra_profile_gender', users_extra_fields_tpl_path . 'profile_extend_gender.tpl');

		// to load the university/college template field ** ? **
		module_add_action_tpl('tpl_show_extra_profile_university', users_extra_fields_tpl_path . 'profile_extend_university.tpl');

		// to load the Status template field ** 3 **
		module_add_action_tpl('tpl_show_extra_profile_status', users_extra_fields_tpl_path . 'profile_extend_status.tpl');

		// to load the Habits template field ** 4 **
		module_add_action_tpl('tpl_show_extra_profile_habits', users_extra_fields_tpl_path . 'profile_extend_habits.tpl');

		// to load the Car template field ** 5 **
		module_add_action_tpl('tpl_show_extra_profile_car', users_extra_fields_tpl_path . 'profile_extend_car.tpl');

		// to load the Country template field ** 6 **
		module_add_action_tpl('tpl_show_extra_profile_country', users_extra_fields_tpl_path . 'profile_extend_country.tpl');

		// to load the State/Province template field ** 7 **
		module_add_action_tpl('tpl_show_extra_profile_state', users_extra_fields_tpl_path . 'profile_extend_state.tpl');

		// to load the BIO template field ** 8 **
		module_add_action_tpl('tpl_show_extra_profile_bio', users_extra_fields_tpl_path . 'profile_extend_bio.tpl');

		// to load the Subscription template field ** 9 **
		module_add_action_tpl('tpl_show_extra_profile_subscription', users_extra_fields_tpl_path . 'profile_extend_subscription.tpl');





		include_once(mnmmodules . 'users_extra_fields/users_extra_fields_main.php');
	}
}
?>