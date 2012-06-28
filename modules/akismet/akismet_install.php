<?php
	$module_info['name'] = 'Akismet';
	$module_info['desc'] = 'Akismet Anti-Spam Module';
	$module_info['version'] = 0.6;
	$module_info['settings_url'] = '../module.php?module=akismet';
	//$module_info['db_add_field'][]=array(table_prefix . 'links', 'akismet', 'TINYINT',  3, "UNSIGNED", 0, '0');
	
	$module_info['db_add_table'][]=array(
	'name' => table_prefix . "spam_comments",
	'sql' => "CREATE TABLE ".table_prefix . "spam_comments (
	  `auto_id` int(20) NOT NULL auto_increment,
	  `userid` int(20) NOT NULL default '0',
	  `linkid` int(20) NOT NULL default '0',
	  `cmt_rand` int(20) NOT NULL default '0',
	  `cmt_content` text collate latin1_general_ci NOT NULL,
	  `cmt_date` timestamp NOT NULL default CURRENT_TIMESTAMP,
	  `cmt_parent` int(20) NOT NULL default '0',
		PRIMARY KEY  (`auto_id`)
		) ENGINE=MyISAM ");

	$module_info['db_add_table'][]=array(
	'name' => table_prefix . "spam_links",
	'sql' => "CREATE TABLE ".table_prefix . "spam_links (
	  `auto_id` int(20) NOT NULL auto_increment,
	  `userid` int(20) NOT NULL default '0',
	  `linkid` int(20) NOT NULL default '0',
		PRIMARY KEY  (`auto_id`)
		) ENGINE=MyISAM ");

	$module_info['db_sql'][] = "INSERT INTO ".table_widgets." (`name`, `version`, `latest_version`, `folder`, `enabled`, `column`, `position`, `display`) VALUES ('Akismet', 0.1, 0, 'akismet', 1, 'right', 7, '')";

?>
