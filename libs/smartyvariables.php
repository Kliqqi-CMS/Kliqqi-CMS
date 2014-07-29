<?php

if(!defined('mnminclude')){header('Location: ../error_404.php');die();}

include mnminclude.'extra_fields_smarty.php';

$main_smarty->compile_dir = mnmpath."cache/";
$main_smarty->template_dir = mnmpath."templates/";
$main_smarty->cache_dir = mnmpath."cache/";

// determine if we're in root or another folder like admin
if(!defined('lang_loc')){
	$pos = strrpos($_SERVER["SCRIPT_NAME"], "/");
	$path = substr($_SERVER["SCRIPT_NAME"], 0, $pos);
	if ($path == "/"){$path = "";}
	
	if($path != my_pligg_base){
		define('lang_loc', '..');
	} else {
		define('lang_loc', '.');
	}
}

// Check if a .maintenance file exists in the Pligg root directory
$maintenance_file = "./.maintenance";
if(file_exists($maintenance_file)){
	$main_smarty->assign('maintenance_mode', 'true');
} else {
	$main_smarty->assign('maintenance_mode', 'false');
}

$main_smarty->config_dir = "";
$main_smarty->force_compile = false; // has to be off to use cache
$main_smarty->config_load(lang_loc . "/languages/lang_" . pligg_language . ".conf");

if(isset($_GET['id']) && is_numeric($_GET['id'])){$main_smarty->assign('request_id', $_GET['id']);}
if(isset($_GET['category']) && sanitize($_GET['category'], 3) != ''){$main_smarty->assign('request_category', sanitize($_GET['category'], 3));}
if(isset($_GET['search']) && sanitize($_GET['search'], 3) != ''){$main_smarty->assign('request_search', sanitize($_GET['search'], 3));}
if(isset($_POST['username']) && sanitize($_GET['username'], 3) != ''){$main_smarty->assign('login_username', sanitize($_POST['username'], 3));}

$main_smarty->assign('votes_per_ip', votes_per_ip);
$main_smarty->assign('dblang', $dblang);
$main_smarty->assign('pligg_language', pligg_language);
$main_smarty->assign('user_logged_in', $current_user->user_login);
$main_smarty->assign('user_id', $current_user->user_id);
$main_smarty->assign('user_level', $current_user->user_level);
$main_smarty->assign('user_authenticated', $current_user->authenticated);
$main_smarty->assign('Enable_Tags', Enable_Tags);
$main_smarty->assign('Enable_Live', Enable_Live);
$main_smarty->assign('Voting_Method', Voting_Method);
$main_smarty->assign('my_base_url', my_base_url);
$main_smarty->assign('my_pligg_base', my_pligg_base);
$main_smarty->assign('Allow_User_Change_Templates', Allow_User_Change_Templates);
$main_smarty->assign('urlmethod', urlmethod);
$main_smarty->assign('UseAvatars', do_we_use_avatars());
$main_smarty->assign('Allow_Friends', Allow_Friends);
$main_smarty->assign('Pager_setting', Auto_scroll);

if($current_user->user_login){
	$main_smarty->assign('Current_User_Avatar', $avatars = get_avatar('all', "", "", "", $current_user->user_id));
	$main_smarty->assign('Current_User_Avatar_ImgSrc', $avatars['small']);
}

//groups
$main_smarty->assign('enable_group', enable_group);
$main_smarty->assign('group_submit_level', group_submit_level);
$group_submit_level = group_submit_level;
$current_user_level = $current_user->user_level;
if(group_submit_level == $current_user_level || group_submit_level == 'normal' || $current_user_level == 'admin')
	$main_smarty->assign('group_allow', 1);

$main_smarty->assign('SearchMethod', SearchMethod);
$main_smarty = SetSmartyURLs($main_smarty);
if ($main_smarty->get_template_vars('tpl_center'))
    $main_smarty->display('blank.tpl');
$the_template = The_Template;
$main_smarty->assign('the_template', The_Template);
$main_smarty->assign('tpl_head', $the_template . '/head');
$main_smarty->assign('tpl_body', $the_template . '/body');
$main_smarty->assign('tpl_first_sidebar', $the_template . '/sidebar');
$main_smarty->assign('tpl_second_sidebar', $the_template . '/sidebar2');
$main_smarty->assign('tpl_header', $the_template . '/header');
$main_smarty->assign('tpl_footer', $the_template . '/footer');

// Admin Template
$main_smarty->assign('tpl_header_admin', '/header');

//remove this after we eliminate the need for do_header
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
if($canIhaveAccess == 1){$main_smarty->assign('isadmin', 1);}
$canIhaveAccess = $canIhaveAccess + checklevel('moderator');
if($canIhaveAccess == 1){$main_smarty->assign('isadmin', 1);}

// show count of new stories
$new_submissions_count = $db->get_var('SELECT count(*) from ' . table_links . ' where link_status = "new";');
$main_smarty->assign('new', $new_submissions_count);
// Renaming new variable to new_count
$main_smarty->assign('new_submissions_count', $new_submissions_count);

// Count variable for published stories
$published_submissions_count = $db->get_var('SELECT count(*) from ' . table_links . ' where link_status = "published";');
$main_smarty->assign('published', $published_submissions_count);
// Renaming published variable to published_count
$main_smarty->assign('published_submissions_count', $published_submissions_count);

// Count variable for moderated stories
$moderated_submissions_count = $db->get_var('SELECT count(*) from ' . table_links . ' where link_status != "published" AND link_status != "new" AND link_status != "spam" AND link_status != "discard" AND link_status != "page";');
$main_smarty->assign('moderated_submissions_count', $moderated_submissions_count);

// Count variable for moderated comments
$moderated_comments_count = $db->get_var('SELECT count(*) from ' . table_comments . ' where comment_status = "moderated";');
$main_smarty->assign('moderated_comments_count', $moderated_comments_count);

// Count variable for moderated users
$moderated_users_count = $db->get_var('SELECT count(*) from ' . table_users . ' where user_enabled = "0" AND user_level != "Spammer";');
$main_smarty->assign('moderated_users_count', $moderated_users_count);

// Count variable for moderated groups
$moderated_groups_count = $db->get_var('SELECT count(*) from ' . table_groups . ' where group_status = "disable";');
$main_smarty->assign('moderated_groups_count', $moderated_groups_count);

// Count the number of errors
$error_log_path = mnminclude.'../logs/error.log';
$error_log_content = file_get_contents($error_log_path);
$error_count = preg_match_all('/\[(\d{2})-(\w{3})-(\d{4}) (\d{2}:\d{2}:\d{2})/', $error_log_content, $matches);
$main_smarty->assign('error_count', $error_count);

// Count number of file backups
$admin_backup_dir = "../admin/backup/";
if (glob($admin_backup_dir . "*.sql") != false) {
	$sqlcount = count(glob($admin_backup_dir . "*.sql"));
} else {
	$sqlcount = 0;
}
if (glob($admin_backup_dir . "*.zip") != false) {
	$zipcount = count(glob($admin_backup_dir . "*.zip"));
} else {
	$zipcount = 0;
}
$main_smarty->assign('backup_count', $sqlcount+$zipcount);
$backup_count = $sqlcount+$zipcount;

// Count moderated total
$moderated_total_count = $moderated_groups_count+$moderated_users_count+$moderated_comments_count+$moderated_submissions_count+$error_count+$backup_count;
$main_smarty->assign('moderated_total_count', $moderated_total_count);

//count installed module with updates available
$res_update_mod=mysql_query('SELECT folder from ' . table_modules . ' where latest_version>version') or die(mysql_error());
$num_update_mod=0;
if(mysql_num_rows($res_update_mod)>0){
while($modules_folders=mysql_fetch_array($res_update_mod)){
	if (file_exists(mnmmodules . $modules_folders['folder']))
			$num_update_mod++;
 }
}
$main_smarty->assign('in_no_module_update_require', $num_update_mod);

$res_for_update=mysql_query("select var_value from " . table_config . "  where var_name = 'uninstall_module_updates'");
$data_for_update_uninstall_mod=mysql_fetch_array($res_for_update);
//count uninstalled modules with updates available

$main_smarty->assign('un_no_module_update_require', $data_for_update_uninstall_mod['var_value']);

//count total module updates required
$total_update_required_mod=$num_update_mod+$data_for_update_uninstall_mod['var_value'];
$main_smarty->assign('total_update_required_mod', $total_update_required_mod);

$vars = '';
check_actions('all_pages_top', $vars);

// setup the sorting links on the index page in smarty
$pligg_category = isset($_GET['category']) ? sanitize($_GET['category'], 3) : '';
if($pligg_category != ''){
	$main_smarty->assign('index_url_recent', getmyurl('maincategory', $pligg_category));
	$main_smarty->assign('index_url_today', getmyurl('index_sort', 'today', $pligg_category));
	$main_smarty->assign('index_url_yesterday', getmyurl('index_sort', 'yesterday', $pligg_category));
	$main_smarty->assign('index_url_week', getmyurl('index_sort', 'week', $pligg_category));
	$main_smarty->assign('index_url_month', getmyurl('index_sort', 'month', $pligg_category));
	$main_smarty->assign('index_url_year', getmyurl('index_sort', 'year', $pligg_category));
	$main_smarty->assign('index_url_alltime', getmyurl('index_sort', 'alltime', $pligg_category));
	
	$main_smarty->assign('index_url_upvoted', getmyurl('index_sort', 'upvoted', $pligg_category));
	$main_smarty->assign('index_url_downvoted', getmyurl('index_sort', 'downvoted', $pligg_category));
	$main_smarty->assign('index_url_commented', getmyurl('index_sort', 'commented', $pligg_category));
	
	$main_smarty->assign('cat_url', getmyurl("maincategory"));
}	
else {
	$main_smarty->assign('index_url_recent', getmyurl('index'));
	$main_smarty->assign('index_url_today', getmyurl('index_sort', 'today'));
	$main_smarty->assign('index_url_yesterday', getmyurl('index_sort', 'yesterday'));
	$main_smarty->assign('index_url_week', getmyurl('index_sort', 'week'));
	$main_smarty->assign('index_url_month', getmyurl('index_sort', 'month'));
	$main_smarty->assign('index_url_year', getmyurl('index_sort', 'year'));
	$main_smarty->assign('index_url_alltime', getmyurl('index_sort', 'alltime'));
	
	$main_smarty->assign('index_url_upvoted', getmyurl('index_sort', 'upvoted'));
	$main_smarty->assign('index_url_downvoted', getmyurl('index_sort', 'downvoted'));
	$main_smarty->assign('index_url_commented', getmyurl('index_sort', 'commented'));

}
//group sort smarty
$main_smarty->assign('group_url_newest', getmyurl('group_sort', 'newest'));
$main_smarty->assign('group_url_oldest', getmyurl('group_sort', 'oldest'));
$main_smarty->assign('group_url_members', getmyurl('group_sort', 'members'));
$main_smarty->assign('group_url_name', getmyurl('group_sort', 'name'));

// setup the links
if ($current_user->user_id > 0 && $current_user->authenticated) 
{
	$login=$current_user->user_login;
	$main_smarty->assign('user_url_personal_data', getmyurl('user', $login));
	$main_smarty->assign('user_url_news_sent', getmyurl('user2', $login, 'history'));
	$main_smarty->assign('user_url_news_published', getmyurl('user2', $login, 'published'));
	$main_smarty->assign('user_url_news_unpublished', getmyurl('user2', $login, 'new'));
	$main_smarty->assign('user_url_news_voted', getmyurl('user2', $login, 'voted'));
	$main_smarty->assign('user_url_news_upvoted', getmyurl('user2', $login, 'upvoted'));
	$main_smarty->assign('user_url_news_downvoted', getmyurl('user2', $login, 'downvoted'));
	$main_smarty->assign('user_url_commented', getmyurl('user2', $login, 'commented'));
	$main_smarty->assign('user_url_saved', getmyurl('user2', $login, 'saved'));
	$main_smarty->assign('user_url_setting', getmyurl('profile'));
	$main_smarty->assign('user_url_friends', getmyurl('user_friends', $login, 'following'));
	$main_smarty->assign('user_url_friends2', getmyurl('user_friends', $login, 'followers'));
	$main_smarty->assign('user_url_add', getmyurl('user_friends', $login, 'addfriend'));
	$main_smarty->assign('user_url_remove', getmyurl('user_friends', $login, 'removefriend'));
	$main_smarty->assign('user_rss', getmyurl('rssuser', $login));
	$main_smarty->assign('URL_Profile', getmyurl('user_edit', $login));
	$main_smarty->assign('user_url_member_groups', getmyurl('user2', $login, 'member_groups	'));
	$main_smarty->assign('isAdmin', checklevel('admin'));
	$main_smarty->assign('isModerator', checklevel('moderator'));
}
?>
