<?php

// the path to the module. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('sidebar_stats_path', my_pligg_base . '/modules/sidebar_stats/');
// the path to the modules templates. the probably shouldn't be changed unless you rename the sidebar_stats folder(s)
define('sidebar_stats_tpl_path', '../modules/sidebar_stats/templates/');
// the path for smarty / template lite plugins
define('sidebar_stats_plugins_path', 'modules/sidebar_stats/plugins');
// the language path for the module
	if(!defined('lang_loc')){
		// determine if we're in root or another folder like admin
			$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
			$path = substr($_SERVER["SCRIPT_NAME"], 0, $pos);
			if ($path == "/"){$path = "";}
			
			if($path != my_pligg_base){
				define('lang_loc', '..');
			} else {
				define('lang_loc', '.');
			}
	}

define('sidebar_stats_lang_conf', lang_loc . '/modules/sidebar_stats/lang.conf');
define('sidebar_stats_pligg_lang_conf', lang_loc . "/languages/lang_" . pligg_language . ".conf");

// don't touch anything past this line.

if(is_object($main_smarty)){
	$sql = "SELECT user_login FROM " . table_users . " WHERE user_enabled = '1' ORDER BY user_id DESC LIMIT 1";
	$last_user = $db->get_var($sql);
	$main_smarty->assign('sidebar_stats_last_user', $last_user); 

	$members = $db->get_var('SELECT count(*) from ' . table_users . ' WHERE user_enabled = "1";');
	$main_smarty->assign('sidebar_stats_members', $members);

	$votes = $db->get_var('SELECT count(*) from ' . table_votes . ' WHERE vote_type="links";');
	$main_smarty->assign('sidebar_stats_votes', $votes);

	$published = $db->get_var('SELECT count(*) from ' . table_links . ' WHERE link_status = "published";');
	$main_smarty->assign('sidebar_stats_published', $published);

	$new = $db->get_var('SELECT count(*) from ' . table_links . ' WHERE link_status = "new";');
	$main_smarty->assign('sidebar_stats_new', $new);

	$main_smarty->assign('sidebar_stats_stories', $new + $published);

	$comments = $db->get_var('SELECT count(*) from ' . table_comments . ' WHERE comment_status = "published";');
	$main_smarty->assign('sidebar_stats_comments', $comments);

	$votes = $db->get_var('SELECT count(*) from ' . table_votes . ' WHERE vote_type="comments";');
	$main_smarty->assign('sidebar_stats_comment_votes', $votes);

	$groups = $db->get_var('SELECT count(*) from ' . table_groups . ' WHERE group_status = "Enable";');
	$main_smarty->assign('sidebar_stats_groups', $groups);

	$saved = $db->get_var('SELECT count(*) from ' . table_saved_links . ';');
	$main_smarty->assign('sidebar_stats_saved', $saved);

	$files = $db->get_var('SELECT count(*) from ' . table_prefix . 'files;');
	$main_smarty->assign('sidebar_stats_files', $files);

	$messages = $db->get_var('SELECT count(*) from ' . table_prefix . 'messages;');
	$main_smarty->assign('sidebar_stats_messages', $messages);

	$categories = $db->get_var('SELECT count(*) from ' . table_prefix . 'categories;');
	$main_smarty->assign('sidebar_stats_categories', $categories);


	$main_smarty->assign('sidebar_stats_path', sidebar_stats_path);
	$main_smarty->assign('sidebar_stats_tpl_path', sidebar_stats_tpl_path);
	$main_smarty->assign('sidebar_stats_pligg_lang_conf', sidebar_stats_pligg_lang_conf);
	$main_smarty->assign('sidebar_stats_lang_conf', sidebar_stats_lang_conf);
}

?>
