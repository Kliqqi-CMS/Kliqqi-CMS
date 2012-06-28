<?php
	$module_info['name'] = 'Upload';
	$module_info['desc'] = 'Allows you to attach images and files to an article';
	$module_info['version'] = 1.10;
	$module_info['update_url'] = 'http://forums.pligg.com/versioncheck.php?product=upload';
	$module_info['homepage_url'] = 'http://forums.pligg.com/pligg-modules/17484-upload-module-file-image-attachment.html';
	$module_info['settings_url'] = '../module.php?module=upload';
	// this is where you set the modules "name" and "version" that is required
	// if more that one module is required then just make a copy of that line

	$module_info['db_add_table'][]=array(
	'name' => table_prefix . "files",
	'sql' => "CREATE TABLE `".table_prefix . "files` (
	  `file_id` int(11) NOT NULL auto_increment,
	  `file_name` varchar(255) default NULL,
	  `file_size` varchar(20) default NULL,
	  `file_user_id` int(11) NOT NULL,
	  `file_link_id` int(11) NOT NULL,
	  `file_orig_id` int(11) NOT NULL,
	  `file_real_size` int(11) NOT NULL,
	  `file_number` tinyint(4) NOT NULL,
	  `file_ispicture` tinyint(4) NOT NULL,
	  PRIMARY KEY  (`file_id`)
	) ENGINE=MyISAM ");

	// these are seperate because most people will have the tables already
	// created from a previous install
	$module_info['db_add_field'][]=array(table_prefix . 'files', 'file_fields', 'TEXT',  '', '', 0, '');
	$module_info['db_add_field'][]=array(table_prefix . 'files', 'file_hide_thumb', 'TINYINT',  1, "UNSIGNED", 0, '0');
	$module_info['db_add_field'][]=array(table_prefix . 'files', 'file_hide_file', 'TINYINT',  1, "UNSIGNED", 0, '0');

	if (get_misc_data('upload_thumb')=='')
	{
		misc_data_update('upload_thumb', '1');
		misc_data_update('upload_sizes', 'a:1:{i:0;s:7:"200x200";}');
		misc_data_update('upload_display', 'a:1:{s:7:"150x150";s:1:"1";}');
		misc_data_update('upload_fields', 'YTowOnt9');
		misc_data_update('upload_alternates', 'YToxOntpOjE7czowOiIiO30=');
		misc_data_update('upload_mandatory', 'a:0:{}');
		misc_data_update('upload_place', 'tpl_link_summary_pre_story_content');
		misc_data_update('upload_external', 'file,url');
		misc_data_update('upload_link', 'orig');
		misc_data_update('upload_quality', '80');
		misc_data_update('upload_directory', '/modules/upload/attachments');
		misc_data_update('upload_thdirectory', '/modules/upload/attachments/thumbs');
		misc_data_update('upload_filesize', '200');
		misc_data_update('upload_maxnumber', '1');
		misc_data_update('upload_extensions', 'jpg jpeg png gif');
		misc_data_update('upload_defsize', '200x200');
		misc_data_update('upload_fileplace', 'tpl_pligg_story_who_voted_start');
	}

?>
