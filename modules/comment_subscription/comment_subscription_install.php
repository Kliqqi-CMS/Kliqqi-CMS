<?php
	$module_info['name'] = 'Comment Subscription';
	$module_info['desc'] = 'This module allows users to subscribe to an article and receive a HTML formatted email whenever a new comment is submitted.';
	$module_info['version'] = 1.1;
	$module_info['settings_url'] = '../module.php?module=comment_subscription';
	$module_info['homepage_url'] = 'http://pligg.com/downloads/module/comment-subscription-module/';
	$module_info['update_url'] = 'http://pligg.com/downloads/module/comment-subscription-module/version/';

	// Add new columns
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `comment_subscription` TINYINT(1) DEFAULT '1'";

	// Set default values
	$module_info['db_sql'][] = "UPDATE ".table_users." SET comment_subscription=1";

	// Add new table
	$module_info['db_add_table'][]=array(
	'name' => table_prefix . "csubscription",
	'sql' => "CREATE TABLE `".table_prefix . "csubscription` (
	  `subs_link_id` int(11) NOT NULL,
	  `subs_user_id` int(11) NOT NULL,
  	  UNIQUE KEY `subs_link_id` (`subs_link_id`,`subs_user_id`)
	  ) ENGINE=MyISAM");	
?>
