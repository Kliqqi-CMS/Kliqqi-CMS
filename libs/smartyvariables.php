<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

if(!defined('mnminclude')){header('Location: ../404error.php');die();}

include mnminclude.'extra_fields_smarty.php';

$main_smarty->compile_dir = mnmpath."cache/templates_c/";
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

$main_smarty->config_dir = "";
$main_smarty->force_compile = false; // has to be off to use cache
$main_smarty->config_load(lang_loc . "/languages/lang_" . pligg_language . ".conf");

if(isset($_GET['id']) && is_numeric($_GET['id'])){$main_smarty->assign('request_id', $_GET['id']);}
if(isset($_GET['category']) && sanitize($_GET['category'], 3) != ''){$main_smarty->assign('request_category', sanitize($_GET['category'], 3));}
if(isset($_GET['search']) && sanitize($_GET['search'], 3) != ''){$main_smarty->assign('request_search', sanitize($_GET['search'], 3));}
if(isset($_POST['username']) && sanitize($_GET['username'], 3) != ''){$main_smarty->assign('login_username', sanitize($_POST['username'], 3));}

$main_smarty->assign('dblang', $dblang);
$main_smarty->assign('pligg_language', pligg_language);
$main_smarty->assign('user_logged_in', $current_user->user_login);
$main_smarty->assign('user_authenticated', $current_user->authenticated);
$main_smarty->assign('Enable_Tags', Enable_Tags);
$main_smarty->assign('Enable_Live', Enable_Live);
$main_smarty->assign('Voting_Method', Voting_Method);
$main_smarty->assign('my_base_url', my_base_url);
$main_smarty->assign('my_pligg_base', my_pligg_base);
$main_smarty->assign('Spell_Checker', Spell_Checker);
$main_smarty->assign('Allow_User_Change_Templates', Allow_User_Change_Templates);
$main_smarty->assign('urlmethod', urlmethod);
$main_smarty->assign('UseAvatars', do_we_use_avatars());
$main_smarty->assign('Allow_Friends', Allow_Friends);
if($current_user->user_login){$main_smarty->assign('Current_User_Avatar_ImgSrc', get_avatar('small', "", "", "", $current_user->user_id));}

//groups
$main_smarty->assign('enable_group', enable_group);

$main_smarty->assign('group_submit_level', group_submit_level);
$group_submit_level = group_submit_level;
$current_user_level = $current_user->user_level;
if(group_submit_level == $current_user_level || group_submit_level == 'normal' || $current_user_level == 'god')
	$main_smarty->assign('group_allow', 1);

$main_smarty->assign('SearchMethod', SearchMethod);
$main_smarty = SetSmartyURLs($main_smarty);
if ($main_smarty->get_template_vars('tpl_center'))
    $main_smarty->display('blank.tpl');
$the_template = The_Template;
$main_smarty->assign('the_template', The_Template);
$main_smarty->assign('the_template_sidebar_modules', The_Template . "/sidebar_modules");
$main_smarty->assign('tpl_head', $the_template . '/head');
$main_smarty->assign('tpl_body', $the_template . '/body');
$main_smarty->assign('tpl_right_sidebar', $the_template . '/sidebar');
$main_smarty->assign('tpl_second_sidebar', $the_template . '/sidebar2');
$main_smarty->assign('tpl_header', $the_template . '/header');
$main_smarty->assign('tpl_footer', $the_template . '/footer');

// Admin Template
$main_smarty->assign('tpl_header_admin', '/header');

//remove this after we eliminate the need for do_header
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');
if($canIhaveAccess == 1){$main_smarty->assign('isgod', 1);}
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
if($canIhaveAccess == 1){$main_smarty->assign('isadmin', 1);}
// show count of upcoming stories
$queued = $db->get_var('SELECT count(*) from ' . table_links . ' where link_status = "queued";');
$main_smarty->assign('queued', $queued);
// Renaming queued variable to upcoming_count
$main_smarty->assign('queued', $upcoming_count);

// Count variable for published stories
$published = $db->get_var('SELECT count(*) from ' . table_links . ' where link_status = "published";');
$main_smarty->assign('published', $published_count);


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
	}
//group sort smarty
$main_smarty->assign('group_url_newest', getmyurl('group_sort', 'newest'));
$main_smarty->assign('group_url_oldest', getmyurl('group_sort', 'oldest'));
$main_smarty->assign('group_url_members', getmyurl('group_sort', 'members'));
$main_smarty->assign('group_url_name', getmyurl('group_sort', 'name'));
?>
