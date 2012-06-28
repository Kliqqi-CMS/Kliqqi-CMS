<?php
	$module_info['name'] = 'Admin Snippets';
	$module_info['desc'] = 'Allows the god users to edit templates easily by inserting code through a module';
	$module_info['version'] = 1.00;
	$module_info['update_url'] = 'http://forums.pligg.com/versioncheck.php?product=snippets';
	$module_info['homepage_url'] = 'http://forums.pligg.com/pligg-modules/16306-admin-snippets.html';
	$module_info['settings_url'] = '../module.php?module=admin_snippet';
	
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
