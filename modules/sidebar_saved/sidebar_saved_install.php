<?php
	$module_info['name'] = 'Sidebar Saved';
	$module_info['desc'] = 'Displays recently saved stories in the sidebar.';
	$module_info['version'] = 2.0;
	
	$module_info['db_sql'][] = "INSERT INTO `" . table_block . "` ( `name` , `callback_tpl`, `enabled`, `region`, `weight`, `module` ) VALUES ('Sidebar Saved', 'widget_sidebar_saved',1,'',4,'sidebar_saved')";
?>
