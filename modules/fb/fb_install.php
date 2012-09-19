<?php
	$module_info['name'] = 'Facebook ';
	$module_info['desc'] = 'New members can register by logging in to their Facebook account, while existing members can connect their account to Facebook for a faster login process.';
	$module_info['version'] = 4.2;
	$module_info['settings_url'] = '../module.php?module=fb';
	$module_info['homepage_url'] = 'http://forums.pligg.com/modules-sale/16197-facebook-connect-module.html';
	$module_info['update_url'] = 'http://forums.pligg.com/versioncheck.php?product=facebook';
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `user_fb` VARCHAR(255)";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `fb_follow_friends` TINYINT(1) DEFAULT '0'";
	$module_info['db_sql'][] = "ALTER TABLE ".table_users." ADD  `fb_access_token` VARCHAR(255) DEFAULT ''";
?>
