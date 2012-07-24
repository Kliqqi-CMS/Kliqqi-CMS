<?php
include_once (dirname(__FILE__) . '/../libs/db.php');

if (!isset($dblang)) { $dblang='en'; }

function pligg_createtables($conn) {

global $dblang;

$sql = 'DROP TABLE IF EXISTS `' . table_categories . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_categories . "` (
  `category__auto_id` int(11) NOT NULL auto_increment,
  `category_lang` varchar(" . strlen($dblang) . ") NOT NULL default " . "'" . $dblang . "',
  `category_id` int(11) NOT NULL default '0',
  `category_parent` int(11) NOT NULL default '0',
  `category_name` varchar(64) NOT NULL default '',
  `category_safe_name` varchar(64) NOT NULL default '',
  `rgt` int(11) NOT NULL default '0',
  `lft` int(11) NOT NULL default '0',
  `category_enabled` int(11) NOT NULL default '1',
  `category_order` int(11) NOT NULL default '0',
  `category_desc` varchar(255) NOT NULL,
  `category_keywords` varchar(255) NOT NULL,
  `category_author_level` enum('normal','moderator','admin') NOT NULL default 'normal',
  `category_author_group` varchar(255) NOT NULL default '',
  `category_votes` varchar(4) NOT NULL default '',
  `category_karma` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`category__auto_id`),
  KEY `category_id` (`category_id`),
  KEY `category_parent` (`category_parent`),
  KEY `category_safe_name` (`category_safe_name`)
) ENGINE = MyISAM;";
echo 'Creating table: \'categories\'...<br />';
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
  `comment_content` text NOT NULL,
  `comment_votes` int(20) NOT NULL default '0',
  `comment_status` enum('discard','moderated','published','spam') NOT NULL default 'published',
  PRIMARY KEY  (`comment_id`),
  UNIQUE KEY `comments_randkey` (`comment_randkey`,`comment_link_id`,`comment_user_id`,`comment_parent`),
  KEY `comment_link_id` (`comment_link_id`, `comment_parent`, `comment_date`),
  KEY `comment_link_id_2` (`comment_link_id`,`comment_date`),
  KEY `comment_date` (`comment_date`),
  KEY `comment_parent` (`comment_parent`,`comment_date`)
) ENGINE = MyISAM;";
echo 'Creating table: \'comments\'...<br />';
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
echo 'Creating table: \'friends\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_links . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_links . "` (
  `link_id` int(20) NOT NULL auto_increment,
  `link_author` int(20) NOT NULL default '0',
  `link_status` enum('discard','queued','published','abuse','duplicated','page','spam') NOT NULL default 'discard',
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
  `link_url` varchar(200) NOT NULL default '',
  `link_url_title` text,
  `link_title` text NOT NULL,
  `link_title_url` varchar(255) default NULL,
  `link_content` mediumtext NOT NULL,
  `link_summary` text,
  `link_tags` text,
  `link_field1` varchar(255) NOT NULL default '',
  `link_field2` varchar(255) NOT NULL default '',
  `link_field3` varchar(255) NOT NULL default '',
  `link_field4` varchar(255) NOT NULL default '',
  `link_field5` varchar(255) NOT NULL default '',
  `link_field6` varchar(255) NOT NULL default '',
  `link_field7` varchar(255) NOT NULL default '',
  `link_field8` varchar(255) NOT NULL default '',
  `link_field9` varchar(255) NOT NULL default '',
  `link_field10` varchar(255) NOT NULL default '',
  `link_field11` varchar(255) NOT NULL default '',
  `link_field12` varchar(255) NOT NULL default '',
  `link_field13` varchar(255) NOT NULL default '',
  `link_field14` varchar(255) NOT NULL default '',
  `link_field15` varchar(255) NOT NULL default '',
  `link_group_id` int(20) NOT NULL default '0',
  `link_group_status` enum(  'queued',  'published',  'discard' ) DEFAULT 'queued' NOT NULL,
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
echo 'Creating table: \'links\'...<br />';
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
  `trackback_url` varchar(200) NOT NULL default '',
  `trackback_title` text,
  `trackback_content` text,
  PRIMARY KEY  (`trackback_id`),
  UNIQUE KEY `trackback_link_id_2` (`trackback_link_id`,`trackback_type`,`trackback_url`),
  KEY `trackback_link_id` (`trackback_link_id`),
  KEY `trackback_url` (`trackback_url`),
  KEY `trackback_date` (`trackback_date`)
) ENGINE = MyISAM;";
echo 'Creating table: \'trackbacks\'...<br />';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_users . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_users . "` (
  `user_id` int(20) NOT NULL auto_increment,
  `user_login` varchar(32) NOT NULL default '',
  `user_level` enum('normal','admin','admin','Spammer') NOT NULL default 'normal',
  `user_modification` timestamp NOT NULL,
  `user_date` timestamp NOT NULL,
  `user_pass` varchar(64) NOT NULL default '',
  `user_email` varchar(128) NOT NULL default '',
  `user_names` varchar(128) NOT NULL default '',
  `user_karma` decimal(10,2) default '0.00',
  `user_url` varchar(128) NOT NULL default '',
  `user_lastlogin` timestamp NOT NULL,
  `user_aim` varchar(64) NOT NULL default '',
  `user_msn` varchar(64) NOT NULL default '',
  `user_yahoo` varchar(64) NOT NULL default '',
  `user_gtalk` varchar(64) NOT NULL default '',
  `user_skype` varchar(64) NOT NULL default '',
  `user_irc` varchar(64) NOT NULL default '',
  `public_email` varchar(64) NOT NULL default '',
  `user_avatar_source` varchar(255) NOT NULL default '',
  `user_ip` varchar(20) default '0',
  `user_lastip` varchar(20) default '0',
  `last_reset_request` timestamp NOT NULL,
  `last_reset_code` varchar(255) default NULL,
  `user_location` varchar(255) default NULL,
  `user_occupation` varchar(255) default NULL,
  `user_categories` VARCHAR(255) NOT NULL default '',
  `user_enabled` tinyint(1) NOT NULL default '1',
  `user_language` varchar(32) default NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_login` (`user_login`),
  KEY `user_email` (`user_email`)
) ENGINE = MyISAM;";
echo 'Creating table: \'users\'...<br />';
mysql_query( $sql, $conn );

$sql = 'DROP TABLE IF EXISTS `' . table_tags . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_tags . "` (
  `tag_link_id` int(11) NOT NULL default '0',
  `tag_lang` varchar(4) NOT NULL default 'en',
  `tag_date` timestamp NOT NULL,
  `tag_words` varchar(64) NOT NULL default '',
  UNIQUE KEY `tag_link_id` (`tag_link_id`,`tag_lang`,`tag_words`),
  KEY `tag_lang` (`tag_lang`,`tag_date`),
  KEY `tag_words` (`tag_words`,`tag_link_id`)
) ENGINE = MyISAM;";
echo 'Creating table: \'tags\'...<br />';
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
echo 'Creating table: \'votes\'...<br />';
mysql_query( $sql, $conn );

$sql = 'DROP TABLE IF EXISTS `' . table_pageviews . '`;';
mysql_query( $sql, $conn );

$sql = 'DROP TABLE IF EXISTS `' . table_config . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_config . "` (
  `var_id` int(11) NOT NULL auto_increment,
  `var_page` varchar(50) NOT NULL,
  `var_name` varchar(100) NOT NULL,
  `var_value` varchar(255) NOT NULL,
  `var_defaultvalue` varchar(50) NOT NULL,
  `var_optiontext` varchar(200) NOT NULL,
  `var_title` varchar(200) NOT NULL,
  `var_desc` text NOT NULL,
  `var_method` varchar(10) NOT NULL,
  `var_enclosein` varchar(5) default NULL,
  PRIMARY KEY  (`var_id`)
) ENGINE = MyISAM;";
echo 'Creating table: \'config\'....<BR/>';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_messages . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" .table_messages. "` (
  `idMsg` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `body` text NOT NULL,
  `sender` int(11) NOT NULL default '0',
  `receiver` int(11) NOT NULL default '0',
  `senderLevel` int(11) NOT NULL default '0',
  `readed` int(11) NOT NULL default '0',
  `date` timestamp NOT NULL,
  PRIMARY KEY  (`idMsg`)
) ENGINE = MyISAM;";
echo 'Creating table: \'messages\'....<BR/>';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_modules . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_modules . "` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `version` float NOT NULL,
  `latest_version` float NOT NULL,
  `folder` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE = MyISAM;";
echo 'Creating table: \'modules\'....<BR/>';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_formulas . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_formulas . "` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(10) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `title` varchar(50) NOT NULL,
  `formula` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE = MyISAM;";
echo 'Creating table: \'formulas\'....<BR/>';
mysql_query( $sql, $conn );


$sql = 'DROP TABLE IF EXISTS `' . table_saved_links . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_saved_links ."` (
  `saved_id` int(11) NOT NULL auto_increment,
  `saved_user_id` int(11) NOT NULL,
  `saved_link_id` int(11) NOT NULL,
  `saved_privacy` ENUM( 'private', 'public' ) NOT NULL default 'public',
  PRIMARY KEY  (`saved_id`),
  KEY `saved_user_id` (  `saved_user_id` )
) ENGINE = MyISAM;";
echo 'Creating table: \'Saved Links\'....<br />';
mysql_query( $sql, $conn );

$sql = 'DROP TABLE IF EXISTS `' . table_old_urls . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_old_urls ."` (
  `old_id` int(11) NOT NULL auto_increment,
  `old_link_id` int(11) NOT NULL,
  `old_title_url` varchar(255) NOT NULL,
  PRIMARY KEY  (`old_id`),
  KEY `old_title_url` (  `old_title_url` )
) ENGINE = MyISAM;";
echo 'Creating table: \'Old Links\'....<br />';
mysql_query( $sql, $conn );

$sql = 'DROP TABLE IF EXISTS `' . table_misc_data . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_misc_data . "` (
	`name` VARCHAR( 20 ) NOT NULL ,
	`data` TEXT NOT NULL ,
	PRIMARY KEY ( `name` )
	) ENGINE = MyISAM;";
echo 'Creating table: \'Misc Data\'....<br />';
mysql_query( $sql, $conn );

////////////////////////////////////////////////////////////////////////////
//groups upgrade code inserting table
//group table
$sql = 'DROP TABLE IF EXISTS `' . table_groups . '`;';
mysql_query( $sql, $conn );
	$sql = "CREATE TABLE `".table_groups."` (
  `group_id` int(20) NOT NULL auto_increment,
  `group_creator` int(20) NOT NULL,
  `group_status` enum('Enable','disable') collate utf8_unicode_ci NOT NULL,
  `group_members` int(20) NOT NULL,
  `group_date` datetime NOT NULL,
  `group_safename` text collate utf8_unicode_ci NOT NULL,
  `group_name` text collate utf8_unicode_ci NOT NULL,
  `group_description` text collate utf8_unicode_ci NOT NULL,
  `group_privacy` enum('private','public','restricted') collate utf8_unicode_ci NOT NULL,
  `group_avatar` varchar(255) collate utf8_unicode_ci NOT NULL,
  `group_vote_to_publish` int(20) NOT NULL,
  `group_field1` varchar(255) collate utf8_unicode_ci NOT NULL,
  `group_field2` varchar(255) collate utf8_unicode_ci NOT NULL,
  `group_field3` varchar(255) collate utf8_unicode_ci NOT NULL,
  `group_field4` varchar(255) collate utf8_unicode_ci NOT NULL,
  `group_field5` varchar(255) collate utf8_unicode_ci NOT NULL,
  `group_field6` varchar(255) collate utf8_unicode_ci NOT NULL,
`group_notify_email` tinyint(1) NOT NULL,
	PRIMARY KEY  (`group_id`),
	KEY `group_name` (`group_name`(100)),
	KEY `group_creator` (`group_creator`, `group_status`)
	);";
echo 'Creating table: \'groups\'....<br />';
mysql_query( $sql, $conn );

//group member table
$sql = 'DROP TABLE IF EXISTS `' . table_group_member . '`;';
mysql_query( $sql, $conn );
$sql = "CREATE TABLE `".table_group_member."` (
	`member_id` INT( 20 ) NOT NULL auto_increment,
	`member_user_id` INT( 20 ) NOT NULL ,
	`member_group_id` INT( 20 ) NOT NULL ,
	`member_role` ENUM( 'admin', 'moderator', 'admin', 'flagged', 'banned' ) NOT NULL,
	`member_status` ENUM( 'active', 'inactive') NOT NULL,
	PRIMARY KEY  (`member_id`),
	KEY `user_group` (`member_group_id`, `member_user_id`)
	);";

mysql_query( $sql, $conn );
echo 'Creating table: \'group members\'....<br />';
//group shared table
$sql = 'DROP TABLE IF EXISTS `' . table_group_shared . '`;';
mysql_query( $sql, $conn );
$sql = "CREATE TABLE `".table_group_shared."` (
	`share_id` INT( 20 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`share_link_id` INT( 20 ) NOT NULL ,
	`share_group_id` INT( 20 ) NOT NULL ,
	`share_user_id` INT( 20 ) NOT NULL,
	UNIQUE KEY `share_group_id` (`share_group_id`,`share_link_id`));";

echo 'Creating table: \'group shared\'....<br />';
mysql_query( $sql, $conn );


echo 'Creating table: \'login_attempts\'....<br />';
$sql = 'DROP TABLE IF EXISTS `' . table_login_attempts . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `". table_login_attempts ."` (
	  `login_id` int(11) NOT NULL auto_increment,
	  `login_username` varchar(100) collate utf8_unicode_ci default NULL,
	  `login_time` datetime NOT NULL,
	  `login_ip` varchar(100) collate utf8_unicode_ci default NULL,
	  `login_count` int(11) NOT NULL default '0',
	  PRIMARY KEY  (`login_id`),
	  UNIQUE KEY `login_username` (`login_ip`,`login_username`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
mysql_query( $sql, $conn );
        

echo 'Creating table: \'widgets\'....<br />';
$sql = 'DROP TABLE IF EXISTS `' . table_widgets . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `".table_widgets."` (
	  `id` int(11) NOT NULL auto_increment,
	  `name` varchar(50) collate utf8_unicode_ci default NULL,
	  `version` float NOT NULL,
	  `latest_version` float NOT NULL,
	  `folder` varchar(50) collate utf8_unicode_ci default NULL,
	  `enabled` tinyint(1) NOT NULL,
	  `column` enum('left','right') collate utf8_unicode_ci NOT NULL,
	  `position` int(11) NOT NULL,
	  `display` char(5) collate utf8_unicode_ci NOT NULL,
	  PRIMARY KEY  (`id`),
  	  UNIQUE KEY `folder` (`folder`)
) ENGINE =MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
mysql_query( $sql, $conn );
        

///////////////////////////////////////////////////////////////////////////

$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('pligg_version', '2.0.0');";
mysql_query( $sql, $conn );
//Captcha Upgrade:
$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('captcha_method', 'reCaptcha');";
mysql_query($sql,$conn);
$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('reCaptcha_pubkey', '6LfwKQQAAAAAAPFCNozXDIaf8GobTb7LCKQw54EA');";
mysql_query($sql,$conn);
$sql = "INSERT INTO `" . table_misc_data . "` ( `name` , `data` ) VALUES ('reCaptcha_prikey', '6LfwKQQAAAAAALQosKUrE4MepD0_kW7dgDZLR5P1');";
mysql_query($sql,$conn);
//
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

echo 'Creating table: \'Totals\'....<br />';
mysql_query( $sql, $conn );

$sql = 'DROP TABLE IF EXISTS `' . table_tag_cache . '`;';
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `" . table_tag_cache . "` (
	  `tag_words` varchar(64) NOT NULL,
	  `count` int(11) NOT NULL
	) ENGINE =MyISAM";

echo 'Creating table: \'Tag cache\'....<br />';
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


echo 'Inserting default category...<br />';
$sql = "INSERT INTO `" . table_categories . "` (`category__auto_id`, `category_lang`, `category_id`, `category_parent`, `category_name`, `category_safe_name`, `rgt`, `lft`, `category_enabled`, `category_order`, `category_desc`, `category_keywords`, `category_author_level`, `category_author_group`, `category_votes`) VALUES (0, '" . $dblang . "', 0, 0, 'all', 'all', 3, 0, 2, 0, '', '', 'normal', '', '');";
mysql_query( $sql, $conn );

$sql = "UPDATE `" . table_categories . "` SET `category__auto_id` = '0' WHERE `category_name` = 'all' LIMIT 1;";
mysql_query( $sql, $conn );

$sql = "INSERT INTO `" . table_categories . "` (`category__auto_id`, `category_lang`, `category_id`, `category_parent`, `category_name`, `category_safe_name`, `rgt`, `lft`, `category_enabled`, `category_order`, `category_desc`, `category_keywords`, `category_author_level`, `category_author_group`, `category_votes`) VALUES (1, '" . $dblang . "', 1, 0, 'News', 'News', 2, 1, 1, 0, '', '', 'normal', '', '');";
mysql_query( $sql, $conn );

echo 'Inserting default modules...<br />';
$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (2, 'Admin Modify Language', 0.2, '', 'admin_language', 1);";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (3, 'Captcha', 1.0, '', 'captcha', 1);";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (4, 'Admin Help English', 0.3, '', 'admin_help_english', 1);";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (5, 'Hello World', 0.3, '', 'hello_world', 1);";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (6, 'Simple Private Messaging', 0.7, '', 'simple_messaging', 1);";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (7, 'Sidebar Top Today', 0.3, '', 'sidebar_stories_u', 1);";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (8, 'Sidebar Stories', 0.3, '', 'sidebar_stories', 1);";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (9, 'Sidebar Comments', 0.3, '', 'sidebar_comments', 1);";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (NULL, 'Karma module', 0.1, '', 'karma', 1);";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `" . table_modules . "` (`id`, `name`, `version`, `latest_version`, `folder`, `enabled`) VALUES (NULL, 'Status', 1.2, '', 'status', 1);";
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

$sql = "ALTER TABLE ".table_users." ADD  `status_switch` TINYINT(1) DEFAULT '1'";
mysql_query( $sql, $conn );
$sql = "ALTER TABLE ".table_users." ADD  `status_friends` TINYINT(1) DEFAULT '1'";
mysql_query( $sql, $conn );
$sql = "ALTER TABLE ".table_users." ADD  `status_story` TINYINT(1) DEFAULT '1'";
mysql_query( $sql, $conn );
$sql = "ALTER TABLE ".table_users." ADD  `status_comment` TINYINT(1) DEFAULT '1'";
mysql_query( $sql, $conn );
$sql = "ALTER TABLE ".table_users." ADD  `status_email` TINYINT(1) DEFAULT '1'";
mysql_query( $sql, $conn );
$sql = "ALTER TABLE ".table_users." ADD  `status_group` TINYINT(1) DEFAULT '1'";
mysql_query( $sql, $conn );
$sql = "ALTER TABLE ".table_users." ADD  `status_all_friends` TINYINT(1) DEFAULT '1'";
mysql_query( $sql, $conn );
$sql = "ALTER TABLE ".table_users." ADD  `status_friend_list` TEXT";
mysql_query( $sql, $conn );
$sql = "ALTER TABLE ".table_users." ADD  `status_excludes` TEXT";
mysql_query( $sql, $conn );
$sql = "UPDATE ".table_users." SET status_switch=1, status_friends=1, status_story=1, status_comment=1, status_email=1, status_all_friends=1";
mysql_query( $sql, $conn );

$sql = "CREATE TABLE `".table_prefix . "updates` (
	  `update_id` int(11) NOT NULL auto_increment,
	  `update_time` int(11) default NULL,
	  `update_type` char(1) NOT NULL,
	  `update_link_id` int(11) NOT NULL,
	  `update_user_id` int(11) NOT NULL,
	  `update_group_id` int(11) NOT NULL,
	  `update_likes` int(11) NOT NULL,
	  `update_level` varchar(25),
	  `update_text` text NOT NULL,
	  PRIMARY KEY  (`update_id`),
	  FULLTEXT KEY `update_text` (`update_text`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
mysql_query( $sql, $conn );
	
$sql = "CREATE TABLE `".table_prefix . "likes` (
	  `like_update_id` int(11) NOT NULL,
	  `like_user_id` int(11) NOT NULL,
	  PRIMARY KEY  (`like_update_id`, `like_user_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
mysql_query( $sql, $conn );
	
$sql =  "INSERT  into " . table_misc_data . " (name,data) VALUES 
('status_switch', '0'),
('status_show_permalin', '1'),
('status_permalinks', '1'),
('status_inputonother', '1'),
('status_place', 'tpl_pligg_profile_info_end'),
('status_clock', '12'),
('status_results', '10'),
('status_max_chars', '1200'),
('status_avatar', 'small'),
('status_profile_level', 'admin,moderator,normal'),
('status_level', 'admin,moderator,normal'),
('status_user_email', '1'),
('status_user_comment', '1'),
('status_user_story', '1'),
('status_user_friends', '1'),
('status_user_switch', '1')";
mysql_query( $sql, $conn );

echo 'Inserting default widgets...<br />';
$sql = "INSERT INTO `".table_widgets."` VALUES (1, 'Admin Panel Tools', 0.1, 0, 'panel_tools', 1, 'left', 4, '')";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `".table_widgets."` VALUES (3, 'Statistics', 0.1, 0, 'statistics', 1, 'left', 1, '')";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `".table_widgets."` VALUES (4, 'Pligg CMS', 0.1, 0, 'pligg_cms', 1, 'right', 5, '')";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `".table_widgets."` VALUES (5, 'Pligg News', 0.1, 0, 'pligg_news', 1, 'right', 6, '')";
mysql_query( $sql, $conn );
$sql = "INSERT INTO `".table_widgets."` VALUES (6, 'New products', 0.1, 0, 'new_products', 1, 'left', 2, '')";
mysql_query( $sql, $conn );


echo 'Inserting default formulas...<br />';
$sql = 'INSERT INTO `' . table_formulas . '` (`id`, `type`, `enabled`, `title`, `formula`) VALUES (1, \'report\', 1, \'Simple Story Reporting\', \'$reports > $votes * 3\');';
mysql_query( $sql, $conn );

echo "Inserting default 'totals' data...<br />";
	$sql = "insert into `" . table_totals . "` (`name`, `total`) values ('published', 0);";
	mysql_query( $sql, $conn );
	
	$sql = "insert into `" . table_totals . "` (`name`, `total`) values ('queued', 0);";	
	mysql_query( $sql, $conn );

	$sql = "insert into `" . table_totals . "` (`name`, `total`) values ('discard', 0);";	
	mysql_query( $sql, $conn );

echo "Inserting default 'config' data...<br />";

$sql = "INSERT INTO `" . table_links . "`  (`link_id`, `link_author`, `link_status`, `link_randkey`, `link_votes`, `link_reports`, `link_comments`, `link_karma`, `link_modified`, `link_date`, `link_published_date`, `link_category`, `link_lang`, `link_url`, `link_url_title`, `link_title`, `link_title_url`, `link_content`, `link_summary`, `link_tags`, `link_field1`, `link_field2`, `link_field3`, `link_field4`, `link_field5`, `link_field6`, `link_field7`, `link_field8`, `link_field9`, `link_field10`, `link_field11`, `link_field12`, `link_field13`, `link_field14`, `link_field15`, `link_group_id`, `link_out`) VALUES (1, 1, 'page', 0, 0, 0, 0, '0.00', '2009-05-14 00:00:00', '2009-05-14 00:00:00', '0000-00-00 00:00:00', 0, 1, '', NULL, 'About', 'about', '<legend><strong>About Pligg</strong></legend>\r\n<p><strong>Pligg,</strong> originally named Meneame, is a web application that allows you to submit an article that will be reviewed by all and will be promoted, based on popularity, to the main page. When a user submits a news article it will be placed in the unpublished area until it gains sufficient votes to be promoted to the main page. The original source for Pligg was authored by Ricardo Galli. He was influenced by the extremely popular English technology site Digg.com.</p>\r\n<legend>Terms and Conditions</legend>\r\n<ol>\r\n<li> <strong>Description of Service.</strong> Pligg is a free, online application from Pligg (the Service). You understand and agree that the Service is provided on an AS IS and AS AVAILABLE basis. Pligg disclaims all responsibility and liability for the availability, timeliness, security or reliability of the Service. Pligg also reserves the right to modify, suspend or discontinue the Service with or without notice at any time and without any liability to you. </li>\r\n<li> <strong>Personal Use.</strong> The Service is made available to you for your personal use only. Due to the Childrens Online Privacy Protection Act of 1998 (which is available at http://www.ftc.gov/ogc/coppa1.htm), you must be at least thirteen (13) years of age to use this Service. You must provide current, accurate identification, contact, and other information that may be required as part of the registration process and/or continued use of the Service. You are responsible for maintaining the confidentiality of your Service password and account, and are responsible for all activities that occur thereunder. Pligg reserves the right to refuse service to anyone at any time without notice for any reason. </li>\r\n<li> <strong>Proper Use.</strong> You agree that you are responsible for your own communications and for any consequences thereof. Your use of the Service is subject to your acceptance of and compliance with the Agreement. You agree that you will use the Service in compliance with all applicable local, state, national, and international laws, rules and regulations, including any laws regarding the transmission of technical data exported from your country of residence. You shall not, shall not agree to, and shall not authorize or encourage any third party to: (i) use the Service to upload, transmit or otherwise distribute any content that is unlawful, defamatory, harassing, abusive, fraudulent, obscene, contains viruses, or is otherwise objectionable as reasonably determined by Pligg; (ii) upload, transmit or otherwise distribute content that infringes upon another partys intellectual property rights or other proprietary, contractual or fiduciary rights or obligations; (iii) prevent others from using the Service; (iv) use the Service for any fraudulent or inappropriate purpose; or (v) act in any way that violates the Program Policies, as may be revised from time to time. Violation of any of the foregoing may result in immediate termination of this Agreement, and may subject you to state and federal penalties and other legal consequences. Pligg reserves the right, but shall have no obligation, to investigate your use of the Service in order to determine whether a violation of the Agreement has occurred or to comply with any applicable law, regulation, legal process or governmental request. </li>\r\n<li> <strong>Your Intellectual Property Rights</strong> Pligg does not claim any ownership in any of the content, including any text, data, information, images, photographs, music, sound, video, or other material, that you upload, transmit or store in your Pligg account. We will not use any of your content for any purpose except to provide you with the Service. </li>\r\n<li> <strong>Representations and Warranties.</strong> You represent and warrant that (a) all of the information provided by you to Pligg to participate in the Services is correct and current; and (b) you have all necessary right, power and authority to enter into this Agreement and to perform the acts required of you hereunder. </li>\r\n<li> <strong>Privacy.</strong> As a condition to using the Service, you agree to the terms of the Pligg Privacy Policy as it may be updated from time to time. Pligg understands that privacy is important to you. You do, however, agree that Pligg may monitor, edit or disclose your personal information, including the content of your emails, if required to do so in order to comply with any valid legal process or governmental request (such as a search warrant, subpoena, statute, or court order), or as otherwise provided in these Terms of Use and the Pligg Privacy Policy. Personal information collected by Pligg may be stored and processed in the United States or any other country in which parent company Pligg LLC or its agents maintain facilities. By using Pligg, you consent to any such transfer of information outside of your country. </li>\r\n<li> <strong>Indemnification.</strong> You agree to hold harmless and indemnify Pligg, and its subsidiaries, affiliates, officers, agents, and employees from and against any third party claim arising from or in any way related to your use of the Service, including any liability or expense arising from all claims, losses, damages (actual and consequential), suits, judgments, litigation costs and attorney fees, of every kind and nature. In such a case, Pligg will provide you with written notice of such claim, suit or action. </li>\r\n</ol>\r\n<legend>AFFERO GENERAL PUBLIC LICENSE</legend>\r\n<p>Version 1, March 2002<br /> <br /> Copyright &copy; 2002 Affero Inc.<br /> 510 Third Street - Suite 225, San Francisco, CA 94107, USA</p>\r\n<p>This license is a modified version of the GNU General Public License copyright (C) 1989, 1991 Free Software Foundation, Inc. made with their permission. Section 2(d) has been added to cover use of software over a computer network.<br /> <br /> Everyone is permitted to copy and distribute verbatim copies of this license document, but changing it is not allowed.<br /> <br /> Preamble<br /> <br /> The licenses for most software are designed to take away your freedom to share and change it. By contrast, the Affero General Public License is intended to guarantee your freedom to share and change free software--to make sure the software is free for all its users. This Public License applies to most of Afferos software and to any other program whose authors commit to using it. (Some other Affero software is covered by the GNU Library General Public License instead.) You can apply it to your programs, too.<br /> <br /> When we speak of free software, we are referring to freedom, not price. This General Public License is designed to make sure that you have the freedom to distribute copies of free software (and charge for this service if you wish), that you receive source code or can get it if you want it, that you can change the software or use pieces of it in new free programs; and that you know you can do these things.<br /> <br /> To protect your rights, we need to make restrictions that forbid anyone to deny you these rights or to ask you to surrender the rights. These restrictions translate to certain responsibilities for you if you distribute copies of the software, or if you modify it.<br /> <br /> For example, if you distribute copies of such a program, whether gratis or for a fee, you must give the recipients all the rights that you have. You must make sure that they, too, receive or can get the source code. And you must show them these terms so they know their rights.<br /> <br /> We protect your rights with two steps: (1) copyright the software, and (2) offer you this license which gives you legal permission to copy, distribute and/or modify the software.<br /> <br /> Also, for each authors protection and ours, we want to make certain that everyone understands that there is no warranty for this free software. If the software is modified by someone else and passed on, we want its recipients to know that what they have is not the original, so that any problems introduced by others will not reflect on the original authors reputations.<br /> <br /> Finally, any free program is threatened constantly by software patents. We wish to avoid the danger that redistributors of a free program will individually obtain patent licenses, in effect making the program proprietary. To prevent this, we have made it clear that any patent must be licensed for everyones free use or not licensed at all.<br /> <br /> The precise terms and conditions for copying, distribution and modification follow.<br /> <br /> <strong>TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION</strong><br /> <br /> 0. This License applies to any program or other work which contains a notice placed by the copyright holder saying it may be distributed under the terms of this Affero General Public License. The Program, below, refers to any such program or work, and a work based on the Program means either the Program or any derivative work under copyright law: that is to say, a work containing the Program or a portion of it, either verbatim or with modifications and/or translated into another language. (Hereinafter, translation is included without limitation in the term modification.) Each licensee is addressed as you.<br /> <br /> Activities other than copying, distribution and modification are not covered by this License; they are outside its scope. The act of running the Program is not restricted, and the output from the Program is covered only if its contents constitute a work based on the Program (independent of having been made by running the Program). Whether that is true depends on what the Program does.<br /> <br /> 1. You may copy and distribute verbatim copies of the Programs source code as you receive it, in any medium, provided that you conspicuously and appropriately publish on each copy an appropriate copyright notice and disclaimer of warranty; keep intact all the notices that refer to this License and to the absence of any warranty; and give any other recipients of the Program a copy of this License along with the Program.<br /> <br /> You may charge a fee for the physical act of transferring a copy, and you may at your option offer warranty protection in exchange for a fee.<br /> <br /> 2. You may modify your copy or copies of the Program or any portion of it, thus forming a work based on the Program, and copy and distribute such modifications or work under the terms of Section 1 above, provided that you also meet all of these conditions:<br /> <br /> * a) You must cause the modified files to carry prominent notices stating that you changed the files and the date of any change.<br /> <br /> * b) You must cause any work that you distribute or publish, that in whole or in part contains or is derived from the Program or any part thereof, to be licensed as a whole at no charge to all third parties under the terms of this License.<br /> <br /> * c) If the modified program normally reads commands interactively when run, you must cause it, when started running for such interactive use in the most ordinary way, to print or display an announcement including an appropriate copyright notice and a notice that there is no warranty (or else, saying that you provide a warranty) and that users may redistribute the program under these conditions, and telling the user how to view a copy of this License. (Exception: if the Program itself is interactive but does not normally print such an announcement, your work based on the Program is not required to print an announcement.)<br /> <br /> * d) If the Program as you received it is intended to interact with users through a computer network and if, in the version you received, any user interacting with the Program was given the opportunity to request transmission to that user of the Programs complete source code, you must not remove that facility from your modified version of the Program or work based on the Program, and must offer an equivalent opportunity for all users interacting with your Program through a computer network to request immediate transmission by HTTP of the complete source code of your modified version or other derivative work.<br /> <br /> These requirements apply to the modified work as a whole. If identifiable sections of that work are not derived from the Program, and can be reasonably considered independent and separate works in themselves, then this License, and its terms, do not apply to those sections when you distribute them as separate works. But when you distribute the same sections as part of a whole which is a work based on the Program, the distribution of the whole must be on the terms of this License, whose permissions for other licensees extend to the entire whole, and thus to each and every part regardless of who wrote it.<br /> <br /> Thus, it is not the intent of this section to claim rights or contest your rights to work written entirely by you; rather, the intent is to exercise the right to control the distribution of derivative or collective works based on the Program.<br /> <br /> In addition, mere aggregation of another work not based on the Program with the Program (or with a work based on the Program) on a volume of a storage or distribution medium does not bring the other work under the scope of this License.<br /> <br /> 3. You may copy and distribute the Program (or a work based on it, under Section 2) in object code or executable form under the terms of Sections 1 and 2 above provided that you also do one of the following:<br /> <br /> * a) Accompany it with the complete corresponding machine-readable source code, which must be distributed under the terms of Sections 1 and 2 above on a medium customarily used for software interchange; or,<br /> <br /> * b) Accompany it with a written offer, valid for at least three years, to give any third party, for a charge no more than your cost of physically performing source distribution, a complete machine-readable copy of the corresponding source code, to be distributed under the terms of Sections 1 and 2 above on a medium customarily used for software interchange; or,<br /> <br /> * c) Accompany it with the information you received as to the offer to distribute corresponding source code. (This alternative is allowed only for noncommercial distribution and only if you received the program in object code or executable form with such an offer, in accord with Subsection b above.)<br /> <br /> The source code for a work means the preferred form of the work for making modifications to it. For an executable work, complete source code means all the source code for all modules it contains, plus any associated interface definition files, plus the scripts used to control compilation and installation of the executable. However, as a special exception, the source code distributed need not include anything that is normally distributed (in either source or binary form) with the major components (compiler, kernel, and so on) of the operating system on which the executable runs, unless that component itself accompanies the executable.<br /> <br /> If distribution of executable or object code is made by offering access to copy from a designated place, then offering equivalent access to copy the source code from the same place counts as distribution of the source code, even though third parties are not compelled to copy the source along with the object code.<br /> <br /> 4. You may not copy, modify, sublicense, or distribute the Program except as expressly provided under this License. Any attempt otherwise to copy, modify, sublicense or distribute the Program is void, and will automatically terminate your rights under this License. However, parties who have received copies, or rights, from you under this License will not have their licenses terminated so long as such parties remain in full compliance.<br /> <br /> 5. You are not required to accept this License, since you have not signed it. However, nothing else grants you permission to modify or distribute the Program or its derivative works. These actions are prohibited by law if you do not accept this License. Therefore, by modifying or distributing the Program (or any work based on the Program), you indicate your acceptance of this License to do so, and all its terms and conditions for copying, distributing or modifying the Program or works based on it.<br /> <br /> 6. Each time you redistribute the Program (or any work based on the Program), the recipient automatically receives a license from the original licensor to copy, distribute or modify the Program subject to these terms and conditions. You may not impose any further restrictions on the recipients exercise of the rights granted herein. You are not responsible for enforcing compliance by third parties to this License.<br /> <br /> 7. If, as a consequence of a court judgment or allegation of patent infringement or for any other reason (not limited to patent issues), conditions are imposed on you (whether by court order, agreement or otherwise) that contradict the conditions of this License, they do not excuse you from the conditions of this License. If you cannot distribute so as to satisfy simultaneously your obligations under this License and any other pertinent obligations, then as a consequence you may not distribute the Program at all. For example, if a patent license would not permit royalty-free redistribution of the Program by all those who receive copies directly or indirectly through you, then the only way you could satisfy both it and this License would be to refrain entirely from distribution of the Program.<br /> <br /> If any portion of this section is held invalid or unenforceable under any particular circumstance, the balance of the section is intended to apply and the section as a whole is intended to apply in other circumstances.<br /> <br /> It is not the purpose of this section to induce you to infringe any patents or other property right claims or to contest validity of any such claims; this section has the sole purpose of protecting the integrity of the free software distribution system, which is implemented by public license practices. Many people have made generous contributions to the wide range of software distributed through that system in reliance on consistent application of that system; it is up to the author/donor to decide if he or she is willing to distribute software through any other system and a licensee cannot impose that choice.<br /> <br /> This section is intended to make thoroughly clear what is believed to be a consequence of the rest of this License.<br /> <br /> 8. If the distribution and/or use of the Program is restricted in certain countries either by patents or by copyrighted interfaces, the original copyright holder who places the Program under this License may add an explicit geographical distribution limitation excluding those countries, so that distribution is permitted only in or among countries not thus excluded. In such case, this License incorporates the limitation as if written in the body of this License.<br /> <br /> 9. Affero Inc. may publish revised and/or new versions of the Affero General Public License from time to time. Such new versions will be similar in spirit to the present version, but may differ in detail to address new problems or concerns.<br /> <br /> Each version is given a distinguishing version number. If the Program specifies a version number of this License which applies to it and any later version, you have the option of following the terms and conditions either of that version or of any later version published by Affero, Inc. If the Program does not specify a version number of this License, you may choose any version ever published by Affero, Inc.</p>\r\n<p>You may also choose to redistribute modified versions of this program under any version of the Free Software Foundations GNU General Public License version 3 or higher, so long as that version of the GNU GPL includes terms and conditions substantially equivalent to those of this license.</p>\r\n<p>10. If you wish to incorporate parts of the Program into other free programs whose distribution conditions are different, write to the author to ask for permission. For software which is copyrighted by Affero, Inc., write to us; we sometimes make exceptions for this. Our decision will be guided by the two goals of preserving the free status of all derivatives of our free software and of promoting the sharing and reuse of software generally.<br /> <br /> NO WARRANTY<br /> <br /> 11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW. EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM AS IS WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU. SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING, REPAIR OR CORRECTION.<br /> <br /> 12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.</p>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0);";
echo 'Creating About Page...<br />';
mysql_query( $sql, $conn );


print "Upgrading to UTF-8<br>";
$stmts = explode(';', file_get_contents(dirname(__FILE__) . '/utf8.sql'));
foreach($stmts as $stmt) {
  $stmt = str_replace("`pligg_", "`".table_prefix, $stmt);
  mysql_query($stmt);
}
	

$stmts = explode("\n", file_get_contents(dirname(__FILE__) . '/upgrade_config_table.sql'));
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
