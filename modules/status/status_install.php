<?php
	$module_info['name'] = 'Status Update Module';
	$module_info['desc'] = 'Adds features to turn profile pages into a service similar to Twitter.';
	$module_info['version'] = '1.5';
	$module_info['settings_url'] = '../module.php?module=status';
	$module_info['homepage_url'] = 'http://pligg.com/downloads/module/status-update-module/';
	$module_info['update_url'] = 'http://pligg.com/downloads/module/status-update-module/version/';
	
	// Add new columns
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `status_switch` TINYINT(1) DEFAULT '1'";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `status_friends` TINYINT(1) DEFAULT '1'";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `status_story` TINYINT(1) DEFAULT '1'";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `status_comment` TINYINT(1) DEFAULT '1'";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `status_email` TINYINT(1) DEFAULT '1'";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `status_group` TINYINT(1) DEFAULT '1'";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `status_all_friends` TINYINT(1) DEFAULT '1'";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `status_friend_list` TEXT";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `status_excludes` TEXT";

	// Set default values
	$module_info['db_sql'][] = "UPDATE ".table_users." SET status_switch=1, status_friends=1, status_story=1, status_comment=1, status_email=1, status_all_friends=1";

	// Add new table
	$module_info['db_add_table'][]=array(
	'name' => table_prefix . "updates",
	'sql' => "CREATE TABLE `".table_prefix . "updates` (
	  `update_id` int(11) NOT NULL auto_increment,
	  `update_time` int(11) default NULL,
	  `update_type` char(1) NOT NULL,
	  `update_link_id` int(11) NOT NULL,
	  `update_user_id` int(11) NOT NULL,
	  `update_group_id` int(11) NOT NULL,
	  `update_likes` int(11) NOT NULL,
	  `update_level` varchar(25),
	  `update_text` text NOT NULL,
	  PRIMARY KEY  (`update_id`),
	  FULLTEXT KEY `update_text` (`update_text`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
	
	$module_info['db_add_table'][]=array(
	'name' => table_prefix . "likes",
	'sql' => "CREATE TABLE `".table_prefix . "likes` (
	  `like_update_id` int(11) NOT NULL,
	  `like_user_id` int(11) NOT NULL,
	  PRIMARY KEY  (`like_update_id`, `like_user_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
	
	// Set default module settings
	if (get_misc_data('status_switch')=='')
	{
		misc_data_update('status_switch', '0');
		misc_data_update('status_show_permalin', '1');
		misc_data_update('status_permalinks', '1');
		misc_data_update('status_inputonother', '1');
		misc_data_update('status_place', 'tpl_pligg_profile_tab_insert');
		misc_data_update('status_clock', '12');
		misc_data_update('status_results', '10');
		misc_data_update('status_max_chars', '1200');
		misc_data_update('status_avatar', 'small');
		misc_data_update('status_profile_level', 'admin,moderator,normal');
		misc_data_update('status_level', 'admin,moderator,normal');
		misc_data_update('status_user_email', '1');
		misc_data_update('status_user_comment', '1');
		misc_data_update('status_user_story', '1');
		misc_data_update('status_user_friends', '1');
		misc_data_update('status_user_switch', '1');
	}

?>
