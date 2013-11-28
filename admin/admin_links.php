<?php

include_once('../internal/Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'csrf.php');

check_referrer();

// require user to log in
force_authentication();

// restrict access to admins
$amIadmin = 0;
$amIadmin = $amIadmin + checklevel('admin');
$main_smarty->assign('amIadmin', $amIadmin);

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('admin');
$canIhaveAccess = $canIhaveAccess + checklevel('moderator');

$is_moderator = checklevel('moderator'); // Moderators have a value of '1' for the variable $is_moderator

if($canIhaveAccess == 0){	
//	$main_smarty->assign('tpl_center', '/admin/access_denied');
//	$main_smarty->display($template_dir . '/admin/admin.tpl');		
	header("Location: " . getmyurl('admin_login', $_SERVER['REQUEST_URI']));
	die();
}

// sidebar
$main_smarty = do_sidebar($main_smarty);

if($canIhaveAccess == 1) {
	global $offset;
	$CSRF = new csrf();

	// Items per page drop-down
	if(isset($_GET["pagesize"]) && is_numeric($_GET["pagesize"])) {
		misc_data_update('pagesize',$_GET["pagesize"]);
	}
	$pagesize = get_misc_data('pagesize');
	if ($pagesize <= 0) $pagesize = 30;
	$main_smarty->assign('pagesize', $pagesize);
	
	// figure out what "page" of the results we're on
	$offset=(get_current_page()-1)*$pagesize;
	
	// if user is searching
	$temp = '';
	if($_GET["keyword"] && $_GET["keyword"]!= $main_smarty->get_config_vars('PLIGG_Visual_Search_SearchDefaultText')){
		$pligg_keyword = sanitize($_GET["keyword"], 3);
		$search_sql = " AND (link_author LIKE '%".$pligg_keyword."%' OR link_title LIKE '%".$pligg_keyword."%' OR link_content LIKE '%".$pligg_keyword."%' OR link_tags LIKE '%".$pligg_keyword."%') ";
	}

	if ($_GET['user'])
	{
		$user = mysql_fetch_array(mysql_query("SELECT * FROM " . table_users . " where user_login='".sanitize($_GET['user'], 3)."'"));
		$user_sql = " AND link_author='".$user['user_id']."'";
	}

	
	// if admin uses the filter
	if(isset($_GET["filter"])) {
		switch (sanitize($_GET["filter"], 3)) {
		 	case 'new':
				$filter_sql = " link_status = 'new' ";
				break;
			case 'all':
				$filter_sql = " link_status <> 'page' AND link_status <> 'discard' AND link_status <> 'spam' ";
				break;
			case 'today':
				$filter_sql = " link_date > DATE_SUB(NOW(),INTERVAL 1 DAY) ";
				break;
			case 'yesterday':
				$filter_sql = " link_date BETWEEN DATE_SUB(NOW(),INTERVAL 2 DAY) AND DATE_SUB(NOW(),INTERVAL 1 DAY) ";
				break;
			case 'week':
			 	$filter_sql = " link_date > DATE_SUB(NOW(),INTERVAL 7 DAY) ";
			 	break;
			case 'discard':
			 	$filter_sql = " link_status = 'discard' ";
			 	break;
			case 'spam':
			 	$filter_sql = " link_status = 'spam' ";
			 	break;
			case 'page':
			 	$filter_sql = " link_status = 'page' ";
			 	break;
			case 'other':
				$filter_sql = " link_status != 'new' AND link_status != 'published' AND link_status != 'discard' AND link_status != 'spam' AND link_status != 'page'";
				break;
			default:
				$filter_sql = " link_status = '".$db->escape($_GET["filter"])."'";
				break;

	  	}	
	} else {
		$filter_sql = " link_status <> 'page' AND link_status <> 'discard' AND link_status <> 'spam' ";
	}
	$filtered = $db->get_results($sql="SELECT SQL_CALC_FOUND_ROWS * FROM " . table_links . " WHERE $filter_sql $search_sql $user_sql ORDER BY link_date DESC LIMIT $offset,$pagesize");
	$rows = $db->get_var("SELECT FOUND_ROWS()");

	// read links from database 
	$user = new User;
	$link = new Link;
	if($filtered) {
    $template_stories = array();
		foreach($filtered as $dbfiltered) {
			$link->id = $dbfiltered->link_id;
			$cached_links[$dbfiltered->link_id] = $dbfiltered;
			$link->read();
			$user->id = $link->author;
			$user->read();
			$template_stories[] = array(
				'link_title_url' => $link->title_url,
				'link_id' => $link->id,
				'link_title' => $link->title,
				'link_status' => $link->status,
				'link_author' => $user->username,
				'link_date' => date("d-m-Y",$link->date),
			);
		}
		$main_smarty->assign('template_stories', $template_stories);
	}

	// breadcrumbs and page title
	$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
	$navwhere['link1'] = getmyurl('admin', '');
	$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_Links');
	$main_smarty->assign('navbar_where', $navwhere);
	$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
	
	// if admin changes the link status
	if (isset($_GET['action']) && sanitize($_GET['action'], 3) == "bulkmod" && isset($_POST['admin_acction'])) {
		
		$CSRF->check_expired('admin_links_edit');
		if ($CSRF->check_valid(sanitize($_POST['token'], 3), 'admin_links_edit')){
			$comment = array();
			
			
			$admin_acction=$_POST['admin_acction'];
            		
			foreach ($_POST["link"] as $key => $v) {
			    
				if($admin_acction=="published" || $admin_acction=="new" || $admin_acction=="discard" || $admin_acction=="spam"){
					$link_status=$db->get_var('select link_status from ' . table_links . '  WHERE link_id = "'.$key.'"');
					if($link_status!=$admin_acction){
								
						if ($admin_acction == "published") {
							$db->query('UPDATE `' . table_links . '` SET `link_status` = "published", link_published_date = now() WHERE `link_id` = "'.$key.'"');
							$vars = array('link_id' => $key);
							check_actions('link_published', $vars);
						}
						elseif ($admin_acction == "new") {
							$db->query('UPDATE `' . table_links . '` SET `link_status` = "new", link_published_date=0 WHERE `link_id` = "'.$key.'"');
						}
						elseif ($admin_acction == "discard") {
							$db->query('UPDATE `' . table_links . '` SET `link_status` = "discard" WHERE `link_id` = "'.$key.'"');
		
							$vars = array('link_id' => $key);
							check_actions('story_discard', $vars);
						}
						elseif ($admin_acction == "spam") {
							
							
							$user_id = $db->get_var($sql="SELECT link_author FROM `" . table_links . "` WHERE `link_id` = ".$key.";");
							$db->query('UPDATE `' . table_links . '` SET `link_status` = "spam" WHERE `link_id` = "'.$key.'"');
							$vars = array('link_id' => $key);
							 check_actions('story_discard', $vars);
							$user = new User;
							$user->id = $user_id;
							$user->read();
							
							if ($user->level!='admin' && $user->level!="Spammer")
							{
							    killspam($user_id);
								$killspammed[$user_id] = 1;
								}
							}
					
								
						}
					
				}
				
			}
			
			totals_regenerate();
			//header("Location: ".my_pligg_base."/admin/admin_links.php?page=".sanitize($_GET['page'],3));
			$redirect_url=$_SERVER['HTTP_REFERER'];
			header("Location:". $redirect_url);
			exit();
		} else {
		    $CSRF->show_invalid_error(1);
		    exit;
		}
	} else {
		$CSRF->create('admin_links_edit', true, true);
	}

	// pagename
	define('pagename', 'admin_links'); 
	$main_smarty->assign('pagename', pagename);
	
	// read the mysql database to get the pligg version
	$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
	$pligg_version = $db->get_var($sql);
	$main_smarty->assign('version_number', $pligg_version);
	
	// show the template
	$main_smarty->assign('tpl_center', '/admin/submissions');
	if ($is_moderator == '1'){
		$main_smarty->display($template_dir . '/admin/moderator.tpl');
	} else {
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
}
else {
	echo 'This page is restricted to site Admins!';
}		

?>
