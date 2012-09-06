<?php
	$module_info['name'] = 'Sidebar Comments';
	$module_info['desc'] = 'Displays the most recent comments in the sidebar';
	$module_info['version'] = 2.0;
	$module_info['db_sql'][] = "INSERT INTO `" . table_block . "` ( `name` , `callback_tpl`, `enabled`, `region`, `weight`, `module` ) VALUES ('Sidebar Comments', 'widget_sidebar_comments',1,'',5,'sidebar_comments')";

?>