<?php
	$module_info['name'] = 'Dropbox Backup';
	$module_info['desc'] = 'This module allows you to send backups of your site to your Dropbox account.';
	$module_info['version'] = 1.0;
	$module_info['settings_url'] = '../module.php?module=dropbox_backup';

	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('dropbox_backup_email','')";
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('dropbox_backup_pass','')";
	//$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('dropbox_backup_save','Yes')";
	$module_info['db_sql'][] =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('dropbox_backup_dir','/Pligg')";

?>