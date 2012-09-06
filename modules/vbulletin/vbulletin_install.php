<?php
	$module_info['name'] = 'vBulletin User Bridge';
	$module_info['desc'] = 'Synchronizes existing vBulletin users to Pligg CMS.';
	$module_info['version'] = 2.0;
	$module_info['settings_url'] = '../module.php?module=vbulletin';
	$module_info['db_sql'][] = "ALTER TABLE `pligg_users` ADD  `user_vbulletin` INT NOT NULL";
?>
