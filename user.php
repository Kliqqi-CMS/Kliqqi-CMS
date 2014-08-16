<?php
include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'group.php');
include(mnminclude.'user.php');
include(mnminclude.'comment.php');
include(mnminclude.'friend.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'csrf.php');

// setup the breadcrumbs
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile');
$navwhere['link1'] = getmyurl('topusers');
$navwhere['text2'] = $login;
$navwhere['link2'] = getmyurl('user2', $login, 'profile');

$offset=(get_current_page()-1)* $page_size;
$main_smarty = do_sidebar($main_smarty);

define('pagename', 'user'); 
$main_smarty->assign('pagename', pagename);

$CSRF = new csrf();
$CSRF->create('user_settings', true, true);
	
// if not logged in, redirect to the index page
$login = isset($_GET['login']) ? sanitize($_GET['login'], 3) : '';
$truelogin = isset($_COOKIE['mnm_user'] ) ? sanitize($_COOKIE['mnm_user'] , 3) : '';
if($login === '' && !$_GET['keyword']){
	if ($current_user->user_id > 0) {
		$login = $current_user->user_login;
		if (urlmethod == 2)
		    header("Location: $my_base_url$my_pligg_base/user/$login/");
		else
		    header("Location: ?login=$login");
	} else {
		header('Location: '.$my_base_url.$my_pligg_base);
	}
		die;
}

if ($login) {
	// read the users information from the database
	$user=new User();
	$user->username = $login;
	if(!$user->read() || $user->level=='Spammer' || ($user->username=='anonymous' && !$user->user_lastip) ||
   // Hide users without stories/comments from unregistered visitors
   !$user->all_stats() || $user->total_links+$user->total_comments+$current_user->user_id==0) {
	header("Location: $my_pligg_base/error_404.php");
	die;
	}
}

require_once(mnminclude.'check_behind_proxy.php'); 	 

if(ShowProfileLastViewers == true){
	$main_smarty->assign('ShowProfileLastViewers', true);		
	// setup some arrays
		$last_viewers_names = array();
		$last_viewers_profile = array();
		$last_viewers_avatar = array();
			
	// for each viewer, get their name, profile link and avatar and put it in an array
		$viewers=new User();
		if ($last_viewers) {
			foreach($last_viewers as $viewer_id) {
				$viewers->id=$viewer_id;
				$viewers->read();
				$last_viewers_names[] = $viewers->username;
				$last_viewers_profile[] = getmyurl('user2', $viewers->username, 'profile');
				$last_viewers_avatar[] = get_avatar('small', "", $viewers->username, $viewers->email);
			}
		}
	// tell smarty about our arrays
		$main_smarty->assign('last_viewers_names', $last_viewers_names);
		$main_smarty->assign('last_viewers_profile', $last_viewers_profile);
		$main_smarty->assign('last_viewers_avatar', $last_viewers_avatar);
} else {
	$main_smarty->assign('ShowProfileLastViewers', false);		
}
	

// User IP for Admin Use
$user_ip = $user->extra_field['user_ip'];
$main_smarty->assign('user_ip', $user_ip);
$user_lastip = $user->extra_field['user_lastip'];
$main_smarty->assign('user_lastip', $user_lastip);

// check to see if the profile is of a friend
if ($user->id) {
	$friend = new Friend;
	$main_smarty->assign('is_friend', $friend->get_friend_status($user->id));
	$main_smarty->assign('user_followers', $user->getFollowersCount());
	$main_smarty->assign('user_following', $user->getFollowingCount());
}

// setup breadcrumbs for the various views
$view = isset($_GET['view']) && sanitize($_GET['view'], 3) != '' ? sanitize($_GET['view'], 3) : 'profile';
if ($view=='setting' && $truelogin!=$login)
	$view = 'profile';

$main_smarty->assign('user_view', $view);
$main_smarty->assign('page_header', $page_header);

// User Homepage URL
if ($view == 'search') {
	$friend = new Friend;
	if(isset($_REQUEST['keyword'])){$keyword = $db->escape(sanitize(trim($_REQUEST['keyword']), 3));}

	if ($keyword) 
	{
		$searchsql = "SELECT * FROM " . table_users . " where ((user_login LIKE '%".$keyword."%' AND user_login !='".$current_user->user_login."') OR public_email LIKE '%".$keyword."%') AND user_level!='Spammer' ";
		$results = $db->get_results($searchsql);
		$results = object_2_array($results);
		foreach($results as $key => $val){
			if ($val['user_login'] != 'anonymous' || $val['user_lastip'] > 0)
			{
				$results[$key]['Avatar'] = get_avatar('small', "", $val['user_login'], $val['user_email']);
				$results[$key]['status'] = $friend->get_friend_status($val['user_id']);
				if ($results[$key]['status'] =='' || $results[$key]['status'] == 'follower') {
					$results[$key]['add_friend'] = getmyurl('user_add_remove', 'addfriend', $val['user_login']);
				}elseif ($results[$key]['status'] == 'following' || $results[$key]['status'] =='mutual') {
					$results[$key]['remove_friend'] = getmyurl('user_add_remove', 'removefriend', $val['user_login']);
				}
				
			}
			else
			unset ($results[$key]);
		}

		$main_smarty->assign('userlist', $results);
	}
	$main_smarty->assign('search', $keyword);

	$main_smarty->assign('page_header', $user->username);
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_Search_SearchResults') . ' ' . $keyword;
	$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " " . $login . " - " . $main_smarty->get_config_vars('PLIGG_Visual_Search_SearchResults') . ' ' . $keyword);

	// display the template
	$main_smarty->assign('tpl_center', $the_template . '/user_search_center');
	$main_smarty->display($the_template . '/pligg.tpl');
	die;
} else {

// avatars
$main_smarty->assign('UseAvatars', do_we_use_avatars());
$main_smarty->assign('Avatar', $avatars = get_avatar('all', '', $user->username, $user->email));
$main_smarty->assign('Avatar_ImgSrc', $avatars['large']);

if ($user->url != "") {
	if(substr(strtoupper($user->url), 0, 8) == "HTTPS://"){
		$main_smarty->assign('user_url', $user->url);
	}elseif(substr(strtoupper($user->url), 0, 7) != "HTTP://"){
		$main_smarty->assign('user_url', "http://" . $user->url);
	} else {
		$main_smarty->assign('user_url', $user->url);
	}
} else {
	$main_smarty->assign('user_url', '');
}		

// setup the links
$main_smarty->assign('user_url_personal_data2', getmyurl('user2', $login));
$main_smarty->assign('user_url_news_sent2', getmyurl('user2', $login, 'history'));
$main_smarty->assign('user_url_news_published2', getmyurl('user2', $login, 'published'));
$main_smarty->assign('user_url_news_unpublished2', getmyurl('user2', $login, 'new'));
$main_smarty->assign('user_url_news_voted2', getmyurl('user2', $login, 'voted'));
$main_smarty->assign('user_url_news_upvoted2', getmyurl('user2', $login, 'upvoted'));
$main_smarty->assign('user_url_news_downvoted2', getmyurl('user2', $login, 'downvoted'));	
$main_smarty->assign('user_url_commented2', getmyurl('user2', $login, 'commented'));
$main_smarty->assign('user_url_saved2', getmyurl('user2', $login, 'saved'));
$main_smarty->assign('user_url_friends', getmyurl('user_friends', $login, 'following'));
$main_smarty->assign('user_url_friends2', getmyurl('user_friends', $login, 'followers'));
$main_smarty->assign('user_url_add', getmyurl('user_friends', $login, 'addfriend'));
$main_smarty->assign('user_url_remove', getmyurl('user_friends', $login, 'removefriend'));
$main_smarty->assign('user_rss', getmyurl('rssuser', $login));
$main_smarty->assign('URL_Profile2', getmyurl('user_edit', $login));
$main_smarty->assign('form_action', getmyurl('profile')); 
$main_smarty->assign('user_url_member_groups', getmyurl('user2', $login, 'member_groups	'));

// tell smarty about our user
$main_smarty = $user->fill_smarty($main_smarty);

$username = $user->username;
$post_title = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Profile') . " " . $login;

$main_smarty->assign('username', $username);
$main_smarty->assign('posttitle', $post_title);

#$navwhere['text3'] = $page_header = $post_title;

if ($view == 'profile') {
	do_following($user->id);
	$main_smarty->assign('view_href', '');
	$main_smarty->assign('nav_pd', 4);
	// display the template
	$main_smarty->assign('tpl_center', $the_template . '/user_profile_center');
	$main_smarty->display($the_template . '/pligg.tpl');
} else {
	$main_smarty->assign('nav_pd', 3);
}

if ($view == 'voted') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_User_NewsVoted');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsVoted');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsVoted');
	$main_smarty->assign('view_href', 'voted');
	$main_smarty->assign('nav_nv', 4);
 } else {
	$main_smarty->assign('nav_nv', 3);
}	

if ($view == 'upvoted') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_UpVoted');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_UpVoted');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_UpVoted');
	$main_smarty->assign('view_href', 'upvoted');
	$main_smarty->assign('nav_nv', 4);
 } else {
	$main_smarty->assign('nav_nv', 3);
}

if ($view == 'downvoted') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_DownVoted');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_DownVoted');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_DownVoted');
	$main_smarty->assign('view_href', 'downvoted');
	$main_smarty->assign('nav_nv', 4);
 } else {
	$main_smarty->assign('nav_nv', 3);
}


if ($view == 'history') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_User_NewsSent');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsSent');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsSent');
	$main_smarty->assign('view_href', 'submitted');
	$main_smarty->assign('nav_ns', 4);
 } else {
	$main_smarty->assign('nav_ns', 3);
}

if ($view == 'setting') 
{
	
	$usercategorysql = "SELECT * FROM " . table_users . " where user_login = '".$db->escape($login)."' ";
	$userresults = $db->get_results($usercategorysql);
	$userresults = object_2_array($userresults);
	$get_categories = $userresults['0']['user_categories'];
	$user_categories = explode(",", $get_categories);
	
	$categorysql = "SELECT * FROM " . table_categories . " where category__auto_id!='0' ";
	$results = $db->get_results($categorysql);
	$results = object_2_array($results);
	$category = array();
	foreach($results as $key => $val)
	{
		$category[] = $val['category_name'];
	}
	$sor = $_GET['err'];
	if($sor == 1)
	{
		$err = "You have to select at least 1 category";
		$main_smarty->assign('err', $err);
	}
	
	$main_smarty->assign('category', $results);
	$main_smarty->assign('user_category', $user_categories);
	$main_smarty->assign('view_href', 'submitted');

	if (Allow_User_Change_Templates)
	{
		$dir = "templates";
		$templates = array();
		foreach (scandir($dir) as $file)
			if (strstr($file,".")!==0 && file_exists("$dir/$file/header.tpl"))
			$templates[] = $file;
		$main_smarty->assign('templates', $templates);
		$main_smarty->assign('current_template', sanitize($_COOKIE['template'],3));
		$main_smarty->assign('Allow_User_Change_Templates', Allow_User_Change_Templates);
	}
	$main_smarty->assign('nav_set', 4);
} else {
	$main_smarty->assign('nav_set', 3);
}
	
if ($view == 'published') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_User_NewsPublished');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsPublished');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsPublished');
	$main_smarty->assign('view_href', 'published');
	$main_smarty->assign('nav_np', 4);
 } else {
	$main_smarty->assign('nav_np', 3);
}

if ($view == 'new') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_User_NewsUnPublished');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsUnPublished');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsUnPublished');
	$main_smarty->assign('view_href', 'new');
	$main_smarty->assign('nav_nu', 4);
 } else {
	$main_smarty->assign('nav_nu', 3);
}

if ($view == 'commented') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_User_NewsCommented');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsCommented');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsCommented');
	$main_smarty->assign('view_href', 'commented');
	$main_smarty->assign('nav_c', 4);
 } else {
	$main_smarty->assign('nav_c', 3);
}

if ($view == 'saved') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_User_NewsSaved');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_NewsSaved');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_User_NewsSaved');
	$main_smarty->assign('view_href', 'saved');
	$main_smarty->assign('nav_s', 4);
 } else {
	$main_smarty->assign('nav_s', 3);
}	

if ($view == 'following') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_View_Friends');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_View_Friends');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_View_Friends');
}

if ($view == 'followers') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Your_Friends');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Your_Friends');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Viewing_Friends_2');
}

if ($view == 'removefriend') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Removing_Friend');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Removing_Friend');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Removing_Friend');
}

if ($view == 'addfriend') {
	$page_header .= $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Adding_Friend');
	$navwhere['text3'] = $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Adding_Friend');
	$post_title .= " | " . $main_smarty->get_config_vars('PLIGG_Visual_User_Profile_Adding_Friend');
}

if ($view == 'member_groups') {
	$main_smarty->assign('view_href', '');
	$main_smarty->assign('nav_mg', 4);
} else {
	$main_smarty->assign('nav_mg', 3);
}
}
$main_smarty->assign('page_header', $page_header);
$main_smarty->assign('username', $username);
$main_smarty->assign('posttitle', $post_title);


// Breadcrumb and Title Text
$main_smarty->assign('navbar_where', $navwhere);

// a hook
$vars = '';
check_actions('user_post_views', $vars);

// auto scrolling
if(Auto_scroll==2 || Auto_scroll==3){
	$main_smarty->assign("scrollpageSize",$page_size);
	$main_smarty->assign('curuserid',$current_user->user_id);
	$main_smarty->assign('userid',$user->id);
	$main_smarty->assign('viewtype', $view);
}

// determine which user page to display
Global $db, $main_smarty, $view, $user, $rows, $page_size, $offset;
$the_page = 'profile';
switch ($view) {

	case 'history':
		do_history();
		if(Auto_scroll==2 || Auto_scroll==3){
			$main_smarty->assign('total_row', $rows);
		} else {
			$main_smarty->assign('user_pagination', do_pages($rows, $page_size, $the_page, true));
		}
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_history_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'published':
		do_published();
		if(Auto_scroll==2 || Auto_scroll==3){
			$main_smarty->assign('total_row', $rows);
		} else {
			$main_smarty->assign('user_pagination', do_pages($rows, $page_size, $the_page, true));
		}
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_history_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'new':
		do_new();
		if(Auto_scroll==2 || Auto_scroll==3){
			$main_smarty->assign('total_row', $rows);
		} else {
			$main_smarty->assign('user_pagination', do_pages($rows, $page_size, $the_page, true));
		}
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_history_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'commented':
		do_commented();
		if(Auto_scroll==2 || Auto_scroll==3){
			$main_smarty->assign('total_row', $rows);
		} else {
			$main_smarty->assign('user_pagination', do_pages($rows, $page_size, $the_page, true));
		}
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_history_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'voted':
		do_voted();
		if(Auto_scroll==2 || Auto_scroll==3){
			$main_smarty->assign('total_row', $rows);
		} else {
			$main_smarty->assign('user_pagination', do_pages($rows, $page_size, $the_page, true));
		}
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_history_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;	
		
	case 'upvoted':
		do_updownvoted('up');
		if(Auto_scroll==2 || Auto_scroll==3){
			$main_smarty->assign('total_row', $rows);
		} else {
			$main_smarty->assign('user_pagination', do_pages($rows, $page_size, $the_page, true));
		}
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_history_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'downvoted':
		do_updownvoted('dwn');
		if(Auto_scroll==2 || Auto_scroll==3){
			$main_smarty->assign('total_row', $rows);
		} else {
			$main_smarty->assign('user_pagination', do_pages($rows, $page_size, $the_page, true));
		}
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_history_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'saved':
		do_stories();
		if(Auto_scroll==2 || Auto_scroll==3){
			$main_smarty->assign('total_row', $rows);
		} else {
			$main_smarty->assign('user_pagination', do_pages($rows, $page_size, $the_page, true));
		}
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_history_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;  
		
	case 'removefriend':
		do_removefriend();
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_follow_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'addfriend':
		do_addfriend();
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_follow_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'following':
		do_following($user->id);
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_follow_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'followers':
		do_followers($user->id);
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_follow_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'sendmessage':
		do_sendmessage();
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_follow_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
	case 'member_groups':
		do_member_groups();
		//$main_smarty->assign('user_pagination', do_pages($rows, $page_size, $the_page, true));
		// display the template
		$main_smarty->assign('tpl_center', $the_template . '/user_history_center');
		$main_smarty->display($the_template . '/pligg.tpl');
		break;
		
}

do_following($user->id);
do_followers($user->id);

function do_stories () {
	global $db, $main_smarty, $rows, $user, $offset, $page_size,$current_user,$cached_links;
	//if ($current_user->user_id == $user->id)
	//{
	$output = '';
	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM " . table_saved_links . " WHERE saved_user_id=$user->id");
		
	$fieldexists = checkforfield('saved_privacy', table_saved_links);
	if($fieldexists)
	{
		if ($current_user->user_id == $user->id)
		{	
			$links = $db->get_results("SELECT * FROM " . table_saved_links . " 
							LEFT JOIN " . table_links . " ON saved_link_id=link_id
							WHERE saved_user_id=$user->id ORDER BY saved_link_id DESC LIMIT $offset,$page_size");
		}
		else
		{
			$links = $db->get_results("SELECT * FROM " . table_saved_links . " 
							LEFT JOIN " . table_links . " ON saved_link_id=link_id
							WHERE saved_user_id=$user->id and saved_privacy = 'public' ORDER BY saved_link_id DESC LIMIT $offset,$page_size");	
		}
	}
	else
	{
		$links = $db->get_results("SELECT * FROM " . table_saved_links . " 
						LEFT JOIN " . table_links . " ON saved_link_id=link_id
						WHERE saved_user_id=$user->id ORDER BY saved_link_id DESC LIMIT $offset,$page_size");
	}	
	if ($links) {
		foreach($links as $dblink) {
			$link->id=$dblink->link_id;
			$cached_links[$dblink->link_id] = $dblink;
			$link->read();
				//$output.= $current_user->user_id."<br/>";
				//$output.= $user->id."<br/>";
			$output .= $link->print_summary('summary', true);
		}
	}
	$main_smarty->assign('user_page', $output);
}

function do_voted () {
	global $db, $main_smarty, $rows, $user, $offset, $page_size,$cached_links;

	$output = '';
	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM " . table_links . ", " . table_votes . " WHERE vote_user_id=$user->id AND vote_link_id=link_id AND vote_value > 0 AND (link_status='published' OR link_status='new')");
	$links = $db->get_results($sql="SELECT DISTINCT * FROM " . table_links . ", " . table_votes . " WHERE vote_user_id=$user->id AND vote_link_id=link_id AND vote_value > 0  AND (link_status='published' OR link_status='new') ORDER BY link_date DESC LIMIT $offset, $page_size");
	
	if ($links) {
		foreach($links as $dblink) {
			$link->id=$dblink->link_id;
			$cached_links[$dblink->link_id] = $dblink;
			$link->read();
			$link->rating = $dblink->vote_value/2;
			$output .= $link->print_summary('summary', true);
		}
	}
	$main_smarty->assign('user_page', $output);
}
function do_updownvoted ($status = null) {
	global $db, $main_smarty, $rows, $user, $offset, $page_size, $cached_links;

	$output = '';
	$link = new Link;
	
	if ($status == 'up'){
		$vote_stats = " > 0";
		$order = "DESC";
	} else {
		$vote_stats = " < 0";
		$order = "ASC";
	}
	
	$rows = $db->get_var("SELECT count(*) FROM " . table_links . ", " . table_votes . " WHERE vote_user_id=$user->id AND vote_link_id=link_id AND vote_value ".$vote_stats." AND (link_status='published' OR link_status='new')");
	$links = $db->get_results($sql="SELECT DISTINCT * FROM " . table_links . ", " . table_votes . " WHERE vote_user_id=$user->id AND vote_link_id=link_id AND vote_value ".$vote_stats."  AND (link_status='published' OR link_status='new') ORDER BY link_votes ".$order." LIMIT $offset, $page_size");
	
	if ($links) {
		foreach($links as $dblink) {
			$link->id=$dblink->link_id;
			$cached_links[$dblink->link_id] = $dblink;
			$link->read();
			$link->rating = $dblink->vote_value/2;
			$output .= $link->print_summary('summary', true);
		}
	}
	$main_smarty->assign('user_page', $output);
}

function do_history () {
	global $db, $main_smarty, $rows, $user, $offset, $page_size,$cached_links;
	$output = '';
	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_author=$user->id AND (link_status='published' OR link_status='new')");
	$links = $db->get_results("SELECT * FROM " . table_links . " WHERE link_author=$user->id AND (link_status='published' OR link_status='new') ORDER BY link_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $dblink) {
			$link->id=$dblink->link_id;
			$cached_links[$dblink->link_id] = $dblink;
			$link->read();
			$output .= $link->print_summary('summary', true);
		}
	}
	$main_smarty->assign('user_page', $output);
}

function do_published () {
	global $db, $main_smarty, $rows, $user, $offset, $page_size,$cached_links;
	$output = '';
	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_author=$user->id AND link_status='published'");
	$links = $db->get_results("SELECT * FROM " . table_links . " WHERE link_author=$user->id AND link_status='published'  ORDER BY link_published_date DESC, link_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $dblink) {
			$link->id=$dblink->link_id;
			$cached_links[$dblink->link_id] = $dblink;
			$link->read();
			$output .= $link->print_summary('summary', true);
		}
	}
	$main_smarty->assign('user_page', $output);
}

function do_new () {
	global $db, $main_smarty, $rows, $user, $offset, $page_size,$cached_links;
	$output = '';
	$link = new Link;
	$rows = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_author=$user->id AND link_status='new'");
	$links = $db->get_results("SELECT * FROM " . table_links . " WHERE link_author=$user->id AND link_status='new' ORDER BY link_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $dblink) {
			$link->id=$dblink->link_id;
			$cached_links[$dblink->link_id] = $dblink;
			$link->read();
			$output .= $link->print_summary('summary', true);
		}
	}
	$main_smarty->assign('user_page', $output);
}

function do_commented () {
	global $db, $main_smarty, $rows, $user, $offset, $page_size, $cached_links, $the_template;
	$output = '';

	$link = new Link;
	$comment = new Comment;

	$rows = $db->get_var("SELECT count(*) FROM " . table_links . ", " . table_comments . " WHERE comment_status='published' AND comment_user_id=$user->id AND comment_link_id=link_id");
	$links = $db->get_results("SELECT DISTINCT * FROM " . table_links . ", " . table_comments . " WHERE comment_status='published' AND comment_user_id=$user->id AND comment_link_id=link_id AND (link_status='published' OR link_status='new')  ORDER BY link_date DESC LIMIT $offset,$page_size");
	if ($links) {
		foreach($links as $dblink) {
			$link->id=$dblink->link_id;
			$cached_links[$dblink->link_id] = $dblink;
			$link->read();
			$link->fill_smarty($main_smarty);

			$comment->id=$dblink->comment_id;
			$comment->read();
			$comment->fill_smarty($main_smarty);

			$output .= $main_smarty->fetch($the_template . '/' . 'user_comment_center.tpl');
		}
	}     
	$main_smarty->assign('user_page', $output);
}

function do_removefriend (){
	global $db, $main_smarty, $user, $the_template;
	$friend = new Friend;
	$friend->remove($user->id);
}

function do_addfriend (){
	global $db, $main_smarty, $user, $the_template;
	$friend = new Friend;
	$friend->add($user->id);
}

function do_following($user_id){
	global $db, $main_smarty, $user, $the_template;
	$friend = new Friend;
	$friends = $friend->get_friend_list($user_id);

	$main_smarty->assign('the_template',$the_template);
	$main_smarty->assign('following', $friends);
}

function do_followers($user_id){
	global $db, $main_smarty, $user, $the_template;
	$friend = new Friend;
	$friends = $friend->get_friend_list_2($user_id);

	$main_smarty->assign('the_template',$the_template);
	$main_smarty->assign('follower', $friends);
}
function do_member_groups()
{
	global $db, $main_smarty, $rows, $user, $offset, $page_size;
	//print_r(get_groupid_user($user->id));
	$ids  = get_groupid_user($user->id);
	if($ids)
	{
		foreach($ids as $groupid)
		{
			//print_r($groupid);
			//echo $groupid->group_id;
			$output .= group_print_summary($groupid->group_id);
			$main_smarty->assign('user_page', $output);
		}
	}
}
?>
