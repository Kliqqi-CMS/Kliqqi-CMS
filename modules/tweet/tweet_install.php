<?php
	$module_info['name'] = 'Tweet Module';
	$module_info['desc'] = 'This module will post stories to a Twitter account whenever a story is either published or submitted.';
	$module_info['version'] = 1.1;
//	$module_info['homepage_url'] = 'http://www.pligg.com/pro/catalog/modules/karma-98.html';
	$module_info['settings_url'] = '../module.php?module=tweet';
	// this is where you set the modules "name" and "version" that is required
	// if more that one module is required then just make a copy of that line

	$module_info['db_add_field'][]=array(table_prefix . 'links', 'tweet_id', 'VARCHAR',  32, "", 0, '0');
?>