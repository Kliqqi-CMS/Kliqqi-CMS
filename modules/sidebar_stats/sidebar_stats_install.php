<?php
	$module_info['name'] = 'Sidebar Statistics';
	$module_info['desc'] = 'Adds a sidebar area filled with statistics pulled from your website.';
	$module_info['version'] = 2.0;
	$module_info['update_url'] = 'http://forums.pligg.com/versioncheck.php?product=sidebar_stats';
	$module_info['homepage_url'] = 'http://forums.pligg.com/free-modules/14821-yankidanks-sidebar-stats.html';
	
	$module_info['db_sql'][] = "INSERT INTO `" . table_block . "` ( `name` , `callback_tpl`, `enabled`, `region`, `weight`, `module` ) VALUES ('Sidebar Stats', 'widget_sidebar_stats',1,'',2,'sidebar_stats')";

?>
