<?php
	$module_info['name'] = 'Human Check';
	$module_info['desc'] = 'A behind the scenes "honeypot" anti-spam tool. No configuration necessary.';
	$module_info['version'] = 1.0;
	$module_info['install'] = $module_info['uninstall2'] = 'recursive_remove_directory("../cache",TRUE);';
	$module_info['homepage_url'] = 'http://pligg.com/downloads/module/human-check/';
	$module_info['update_url'] = 'http://pligg.com/downloads/module/human-check/version/';
	
	//$module_info['settings_url'] = '../module.php?module=hc';
	//$module_info['db_add_field'][]=array(table_prefix . 'links', 'akismet', 'TINYINT',  3, "UNSIGNED", 0, '0');
?>