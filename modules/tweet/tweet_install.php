<?php
	$module_info['name'] = 'Tweet Module';
	$module_info['desc'] = 'This module will post stories to a Twitter account whenever a story is either published or submitted.';
	$module_info['version'] = 2.0;
	$module_info['homepage_url'] = 'http://forums.pligg.com/modules-sale/17885-tweet-automatic-twitter-submissions-5.html#post106993';
	$module_info['settings_url'] = '../module.php?module=tweet';
	$module_info['update_url'] = 'http://forums.pligg.com/versioncheck.php?product=tweet';

	$module_info['db_add_field'][]=array(table_prefix . 'links', 'tweet_id', 'VARCHAR',  32, "", 0, '0');
?>