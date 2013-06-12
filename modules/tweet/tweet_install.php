<?php
	$module_info['name'] = 'Tweet Module';
	$module_info['desc'] = 'This module will post stories to a Twitter account whenever a story is either published or submitted.';
	$module_info['version'] = 2.2;
	$module_info['settings_url'] = '../module.php?module=tweet';
	$module_info['homepage_url'] = 'http://pligg.com/downloads/module/tweet-automatic-twitter-submissions/';
	$module_info['update_url'] = 'http://pligg.com/downloads/module/tweet-automatic-twitter-submissions/version/';
	$module_info['db_add_field'][]=array(table_prefix . 'links', 'tweet_id', 'VARCHAR',  32, "", 0, '0');
?>