ALTER TABLE  `pligg_categories` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_comments` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_config` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_formulas` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_friends` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_group_member` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_group_shared` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_groups` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_links` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_messages` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_misc_data` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_modules` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_redirects` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_saved_links` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_tag_cache` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_tags` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_totals` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_trackbacks` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_users` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE  `pligg_votes` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_categories` 
CHANGE  `category_lang`  `category_lang` VARCHAR( 2 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT  'en',
CHANGE  `category_name`  `category_name` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `category_safe_name`  `category_safe_name` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `category_desc`  `category_desc` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `category_keywords`  `category_keywords` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `category_author_group`  `category_author_group` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_comments` CHANGE  `comment_content`  `comment_content` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_config` CHANGE  `var_page`  `var_page` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `var_name`  `var_name` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `var_value`  `var_value` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `var_defaultvalue`  `var_defaultvalue` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `var_optiontext`  `var_optiontext` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `var_title`  `var_title` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `var_desc`  `var_desc` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `var_method`  `var_method` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `var_enclosein`  `var_enclosein` VARCHAR( 5 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;

ALTER TABLE  `pligg_formulas` CHANGE  `type`  `type` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `title`  `title` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `formula`  `formula` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_groups`
CHANGE  `group_safename`  `group_safename` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `group_name`  `group_name` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `group_description`  `group_description` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `group_privacy`  `group_privacy` ENUM(  'private',  'public',  'restricted' ) ,
CHANGE  `group_avatar`  `group_avatar` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `group_field1`  `group_field1` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `group_field2`  `group_field2` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `group_field3`  `group_field3` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `group_field4`  `group_field4` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `group_field5`  `group_field5` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `group_field6`  `group_field6` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_links` CHANGE  `link_url`  `link_url` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_url_title`  `link_url_title` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL ,
CHANGE  `link_title`  `link_title` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_title_url`  `link_title_url` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL ,
CHANGE  `link_content`  `link_content` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_summary`  `link_summary` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL ,
CHANGE  `link_tags`  `link_tags` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL ,
CHANGE  `link_field1`  `link_field1` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field2`  `link_field2` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field3`  `link_field3` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field4`  `link_field4` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field5`  `link_field5` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field6`  `link_field6` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field7`  `link_field7` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field8`  `link_field8` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field9`  `link_field9` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field10`  `link_field10` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field11`  `link_field11` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field12`  `link_field12` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field13`  `link_field13` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field14`  `link_field14` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `link_field15`  `link_field15` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_messages` CHANGE  `title`  `title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `body`  `body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_misc_data` CHANGE  `name`  `name` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `data`  `data` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_modules` CHANGE  `name`  `name` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `folder`  `folder` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_redirects` CHANGE  `redirect_old`  `redirect_old` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `redirect_new`  `redirect_new` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_tag_cache` CHANGE  `tag_words`  `tag_words` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_tags` CHANGE  `tag_lang`  `tag_lang` VARCHAR( 4 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT  'en',
CHANGE  `tag_words`  `tag_words` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_totals` CHANGE  `name`  `name` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE  `pligg_trackbacks` CHANGE  `trackback_type`  `trackback_type` ENUM(  'in',  'out' ) DEFAULT  'in',
CHANGE  `trackback_status`  `trackback_status` ENUM(  'ok',  'pendent',  'error' ) DEFAULT  'pendent',
CHANGE  `trackback_url`  `trackback_url` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `trackback_title`  `trackback_title` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL ,
CHANGE  `trackback_content`  `trackback_content` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL;

ALTER TABLE  `pligg_users` CHANGE  `user_login`  `user_login` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_level`  `user_level` ENUM(  'normal',  'admin',  'god', 'Spammer' ) DEFAULT  'normal',
CHANGE  `user_pass`  `user_pass` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_email`  `user_email` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_names`  `user_names` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_url`  `user_url` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_aim`  `user_aim` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_msn`  `user_msn` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_yahoo`  `user_yahoo` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_gtalk`  `user_gtalk` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_skype`  `user_skype` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_irc`  `user_irc` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `public_email`  `public_email` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_avatar_source`  `user_avatar_source` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
CHANGE  `user_ip`  `user_ip` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT  '0',
CHANGE  `user_lastip`  `user_lastip` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT  '0',
CHANGE  `last_reset_code`  `last_reset_code` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL ,
CHANGE  `user_location`  `user_location` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL ,
CHANGE  `user_occupation`  `user_occupation` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL ,
CHANGE  `user_categories`  `user_categories` VARCHAR( 1024 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT  '';

