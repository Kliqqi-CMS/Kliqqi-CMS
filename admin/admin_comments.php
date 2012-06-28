<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'comment.php');
include(mnminclude.'link.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');
include(mnminclude.'csrf.php');
			
check_referrer();

// require user to log in
force_authentication();

// restrict access to god only
$amIgod = 0;
$amIgod = $amIgod + checklevel('god');
$main_smarty->assign('amIgod', $amIgod);

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');

if($canIhaveAccess == 0){	
//	$main_smarty->assign('tpl_center', '/admin/admin_access_denied');
//	$main_smarty->display($template_dir . '/admin/admin.tpl');		
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
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
	if($_GET["keyword"] && $_GET["keyword"]!= $main_smarty->get_config_vars('PLIGG_Visual_Search_SearchDefaultText')){
		$search_sql = " AND (comment_content LIKE '%".sanitize($_GET["keyword"], 3)."%' OR user_login LIKE '%".sanitize($_GET["keyword"], 3)."%')";
	}
	
	if ($_GET['user'])
	{
		$user = mysql_fetch_array(mysql_query("SELECT * FROM " . table_users . " where user_login='".sanitize($_GET['user'], 3)."'"));
		$user_sql = " AND comment_user_id='".$user['user_id']."'";
	}

	// if admin uses the filter
	if(isset($_GET["filter"])) {
		switch (sanitize($_GET["filter"], 3)) {
			case 'all':
				$filter_sql = " comment_status != 'spam' AND comment_status != 'discard'";
				break;
			case 'today':
				$filter_sql = " comment_date > DATE_SUB(NOW(),INTERVAL 1 DAY)";
				break;
			case 'yesterday':
				$filter_sql = " comment_date  BETWEEN DATE_SUB(NOW(),INTERVAL 2 DAY) AND DATE_SUB(NOW(),INTERVAL 1 DAY) ";
				break;
			case 'week':
			 	$filter_sql = " comment_date > DATE_SUB(NOW(),INTERVAL 7 DAY)";
			 	break;					
		  	default:
				$filter_sql = " comment_status = '".$db->escape($_GET["filter"])."' ";
				break;
	  	}	
	}	
	else
		$filter_sql = " comment_status != 'spam' AND comment_status != 'discard'";
	
	$filtered = $db->get_results($sql="SELECT SQL_CALC_FOUND_ROWS * FROM " . table_comments . " 
							LEFT JOIN ".table_users." ON user_id=comment_user_id
							WHERE $filter_sql $search_sql $user_sql 
							ORDER BY comment_date DESC LIMIT $offset,$pagesize");
	$rows = $db->get_var("SELECT FOUND_ROWS()");

	// read comments from database 
	$user = new User;
	$comment = new Comment;
	if($filtered) {
      $template_comments = array();
	  foreach($filtered as $dbfiltered) {
	    $comment->id = $dbfiltered->comment_id;
 	    $cached_comments[$dbfiltered->comment_id] = $dbfiltered;
	    $comment->read();
#	    $user->id = $comment->author;
#	    $user->read();
		  $template_comments[] = array(
			'comment_id' => $comment->id,
			'comment_content' => txt_shorter($comment->content, 90),
			'comment_content_long' => $comment->content,
			'comment_votes' => $comment->votes,
			'comment_author' => $dbfiltered->user_login,
			'comment_link_id' => $comment->link,
			'comment_status' => $comment->status,
			'comment_date' => $dbfiltered->comment_date
		  );
	  }
	  $main_smarty->assign('template_comments', $template_comments);
	}
	
	// breadcrumbs and page title
	$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
	$navwhere['link1'] = getmyurl('admin', '');
	$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel_Comments');
	$main_smarty->assign('navbar_where', $navwhere);
	$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
	
	if (isset($_GET['action']) && sanitize($_GET['action'], 3) == "bulkmod" && isset($_POST['submit'])) {
		$CSRF->check_expired('admin_comments_edit');
		$killspammed = array();
		if ($CSRF->check_valid(sanitize($_POST['token'], 3), 'admin_comments_edit')){
			$comment = array();
			foreach ($_POST["comment"] as $k => $v) {
				$comment[intval($k)] = sanitize($v, 3);
			}
			foreach($comment as $key => $value) {
				if ($value == "published") {
					$db->query($sql='UPDATE `' . table_comments . '` SET `comment_status` = "published" WHERE `comment_id` = "'.$key.'"');
				}
				elseif ($value == "moderated") {
					$db->query($sql='UPDATE `' . table_comments . '` SET `comment_status` = "moderated" WHERE `comment_id` = "'.$key.'"');
				}
				elseif ($value == "discard" || $value == "delete") {
					$db->query($sql='UPDATE `' . table_comments . '` SET `comment_status` = "discard" WHERE `comment_id` = "'.$key.'"');

				   	$vars = array('comment_id' => $key);
				   	check_actions('comment_discard', $vars);
				}
				elseif ($value == "spam" && !$killspammed[$user_id]) {
					$user_id = $db->get_var("SELECT comment_user_id FROM `" . table_comments . "` WHERE `comment_id` = ".$key.";");
#					$db->query($sql='UPDATE `' . table_comments . '` SET `comment_status` = "spam" WHERE `comment_id` = "'.$key.'"');
					killspam($user_id);
					$killspammed[$user_id] = 1;
				}

				$comment = new Comment;
				$comment->id=$key;
				$comment->read();
			
				$link = new Link;
				$link->id=$comment->link;
				$link->read();
				$link->recalc_comments();
				$link->store();
				$link='';
			}
			header("Location: ".my_pligg_base."/admin/admin_comments.php?page=".sanitize($_GET['page'],3));
			die();

		} else {
		    $CSRF->show_invalid_error(1);
		    exit;
		}
	} else {
		$CSRF->create('admin_comments_edit', true, true);
	}
	
	// pagename
	define('pagename', 'admin_comments'); 
	$main_smarty->assign('pagename', pagename);
	
	// read the mysql database to get the pligg version
	$sql = "SELECT data FROM " . table_misc_data . " WHERE name = 'pligg_version'";
	$pligg_version = $db->get_var($sql);
	$main_smarty->assign('version_number', $pligg_version); 
	
	// show the template
	$main_smarty->assign('tpl_center', '/admin/admin_comments_center');
	$main_smarty->display($template_dir . '/admin/admin.tpl');

}
else {
	echo 'not for you! go away!';
}


?>