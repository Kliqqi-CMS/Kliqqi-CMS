<?php
	$module_info['name'] = 'Twitter Module';
	$module_info['desc'] = 'Lets members use Twitter to login or register an account';
	$module_info['version'] = '2.6';
	$module_info['settings_url'] = '../module.php?module=twitter';
	$module_info['homepage_url'] = 'http://forums.pligg.com/modules-sale/23654-official-twitter-module.html';
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `user_twitter_id` BIGINT NOT NULL";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `user_twitter_token` VARCHAR(255)";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `user_twitter_secret` VARCHAR(255)";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `twitter_follow_friends` TINYINT(1) DEFAULT '0'";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `twitter_tweet` TINYINT(1) DEFAULT '0'";
?>
