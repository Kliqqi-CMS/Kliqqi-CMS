<?php
	$module_info['name'] = 'RSS Importer';
	$module_info['desc'] = 'Import RSS Feeds as Posts';
	$module_info['version'] = 2.0;
	$module_info['settings_url'] = '../module.php?module=rss_import';
    $module_info['requires'][] = array('PHP', 5);
        
	$module_info['db_add_table'][]=array(
		'name' => table_prefix . "feed_import_fields",
		'sql' => "CREATE TABLE `" . table_prefix . "feed_import_fields` (
	  `id` int(11) NOT NULL auto_increment,
	  `field_name` varchar(255) NOT NULL,
	  PRIMARY KEY  (`id`)
	) TYPE = MyISAM;");

	$module_info['db_add_table'][]=array(
		'name' => table_prefix . "feed_link",
		'sql' => "CREATE TABLE `" . table_prefix . "feed_link` (
	  `feed_link_id` int(11) NOT NULL auto_increment,
	  `feed_id` int(11) NOT NULL,
	  `feed_field` varchar(255) NOT NULL,
	  `pligg_field` varchar(255) NOT NULL,
	  PRIMARY KEY  (`feed_link_id`)
	) TYPE = MyISAM;");

	$module_info['db_add_table'][]=array(
		'name' => table_prefix . "feeds",
		'sql' => "CREATE TABLE `" . table_prefix . "feeds` (
	  `feed_id` int(11) NOT NULL auto_increment,
	  `feed_name` varchar(255) NOT NULL,
	  `feed_url` varchar(255) NOT NULL,
	  `feed_freq_hours` int(11) NOT NULL default '12',
	  `feed_votes` int(11) NOT NULL default '1',
	  `feed_submitter` int(11) NOT NULL default '1',
	  `feed_item_limit` int(11) NOT NULL default '1',
	  `feed_category` int(11) NOT NULL default '1',
	  `feed_url_dupe` int(11) NOT NULL default '0',
	  `feed_title_dupe` int(11) NOT NULL default '0',
	  `feed_status` varchar(255) NOT NULL default 'new',
	  `feed_last_check` timestamp NOT NULL,
	  `feed_random_vote_enable` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0',
	  `feed_random_vote_min` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '5',
	  `feed_random_vote_max` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '20',
	  `feed_last_item_first` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '1',
	  PRIMARY KEY  (`feed_id`)
	) TYPE = MyISAM;");

	// the 'on duplicate' is just a cheap hack to prevent any errors if the
	// module is 'installed' more than once.
	// prevents -- Warning: Duplicate entry '1' for key 1 -- and so on
	$module_info['db_sql'][] = "DELETE FROM `" . table_prefix . "feed_import_fields`;";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('1','link_url');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('2','link_title');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('3','link_content');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('4','link_tags');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('5','link_field1');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('6','link_field2');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('7','link_field3');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('8','link_field4');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('9','link_field5');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('10','link_field6');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('11','link_field7');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('12','link_field8');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('13','link_field9');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('14','link_field10');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('15','link_field11');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('16','link_field12');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('17','link_field13');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('18','link_field14');";
	$module_info['db_sql'][] = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('19','link_field15');";

  
?>
