<?php
	$module_info['name'] = 'Ticket';
	$module_info['desc'] = 'Label stories as Accepted, Rejected, Cannot Reproduce, or Completed. Adds a tag to each story to make the ticket searchable.';
	$module_info['version'] = 1.0;
	$module_info['homepage_url'] = 'http://pligg.com/downloads/module/ticket/';
	$module_info['update_url'] = 'http://pligg.com/downloads/module/ticket/version/';

	$module_info['db_sql'][] =  "ALTER TABLE " . table_links . " ADD `ticket_status` VARCHAR( 20 ) NOT NULL ";

?>
