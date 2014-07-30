<?php
include_once (dirname(__FILE__) . '/../libs/db.php');

if (!isset($dblang)) { $dblang='en'; }

function pligg_createtables($conn) {

	global $dblang;

	$sql = 'DROP TABLE IF EXISTS `' . table_categories . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_categories . "` (
	  `category__auto_id` int(11) NOT NULL auto_increment,
	  `category_lang` varchar(" . strlen($dblang) . ") collate utf8_general_ci NOT NULL default " . "'" . $dblang . "',
	  `category_id` int(11) NOT NULL default '0',
	  `category_parent` int(11) NOT NULL default '0',
	  `category_name` varchar(64) collate utf8_general_ci NOT NULL default '',
	  `category_safe_name` varchar(64) collate utf8_general_ci NOT NULL default '',
	  `rgt` int(11) NOT NULL default '0',
	  `lft` int(11) NOT NULL default '0',
	  `category_enabled` int(11) NOT NULL default '1',
	  `category_order` int(11) NOT NULL default '0',
	  `category_desc` varchar(255) collate utf8_general_ci NOT NULL,
	  `category_keywords` varchar(255) collate utf8_general_ci NOT NULL,
	  `category_author_level` enum('normal','moderator','admin') collate utf8_general_ci NOT NULL default 'normal',
	  `category_author_group` varchar(255) NOT NULL default '',
	  `category_votes` varchar(4) NOT NULL default '',
	  `category_karma` varchar(4) NOT NULL default '',
	  PRIMARY KEY  (`category__auto_id`),
	  KEY `category_id` (`category_id`),
	  KEY `category_parent` (`category_parent`),
	  KEY `category_safe_name` (`category_safe_name`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'categories\'...<br />';
	mysql_query( $sql, $conn );


	$sql = 'DROP TABLE IF EXISTS `' . table_comments . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_comments . "` (
	  `comment_id` int(20) NOT NULL auto_increment,
	  `comment_randkey` int(11) NOT NULL default '0',
	  `comment_parent` int(20) default '0',
	  `comment_link_id` int(20) NOT NULL default '0',
	  `comment_user_id` int(20) NOT NULL default '0',
	  `comment_date` datetime NOT NULL,
	  `comment_karma` smallint(6) NOT NULL default '0',
	  `comment_content` text collate utf8_general_ci NOT NULL,
	  `comment_votes` int(20) NOT NULL default '0',
	  `comment_status` enum('discard','moderated','published','spam') collate utf8_general_ci NOT NULL default 'published',
	  PRIMARY KEY  (`comment_id`),
	  UNIQUE KEY `comments_randkey` (`comment_randkey`,`comment_link_id`,`comment_user_id`,`comment_parent`),
	  KEY `comment_link_id` (`comment_link_id`, `comment_parent`, `comment_date`),
	  KEY `comment_link_id_2` (`comment_link_id`,`comment_date`),
	  KEY `comment_date` (`comment_date`),
	  KEY `comment_parent` (`comment_parent`,`comment_date`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'comments\'...<br />';
	mysql_query( $sql, $conn );

	$sql = 'DROP TABLE IF EXISTS `' . table_friends . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_friends . "` (
	  `friend_id` int(11) NOT NULL auto_increment,
	  `friend_from` bigint(20) NOT NULL default '0',
	  `friend_to` bigint(20) NOT NULL default '0',
	  PRIMARY KEY  (`friend_id`),
	  UNIQUE KEY `friends_from_to` (`friend_from`,`friend_to`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'friends\'...<br />';
	mysql_query( $sql, $conn );


	$sql = 'DROP TABLE IF EXISTS `' . table_links . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_links . "` (
	  `link_id` int(20) NOT NULL auto_increment,
	  `link_author` int(20) NOT NULL default '0',
	  `link_status` enum('discard','new','published','abuse','duplicate','page','spam') collate utf8_general_ci NOT NULL default 'discard',
	  `link_randkey` int(20) NOT NULL default '0',
	  `link_votes` int(20) NOT NULL default '0',
	  `link_reports` int(20) NOT NULL default '0',
	  `link_comments` int(20) NOT NULL default '0',
	  `link_karma` decimal(10,2) NOT NULL default '0.00',
	  `link_modified` timestamp NOT NULL,
	  `link_date` timestamp NOT NULL,
	  `link_published_date` timestamp NOT NULL,
	  `link_category` int(11) NOT NULL default '0',
	  `link_lang` int(11) NOT NULL default '1',
	  `link_url` varchar(200) collate utf8_general_ci NOT NULL default '',
	  `link_url_title` text collate utf8_general_ci,
	  `link_title` text collate utf8_general_ci NOT NULL,
	  `link_title_url` varchar(255) collate utf8_general_ci default NULL,
	  `link_content` mediumtext collate utf8_general_ci NOT NULL,
	  `link_summary` text collate utf8_general_ci,
	  `link_tags` text collate utf8_general_ci,
	  `link_field1` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field2` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field3` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field4` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field5` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field6` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field7` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field8` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field9` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field10` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field11` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field12` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field13` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field14` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_field15` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `link_group_id` int(20) NOT NULL default '0',
	  `link_group_status` enum(  'new',  'published',  'discard' ) DEFAULT 'new' NOT NULL,
	  `link_out` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`link_id`),
	  KEY `link_author` (`link_author`),
	  KEY `link_url` (`link_url`),
	  KEY `link_status` (`link_status`),
	  KEY `link_title_url` (`link_title_url`),
	  KEY `link_date` (`link_date`),
	  KEY `link_published_date` (`link_published_date`),
	  FULLTEXT KEY `link_url_2` (`link_url`,`link_url_title`,`link_title`,`link_content`,`link_tags`),
	  FULLTEXT KEY `link_tags` (`link_tags`),
	  FULLTEXT KEY `link_search` (`link_title`,`link_content`,`link_tags`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'links\'...<br />';
	mysql_query( $sql, $conn );

	$sql = 'DROP TABLE IF EXISTS `' . table_trackbacks . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_trackbacks . "` (
	  `trackback_id` int(10) unsigned NOT NULL auto_increment,
	  `trackback_link_id` int(11) NOT NULL default '0',
	  `trackback_user_id` int(11) NOT NULL default '0',
	  `trackback_type` enum('in','out') NOT NULL default 'in',
	  `trackback_status` enum('ok','pendent','error') NOT NULL default 'pendent',
	  `trackback_modified` timestamp NOT NULL,
	  `trackback_date` timestamp NULL default NULL,
	  `trackback_url` varchar(200) collate utf8_general_ci NOT NULL default '',
	  `trackback_title` text collate utf8_general_ci,
	  `trackback_content` text collate utf8_general_ci,
	  PRIMARY KEY  (`trackback_id`),
	  UNIQUE KEY `trackback_link_id_2` (`trackback_link_id`,`trackback_type`,`trackback_url`),
	  KEY `trackback_link_id` (`trackback_link_id`),
	  KEY `trackback_url` (`trackback_url`),
	  KEY `trackback_date` (`trackback_date`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'trackbacks\'...<br />';
	mysql_query( $sql, $conn );


	$sql = 'DROP TABLE IF EXISTS `' . table_users . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_users . "` (
	  `user_id` int(20) NOT NULL auto_increment,
	  `user_login` varchar(32) collate utf8_general_ci NOT NULL default '',
	  `user_level` enum('normal','moderator','admin','Spammer') collate utf8_general_ci NOT NULL default 'normal',
	  `user_modification` timestamp NOT NULL,
	  `user_date` timestamp NOT NULL,
	  `user_pass` varchar(64) collate utf8_general_ci NOT NULL default '',
	  `user_email` varchar(128) collate utf8_general_ci NOT NULL default '',
	  `user_names` varchar(128) collate utf8_general_ci NOT NULL default '',
	  `user_karma` decimal(10,2) default '0.00',
	  `user_url` varchar(128) collate utf8_general_ci NOT NULL default '',
	  `user_lastlogin` timestamp NOT NULL,
	  `user_facebook` varchar(64) collate utf8_general_ci NOT NULL default '',
	  `user_twitter` varchar(64) collate utf8_general_ci NOT NULL default '',
	  `user_linkedin` varchar(64) collate utf8_general_ci NOT NULL default '',
	  `user_googleplus` varchar(64) collate utf8_general_ci NOT NULL default '',
	  `user_skype` varchar(64) collate utf8_general_ci NOT NULL default '',
	  `user_pinterest` varchar(64) collate utf8_general_ci NOT NULL default '',
	  `public_email` varchar(64) collate utf8_general_ci NOT NULL default '',
	  `user_avatar_source` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `user_ip` varchar(20) collate utf8_general_ci default '0',
	  `user_lastip` varchar(20) collate utf8_general_ci default '0',
	  `last_reset_request` timestamp NOT NULL,
	  `last_reset_code` varchar(255) collate utf8_general_ci default NULL,
	  `user_location` varchar(255) collate utf8_general_ci default NULL,
	  `user_occupation` varchar(255) collate utf8_general_ci default NULL,
	  `user_categories` VARCHAR(255) collate utf8_general_ci NOT NULL default '',
	  `user_enabled` tinyint(1) NOT NULL default '1',
	  `user_language` varchar(32) collate utf8_general_ci default NULL,
	  PRIMARY KEY  (`user_id`),
	  UNIQUE KEY `user_login` (`user_login`),
	  KEY `user_email` (`user_email`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'users\'...<br />';
	mysql_query( $sql, $conn );

	$sql = 'DROP TABLE IF EXISTS `' . table_tags . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_tags . "` (
	  `tag_link_id` int(11) NOT NULL default '0',
	  `tag_lang` varchar(4) collate utf8_general_ci NOT NULL default 'en',
	  `tag_date` timestamp NOT NULL,
	  `tag_words` varchar(64) collate utf8_general_ci NOT NULL default '',
	  UNIQUE KEY `tag_link_id` (`tag_link_id`,`tag_lang`,`tag_words`),
	  KEY `tag_lang` (`tag_lang`,`tag_date`),
	  KEY `tag_words` (`tag_words`,`tag_link_id`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'tags\'...<br />';
	mysql_query( $sql, $conn );


	$sql = 'DROP TABLE IF EXISTS `' . table_votes . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_votes . "` (
	  `vote_id` int(20) NOT NULL auto_increment,
	  `vote_type` enum('links','comments') NOT NULL default 'links',
	  `vote_date` timestamp NOT NULL,
	  `vote_link_id` int(20) NOT NULL default '0',
	  `vote_user_id` int(20) NOT NULL default '0',
	  `vote_value` smallint(11) NOT NULL default '1',
	  `vote_karma` int(11) NULL default '0',
	  `vote_ip` varchar(64) default NULL,
	  PRIMARY KEY  (`vote_id`),
	  KEY `user_id` (`vote_user_id`),
	  KEY `link_id` (`vote_link_id`),
	  KEY `vote_type` (`vote_type`,`vote_link_id`,`vote_user_id`,`vote_ip`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'votes\'...<br />';
	mysql_query( $sql, $conn );

	$sql = 'DROP TABLE IF EXISTS `' . table_pageviews . '`;';
	mysql_query( $sql, $conn );

	$sql = 'DROP TABLE IF EXISTS `' . table_config . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_config . "` (
	  `var_id` int(11) NOT NULL auto_increment,
	  `var_page` varchar(50) collate utf8_general_ci NOT NULL,
	  `var_name` varchar(100) collate utf8_general_ci NOT NULL,
	  `var_value` varchar(255) collate utf8_general_ci NOT NULL,
	  `var_defaultvalue` varchar(50) collate utf8_general_ci NOT NULL,
	  `var_optiontext` varchar(200) collate utf8_general_ci NOT NULL,
	  `var_title` varchar(200) collate utf8_general_ci NOT NULL,
	  `var_desc` text collate utf8_general_ci NOT NULL,
	  `var_method` varchar(10) collate utf8_general_ci NOT NULL,
	  `var_enclosein` varchar(5) collate utf8_general_ci default NULL,
	  PRIMARY KEY  (`var_id`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'config\'....<BR/>';
	mysql_query( $sql, $conn );


	$sql = 'DROP TABLE IF EXISTS `' . table_messages . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" .table_messages. "` (
	  `idMsg` int(11) NOT NULL auto_increment,
	  `title` varchar(255) collate utf8_general_ci NOT NULL default '',
	  `body` text NOT NULL,
	  `sender` int(11) NOT NULL default '0',
	  `receiver` int(11) NOT NULL default '0',
	  `senderLevel` int(11) NOT NULL default '0',
	  `readed` int(11) NOT NULL default '0',
	  `date` timestamp NOT NULL,
	  PRIMARY KEY  (`idMsg`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'messages\'....<BR/>';
	mysql_query( $sql, $conn );


	$sql = 'DROP TABLE IF EXISTS `' . table_modules . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_modules . "` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(50) collate utf8_general_ci NOT NULL,
	  `version` float NOT NULL,
	  `latest_version` float NOT NULL,
	  `folder` varchar(50) collate utf8_general_ci NOT NULL,
	  `enabled` tinyint(1) NOT NULL,
	  `weight` INT NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'modules\'....<BR/>';
	mysql_query( $sql, $conn );


	$sql = 'DROP TABLE IF EXISTS `' . table_formulas . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_formulas . "` (
	  `id` int(11) NOT NULL auto_increment,
	  `type` varchar(10) collate utf8_general_ci NOT NULL,
	  `enabled` tinyint(1) NOT NULL,
	  `title` varchar(50) collate utf8_general_ci NOT NULL,
	  `formula` text collate utf8_general_ci NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'formulas\'....<BR/>';
	mysql_query( $sql, $conn );


	$sql = 'DROP TABLE IF EXISTS `' . table_saved_links . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_saved_links ."` (
	  `saved_id` int(11) NOT NULL auto_increment,
	  `saved_user_id` int(11) NOT NULL,
	  `saved_link_id` int(11) NOT NULL,
	  `saved_privacy` ENUM( 'private', 'public' ) collate utf8_general_ci NOT NULL default 'public',
	  PRIMARY KEY  (`saved_id`),
	  KEY `saved_user_id` (  `saved_user_id` )
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'Saved Links\'....<br />';
	mysql_query( $sql, $conn );

	$sql = 'DROP TABLE IF EXISTS `' . table_old_urls . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_old_urls ."` (
	  `old_id` int(11) NOT NULL auto_increment,
	  `old_link_id` int(11) NOT NULL,
	  `old_title_url` varchar(255) collate utf8_general_ci NOT NULL,
	  PRIMARY KEY  (`old_id`),
	  KEY `old_title_url` (  `old_title_url` )
	) ENGINE = MyISAM;";
//	echo 'Creating table: \'Old Links\'....<br />';
	mysql_query( $sql, $conn );

	$sql = 'DROP TABLE IF EXISTS `' . table_misc_data . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_misc_data . "` (
		`name` VARCHAR( 20 ) collate utf8_general_ci NOT NULL ,
		`data` TEXT collate utf8_general_ci NOT NULL ,
		PRIMARY KEY ( `name` )
		) ENGINE = MyISAM;";
//	echo 'Creating table: \'Misc Data\'....<br />';
	mysql_query( $sql, $conn );

	////////////////////////////////////////////////////////////////////////////
	//groups upgrade code inserting table
	//group table
	$sql = 'DROP TABLE IF EXISTS `' . table_groups . '`;';
	mysql_query( $sql, $conn );
		$sql = "CREATE TABLE `".table_groups."` (
	  `group_id` int(20) NOT NULL auto_increment,
	  `group_creator` int(20) NOT NULL,
	  `group_status` enum('Enable','disable') collate utf8_general_ci NOT NULL,
	  `group_members` int(20) NOT NULL,
	  `group_date` datetime NOT NULL,
	  `group_safename` text collate utf8_general_ci NOT NULL,
	  `group_name` text collate utf8_general_ci NOT NULL,
	  `group_description` text collate utf8_general_ci NOT NULL,
	  `group_privacy` enum('private','public','restricted') collate utf8_general_ci NOT NULL,
	  `group_avatar` varchar(255) collate utf8_general_ci NOT NULL,
	  `group_vote_to_publish` int(20) NOT NULL,
	  `group_field1` varchar(255) collate utf8_general_ci NOT NULL,
	  `group_field2` varchar(255) collate utf8_general_ci NOT NULL,
	  `group_field3` varchar(255) collate utf8_general_ci NOT NULL,
	  `group_field4` varchar(255) collate utf8_general_ci NOT NULL,
	  `group_field5` varchar(255) collate utf8_general_ci NOT NULL,
	  `group_field6` varchar(255) collate utf8_general_ci NOT NULL,
	`group_notify_email` tinyint(1) NOT NULL,
		PRIMARY KEY  (`group_id`),
		KEY `group_name` (`group_name`(100)),
		KEY `group_creator` (`group_creator`, `group_status`)
		);";
//	echo 'Creating table: \'groups\'....<br />';
	mysql_query( $sql, $conn );

	//group member table
	$sql = 'DROP TABLE IF EXISTS `' . table_group_member . '`;';
	mysql_query( $sql, $conn );
	$sql = "CREATE TABLE `".table_group_member."` (
		`member_id` INT( 20 ) NOT NULL auto_increment,
		`member_user_id` INT( 20 ) NOT NULL ,
		`member_group_id` INT( 20 ) NOT NULL ,
		`member_role` ENUM( 'admin', 'normal', 'moderator', 'flagged', 'banned' ) collate utf8_general_ci NOT NULL,
		`member_status` ENUM( 'active', 'inactive') collate utf8_general_ci NOT NULL,
		PRIMARY KEY  (`member_id`),
		KEY `user_group` (`member_group_id`, `member_user_id`)
		);";

	mysql_query( $sql, $conn );
//	echo 'Creating table: \'group members\'....<br />';
	//group shared table
	$sql = 'DROP TABLE IF EXISTS `' . table_group_shared . '`;';
	mysql_query( $sql, $conn );
	$sql = "CREATE TABLE `".table_group_shared."` (
		`share_id` INT( 20 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`share_link_id` INT( 20 ) NOT NULL ,
		`share_group_id` INT( 20 ) NOT NULL ,
		`share_user_id` INT( 20 ) NOT NULL,
		UNIQUE KEY `share_group_id` (`share_group_id`,`share_link_id`));";

//	echo 'Creating table: \'group shared\'....<br />';
	mysql_query( $sql, $conn );


//	echo 'Creating table: \'login_attempts\'....<br />';
	$sql = 'DROP TABLE IF EXISTS `' . table_login_attempts . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `". table_login_attempts ."` (
		  `login_id` int(11) NOT NULL auto_increment,
		  `login_username` varchar(100) collate utf8_general_ci default NULL,
		  `login_time` datetime NOT NULL,
		  `login_ip` varchar(100) collate utf8_general_ci default NULL,
		  `login_count` int(11) NOT NULL default '0',
		  PRIMARY KEY  (`login_id`),
		  UNIQUE KEY `login_username` (`login_ip`,`login_username`)
	) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
	mysql_query( $sql, $conn );
			

//	echo 'Creating table: \'widgets\'....<br />';
	$sql = 'DROP TABLE IF EXISTS `' . table_widgets . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `".table_widgets."` (
		  `id` int(11) NOT NULL auto_increment,
		  `name` varchar(50) collate utf8_general_ci default NULL,
		  `version` float NOT NULL,
		  `latest_version` float NOT NULL,
		  `folder` varchar(50) collate utf8_general_ci default NULL,
		  `enabled` tinyint(1) NOT NULL,
		  `column` enum('left','right') collate utf8_general_ci NOT NULL,
		  `position` int(11) NOT NULL,
		  `display` char(5) collate utf8_general_ci NOT NULL,
		  PRIMARY KEY  (`id`),
		  UNIQUE KEY `folder` (`folder`)
	) ENGINE =MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
	mysql_query( $sql, $conn );
			

	///////////////////////////////////////////////////////////////////////////

	echo '<li>Setting Pligg Version</li>';
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('pligg_version', '2.0.2');";
	mysql_query( $sql, $conn );
	
	echo '<li>Setting Captcha Method to SolveMedia</li>';
	$sql = "UPDATE `" . table_misc_data . "` SET `data` = 'solvemedia' WHERE `pligg_misc_data`.`name` = 'captcha_method';";
	mysql_query($sql,$conn);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('adcopy_lang', 'en');";
	mysql_query($sql,$conn);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('adcopy_theme', 'white');";
	mysql_query($sql,$conn);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('adcopy_pubkey', 'KLoj-jfX2UP0GEYOmYX.NOWL0ReUhErZ');";
	mysql_query($sql,$conn);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('adcopy_privkey', 'Dm.c-mjmNP7Fhz-hKOpNz8l.NAMGp0wO');";
	mysql_query($sql,$conn);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('adcopy_hashkey', 'nePptHN4rt.-UVLPFScpSuddqdtFdu2N');";
	mysql_query($sql,$conn);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('captcha_method', 'solvemedia');";
	mysql_query($sql,$conn);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('reCaptcha_pubkey', '6LfwKQQAAAAAAPFCNozXDIaf8GobTb7LCKQw54EA');";
	mysql_query($sql,$conn);
	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('reCaptcha_prikey', '6LfwKQQAAAAAALQosKUrE4MepD0_kW7dgDZLR5P1');";
	mysql_query($sql,$conn);

	//register validation//
	$randkey = '';
	for ($i=0; $i<32; $i++)
		$randkey .= chr(rand(48,200));

	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('hash', '$randkey');";
	mysql_query( $sql, $conn );

	$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('validate', 0);";
	mysql_query( $sql, $conn );
	//
	$sql = 'DROP TABLE IF EXISTS `' . table_totals . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_totals . "` (
		`name` varchar(10) NOT NULL,
		`total` int(11) NOT NULL,
		PRIMARY KEY  (`name`)
		) ENGINE = MyISAM;";

//	echo 'Creating table: \'Totals\'....<br />';
	mysql_query( $sql, $conn );

	$sql = 'DROP TABLE IF EXISTS `' . table_tag_cache . '`;';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_tag_cache . "` (
		  `tag_words` varchar(64) NOT NULL,
		  `count` int(11) NOT NULL
		) ENGINE =MyISAM";

//	echo 'Creating table: \'Tag cache\'....<br />';
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_redirects . "` (
	  `redirect_id` int(11) NOT NULL auto_increment,
	  `redirect_old` varchar(255) NOT NULL,
	  `redirect_new` varchar(255) NOT NULL,
	  PRIMARY KEY  (`redirect_id`),
	  KEY `redirect_old` (`redirect_old`)
		) ENGINE = MyISAM;";
	mysql_query( $sql, $conn );

	$sql = "CREATE TABLE `" . table_additional_categories . "` (
	  `ac_link_id` int(11) NOT NULL,
	  `ac_cat_id` int(11) NOT NULL,
	  UNIQUE KEY `ac_link_id` (`ac_link_id`,`ac_cat_id`)
	) ENGINE=MyISAM;";
	mysql_query( $sql, $conn );

//	echo '<li>Inserting default "All" and "News" categories</li>';
	$sql = "INSERT INTO `" . table_categories . "` (`category__auto_id`, `category_lang`, `category_id`, `category_parent`, `category_name`, `category_safe_name`, `rgt`, `lft`, `category_enabled`, `category_order`, `category_desc`, `category_keywords`, `category_author_level`, `category_author_group`, `category_votes`) VALUES (0, '" . $dblang . "', 0, 0, 'all', 'all', 3, 0, 2, 0, '', '', 'normal', '', '');";
	mysql_query( $sql, $conn );
	$sql = "UPDATE `" . table_categories . "` SET `category__auto_id` = '0' WHERE `category_name` = 'all' LIMIT 1;";
	mysql_query( $sql, $conn );
	$sql = "INSERT INTO `" . table_categories . "` (`category__auto_id`, `category_lang`, `category_id`, `category_parent`, `category_name`, `category_safe_name`, `rgt`, `lft`, `category_enabled`, `category_order`, `category_desc`, `category_keywords`, `category_author_level`, `category_author_group`, `category_votes`) VALUES (1, '" . $dblang . "', 1, 0, 'News', 'News', 2, 1, 1, 0, '', '', 'normal', '', '');";
	mysql_query( $sql, $conn );

	echo '<li>Adding default modules</li>';
	$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (NULL, 'Admin Modify Language', 2.1, '', 'admin_language', 1);";
	mysql_query( $sql, $conn );
	$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (NULL, 'Captcha', 2.4, '', 'captcha', 1);";
	mysql_query( $sql, $conn );
	$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (NULL, 'Simple Private Messaging', 2.3, '', 'simple_messaging', 1);";
	mysql_query( $sql, $conn );
	$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (NULL, 'Sidebar Stories', 2.0, '', 'sidebar_stories', 1);";
	mysql_query( $sql, $conn );
	$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (NULL, 'Sidebar Comments', 2.0, '', 'sidebar_comments', 1);";
	mysql_query( $sql, $conn );
	$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (NULL, 'Karma module', 0.2, '', 'karma', 1);";
	mysql_query( $sql, $conn );

	$sql =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_submit_story','+15')";
	mysql_query( $sql, $conn );
	$sql =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_submit_comment','+10')";
	mysql_query( $sql, $conn );
	$sql =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_story_publish','+50')";
	mysql_query( $sql, $conn );
	$sql =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_story_vote','+1')";
	mysql_query( $sql, $conn );
	$sql =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_comment_vote','0')";
	mysql_query( $sql, $conn );
	$sql =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_story_discard','-250')";
	mysql_query( $sql, $conn );
	$sql =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_story_spam','-10000')";
	mysql_query( $sql, $conn );
	$sql =  "INSERT  into " . table_misc_data . " (name,data) VALUES ('karma_comment_delete','-50')";
	mysql_query( $sql, $conn );

	echo '<li>Adding default widgets</li>';
	$sql = "INSERT INTO `".table_widgets."` VALUES (NULL, 'Admin Panel Tools', 0.1, 0, 'panel_tools', 1, 'left', 4, '')";
	mysql_query( $sql, $conn );
	$sql = "INSERT INTO `".table_widgets."` VALUES (NULL, 'Statistics', 0.2, 0, 'statistics', 1, 'left', 1, '')";
	mysql_query( $sql, $conn );
	$sql = "INSERT INTO `".table_widgets."` VALUES (NULL, 'Pligg CMS', 1.0, 0, 'pligg_cms', 1, 'right', 5, '')";
	mysql_query( $sql, $conn );
	$sql = "INSERT INTO `".table_widgets."` VALUES (NULL, 'Pligg News', 0.1, 0, 'pligg_news', 1, 'right', 6, '')";
	mysql_query( $sql, $conn );
//	$sql = "INSERT INTO `".table_widgets."` VALUES (NULL, 'New products', 0.1, 0, 'new_products', 1, 'left', 2, '')";
//	mysql_query( $sql, $conn );

//	echo '<li>Inserting default formulas</li>';
	$sql = 'INSERT INTO `' . table_formulas . '` (`id`, `type`, `enabled`, `title`, `formula`) VALUES (1, \'report\', 1, \'Simple Story Reporting\', \'$reports > $votes * 3\');';
	mysql_query( $sql, $conn );

//	echo "Adding default 'totals' data</li>";
	$sql = "insert into `" . table_totals . "` (`name`, `total`) values ('published', 0);";
	mysql_query( $sql, $conn );
	$sql = "insert into `" . table_totals . "` (`name`, `total`) values ('new', 0);";	
	mysql_query( $sql, $conn );
	$sql = "insert into `" . table_totals . "` (`name`, `total`) values ('discard', 0);";	
	mysql_query( $sql, $conn );

	echo '<li>Creating About Page</li>';
	$sql = "INSERT INTO `" . table_links . "`  (`link_id`, `link_author`, `link_status`, `link_randkey`, `link_votes`, `link_reports`, `link_comments`, `link_karma`, `link_modified`, `link_date`, `link_published_date`, `link_category`, `link_lang`, `link_url`, `link_url_title`, `link_title`, `link_title_url`, `link_content`, `link_summary`, `link_tags`, `link_field1`, `link_field2`, `link_field3`, `link_field4`, `link_field5`, `link_field6`, `link_field7`, `link_field8`, `link_field9`, `link_field10`, `link_field11`, `link_field12`, `link_field13`, `link_field14`, `link_field15`, `link_group_id`, `link_out`) VALUES (1, 1, 'page', 0, 0, 0, 0, '0.00', '2005-12-17 00:00:00', '2005-12-17 00:00:00', '0000-00-00 00:00:00', 0, 1, '', NULL, 'About', 'about', '<legend><strong>About Us</strong></legend>\r\n<p>Our site allows you to submit an article that will be voted on by other members. The most popular posts will be published to the front page, while the less popular articles are left in an 'New' page permanently. This site is dependant on user contributed content and votes to determine the direction of the site.</p>\r\n', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0);";
	mysql_query( $sql, $conn );

//	print "<li>Converting tables to UTF-8</li>";
	$stmts = "ALTER TABLE  `pligg_categories` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_comments` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_config` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_formulas` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_friends` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_group_member` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_group_shared` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_groups` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_links` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_messages` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_misc_data` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_modules` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_redirects` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_saved_links` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_tag_cache` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_tags` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_totals` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_trackbacks` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_users` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
		ALTER TABLE  `pligg_votes` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_categories` 
		CHANGE  `category_lang`  `category_lang` VARCHAR( 2 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT  'en',
		CHANGE  `category_name`  `category_name` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `category_safe_name`  `category_safe_name` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `category_desc`  `category_desc` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `category_keywords`  `category_keywords` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `category_author_group`  `category_author_group` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_comments` CHANGE  `comment_content`  `comment_content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_config` CHANGE  `var_page`  `var_page` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `var_name`  `var_name` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `var_value`  `var_value` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `var_defaultvalue`  `var_defaultvalue` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `var_optiontext`  `var_optiontext` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `var_title`  `var_title` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `var_desc`  `var_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `var_method`  `var_method` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `var_enclosein`  `var_enclosein` VARCHAR( 5 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;

		ALTER TABLE  `pligg_formulas` CHANGE  `type`  `type` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `title`  `title` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `formula`  `formula` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_groups`
		CHANGE  `group_safename`  `group_safename` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `group_name`  `group_name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `group_description`  `group_description` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `group_privacy`  `group_privacy` ENUM(  'private',  'public',  'restricted' ) ,
		CHANGE  `group_avatar`  `group_avatar` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `group_field1`  `group_field1` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `group_field2`  `group_field2` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `group_field3`  `group_field3` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `group_field4`  `group_field4` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `group_field5`  `group_field5` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `group_field6`  `group_field6` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_links` CHANGE  `link_url`  `link_url` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_url_title`  `link_url_title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
		CHANGE  `link_title`  `link_title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_title_url`  `link_title_url` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
		CHANGE  `link_content`  `link_content` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_summary`  `link_summary` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
		CHANGE  `link_tags`  `link_tags` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
		CHANGE  `link_field1`  `link_field1` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field2`  `link_field2` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field3`  `link_field3` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field4`  `link_field4` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field5`  `link_field5` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field6`  `link_field6` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field7`  `link_field7` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field8`  `link_field8` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field9`  `link_field9` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field10`  `link_field10` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field11`  `link_field11` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field12`  `link_field12` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field13`  `link_field13` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field14`  `link_field14` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `link_field15`  `link_field15` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_messages` CHANGE  `title`  `title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `body`  `body` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_misc_data` CHANGE  `name`  `name` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `data`  `data` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_modules` CHANGE  `name`  `name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `folder`  `folder` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_redirects` CHANGE  `redirect_old`  `redirect_old` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `redirect_new`  `redirect_new` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_tag_cache` CHANGE  `tag_words`  `tag_words` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_tags` CHANGE  `tag_lang`  `tag_lang` VARCHAR( 4 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT  'en',
		CHANGE  `tag_words`  `tag_words` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_totals` CHANGE  `name`  `name` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci;

		ALTER TABLE  `pligg_trackbacks` CHANGE  `trackback_type`  `trackback_type` ENUM(  'in',  'out' ) DEFAULT  'in',
		CHANGE  `trackback_status`  `trackback_status` ENUM(  'ok',  'pendent',  'error' ) DEFAULT  'pendent',
		CHANGE  `trackback_url`  `trackback_url` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `trackback_title`  `trackback_title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
		CHANGE  `trackback_content`  `trackback_content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL;

		ALTER TABLE  `pligg_users` CHANGE  `user_login`  `user_login` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_level`  `user_level` ENUM(  'normal',  'moderator',  'admin', 'Spammer' ) DEFAULT  'normal',
		CHANGE  `user_pass`  `user_pass` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_email`  `user_email` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_names`  `user_names` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_url`  `user_url` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_facebook`  `user_facebook` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_twitter`  `user_twitter` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_linkedin`  `user_linkedin` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_googleplus`  `user_googleplus` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_skype`  `user_skype` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_pinterest`  `user_pinterest` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `public_email`  `public_email` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_avatar_source`  `user_avatar_source` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci,
		CHANGE  `user_ip`  `user_ip` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT  '0',
		CHANGE  `user_lastip`  `user_lastip` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT  '0',
		CHANGE  `last_reset_code`  `last_reset_code` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
		CHANGE  `user_location`  `user_location` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
		CHANGE  `user_occupation`  `user_occupation` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL ,
		CHANGE  `user_categories`  `user_categories` VARCHAR( 1024 ) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT  '';";
	
	$stmts = explode("\n", $stmts);
	
	foreach($stmts as $stmt) {
	  $stmt = str_replace("`pligg_", "`".table_prefix, $stmt);
  	  mysql_query($stmt);
	}

	$stmts = explode("\n", file_get_contents(dirname(__FILE__) . '/install_config_table.sql'));
	foreach($stmts as $stmt) {
		if (trim($stmt))
		{
			$stmt = str_replace("INSERT INTO `config`", "INSERT INTO `".table_config."`", $stmt);
			$stmt = str_replace("'table_prefix', 'pligg_'", "'table_prefix', '" . table_prefix . "'", $stmt);
			mysql_query($stmt);
			if (mysql_error())
			{
				print htmlentities($stmt);
				print mysql_error();
				exit;
			}
		}
	}
	
	mysql_query("INSERT INTO `" . table_config . "` ( `var_id` , `var_page` , `var_name` , `var_value` , `var_defaultvalue` , `var_optiontext` , `var_title` , `var_desc` , `var_method` , `var_enclosein` )VALUES (NULL, 'Misc', '\$language', '{$_SESSION['language']}', 'english', 'text', 'Site Language', 'Site Language', 'normal', '\'');");
	mysql_query("INSERT INTO `" . table_config . "` ( `var_id` , `var_page` , `var_name` , `var_value` , `var_defaultvalue` , `var_optiontext` , `var_title` , `var_desc` , `var_method` , `var_enclosein` )VALUES (NULL, 'Misc', 'user_language', '0', '0', '1 = yes / 0 = no', 'Select Language', 'Allow users to change Pligg language', 'normal', '\'');");
	
	return 1;
}

?>