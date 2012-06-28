<?php

if(!defined('mnminclude')){header('Location: ../404error.php');die();}

if(!defined('table_prefix')){
	define('table_prefix','');
}
if(!defined('tables_defined')){
	define('table_categories', table_prefix . "categories" );
	define('table_comments', table_prefix . "comments" );
	define('table_friends', table_prefix . "friends" );
	define('table_links', table_prefix . "links" );
	define('table_trackbacks', table_prefix . "trackbacks" );
	define('table_users', table_prefix . "users" );
	define('table_tags', table_prefix . "tags" );
	define('table_votes', table_prefix . "votes" );
	define('table_config', table_prefix . "config" ); 
	define('table_modules', table_prefix . "modules" );
	define('table_messages', table_prefix . "messages" );
	define('table_formulas', table_prefix . "formulas" );
	define('table_saved_links', table_prefix . "saved_links" );
	define('table_totals', table_prefix . "totals" );
	define('table_feeds', table_prefix . "feeds" );
	define('table_feed_import_fields', table_prefix . "feed_import_fields" );
	define('table_feed_link', table_prefix . "feed_link" );
	define('table_misc_data', table_prefix . "misc_data" );
	define('table_redirects', table_prefix . "redirects" );
	define('table_groups', table_prefix . "groups" );
	define('table_group_member', table_prefix . "group_member" );
	define('table_group_shared', table_prefix . "group_shared" );
	define('table_pageviews', table_prefix . "pageviews" );
	define('table_tag_cache', table_prefix . "tag_cache" );
	define('table_login_attempts', table_prefix . "login_attempts" );
	define('table_widgets', table_prefix . "widgets" );
	define('table_old_urls', table_prefix . "old_urls" );
	define('table_additional_categories', table_prefix . "additional_categories" );
	define('tables_defined', true);
}
?>
