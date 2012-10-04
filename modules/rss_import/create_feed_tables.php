<?php
	include_once('config.php');
	global $db;
	
	$sql = 'DROP TABLE IF EXISTS `' . table_prefix . 'feed_import_fields`;';
	$db->query($sql);	
	
	$sql = "CREATE TABLE `" . table_prefix . "feed_import_fields` (
	  `id` int(11) NOT NULL auto_increment,
	  `field_name` varchar(255) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ";
	echo 'Creating table: \'feed_import_fields\'....<br />';
	$db->query($sql);	
	
	
	
	$sql = 'DROP TABLE IF EXISTS `' . table_prefix . 'feed_link`;';
	$db->query($sql);	
	
	$sql = "CREATE TABLE `" . table_prefix . "feed_link` (
	  `feed_link_id` int(11) NOT NULL auto_increment,
	  `feed_id` int(11) NOT NULL,
	  `feed_field` varchar(255) NOT NULL,
	  `pligg_field` varchar(255) NOT NULL,
	  PRIMARY KEY  (`feed_link_id`)
	) ";
	echo 'Creating table: \'feed_link\'....<br />';
	$db->query($sql);	
	
	
	
	$sql = 'DROP TABLE IF EXISTS `' . table_prefix . 'feeds`;';
	$db->query($sql);	
	
	$sql = "CREATE TABLE `" . table_prefix . "feeds` (
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
	  `feed_status` varchar(255) NOT NULL default 'queued',
	  `feed_last_check` timestamp NOT NULL,
	  `feed_random_vote_enable` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '0',
	  `feed_random_vote_min` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '5',
	  `feed_random_vote_max` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '20',
	  `feed_last_item_first` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '1',
	  PRIMARY KEY  (`feed_id`)
	) ";
	echo 'Creating table: \'feeds\'....<br />';
	$db->query($sql);	
	
	
	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('1','link_url');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('2','link_title');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('3','link_content');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('4','link_tags');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('5','link_field1');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('6','link_field2');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('7','link_field3');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('8','link_field4');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('9','link_field5');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('10','link_field6');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('11','link_field7');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('12','link_field8');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('13','link_field9');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('14','link_field10');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('15','link_field11');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('16','link_field12');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('17','link_field13');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('18','link_field14');";
	$db->query($sql);	
	$sql = "Insert into `" . table_prefix . "feed_import_fields` (`id`,`field_name`) values ('19','link_field15');";
	$db->query($sql);	

?>
<hr />
Finished creating tables.
