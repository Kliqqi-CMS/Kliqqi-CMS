<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'user.php');
include(mnminclude.'comment.php');
include(mnminclude.'smartyvariables.php');

if(!Enable_Live) {
	header("Location: $my_pligg_base/error_404.php");
	die();
}

// breadcrumbs and page title
$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Live');
$navwhere['link1'] = getmyurl('live', '');
$navwhere['text2'] = $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Comments');
$navwhere['link2'] = getmyurl('live_comments', '');
$main_smarty->assign('navbar_where', $navwhere);
$main_smarty->assign('posttitle', $main_smarty->get_config_vars('PLIGG_Visual_Breadcrumb_Comments'));

// figure out what "page" of the results we're on
$offset = (get_current_page() - 1) * $top_users_size;

$select = "SELECT * ";
$from_where = " FROM " . table_comments . "
		LEFT JOIN " . table_links . " ON comment_link_id=link_id 
		LEFT JOIN " . table_users . " ON comment_user_id=user_id WHERE comment_status='published' AND link_status='published'";
$order_by = " ORDER BY comment_id DESC";

// pagename
define('pagename', 'live_comments');
$main_smarty->assign('pagename', pagename);

// get the data to be displayed
$rows = $db->get_var("SELECT count(*) as count $from_where $order_by");
$comments = $db->get_results("$select $from_where $order_by LIMIT $offset,$top_users_size");

//$comment = new Comment;
//$user = new User;
$link = new Link;
if($comments) {
	foreach($comments as $dbcomment) {
//		$comment->id = $dbcomment->comment_id;
//		$comment->read();
		$live_item['comment_content'] = $dbcomment->comment_content;
//		$user->id = $comment->author;
//		$user->read();
		$live_item['comment_author'] = $dbcomment->user_login;
		$live_item['comment_date'] = txt_time_diff(strtotime($dbcomment->comment_date));
		$link->id = $dbcomment->link_id;
		$cached_links[$dbcomment->link_id] = $dbcomment;
		$link->read();
		$live_item['comment_link_title'] = $link->title;
		$live_item['comment_link_url'] = $link->get_internal_url();
		$live_items[] = $live_item;
	}
	$main_smarty->assign('live_items', $live_items);
}

// pagination
$main_smarty->assign('live_pagination', do_pages($rows, $top_users_size, "comments", true));
// sidebar
$main_smarty = do_sidebar($main_smarty);

// show the template
$main_smarty->assign('tpl_center', $the_template . '/live_comments_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>
