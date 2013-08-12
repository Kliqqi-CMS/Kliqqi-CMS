<?php
	$module_info['name'] = 'Admin Snippets';
	$module_info['desc'] = 'Easily insert code into your template file through module hooks. A great way to add analytics or advertisements.';
	$module_info['version'] = 1.1;
	$module_info['settings_url'] = '../module.php?module=admin_snippet';
	$module_info['homepage_url'] = 'http://pligg.com/downloads/module/admin-snippet/';
	$module_info['update_url'] = 'http://pligg.com/downloads/module/admin-snippet/version/';
	
	$module_info['db_add_table'][]=array(
	'name' => table_prefix . "snippets",
	'sql' => "CREATE TABLE `".table_prefix . "snippets` (
	  `snippet_id` int(11) NOT NULL auto_increment,
	  `snippet_name` varchar(255) default NULL,
	  `snippet_location` varchar(255) NOT NULL,
	  `snippet_updated` datetime NOT NULL,
	  `snippet_order` int(11) NOT NULL,
	  `snippet_content` text,
	  PRIMARY KEY  (`snippet_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8");
?>
