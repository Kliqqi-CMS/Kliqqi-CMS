<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

if(is_numeric($_GET['id'])) {

	$link = new Link;
	$link->id=sanitize($_GET['id'], 3);
	$link->commentid=sanitize($_GET['commentid'], 3);
	if(!is_numeric($link->commentid)){die();}
	$link->read();

	$comments = $db->get_row("SELECT comment_user_id FROM " . table_comments . " WHERE comment_id=$link->commentid");
	$commentownerid = $comments->comment_user_id;
	$commentowner = $db->get_var("SELECT user_login FROM " . table_users . " WHERE user_id = ". $commentownerid);

	if (isset($_POST['process']) && sanitize($_POST['process'], 3) =='newcomment') {
		insert_comment();
	}
	// Set globals
	$globals['link_id']=$link->id;
	$globals['commentid'] = $link->commentid;
	$globals['category_id']=$link->category;
	$globals['category_name']=$link->category_name();

	$main_smarty->assign('the_story', $link->print_summary('summary', true));

	if($current_user->user_level == "moderator" or $current_user->user_level == "admin"){
		$comments = $db->get_results("SELECT * FROM " . table_comments . " WHERE comment_id=$link->commentid ORDER BY comment_date");
	} else {
		$comments = $db->get_results("SELECT * FROM " . table_comments . " WHERE comment_status='published' AND comment_id=$link->commentid and comment_user_id=$current_user->user_id ORDER BY comment_date");
	}	
	if ($comments) {
		$current_user->owncomment = "YES";
		require_once(mnminclude.'comment.php');
		$comment = new Comment;
		foreach($comments as $dbcomment) {
			$comment->id=$dbcomment->comment_id;
			$cached_comments[$dbcomment->comment_id]=$dbcomment;
			$comment->read();
			$comment->hideedit='yes';
			$main_smarty->assign('the_comment', $comment->print_summary($link, true));
			$link->thecomment = $comment->quickread();
			$main_smarty->assign('TheComment', $comment->quickread());
		}
	} else {
		$current_user->owncomment = "NO";
		echo $main_smarty->get_config_vars("PLIGG_Visual_EditComment_NotYours") . '<br/><br/>';
		echo $main_smarty->get_config_vars("PLIGG_Visual_EditComment_Click") . '<a href = "'.getmyurl('story', sanitize($_GET['id'], 3)).'">'.$main_smarty->get_config_vars("PLIGG_Visual_EditComment_Here").'</a> '.$main_smarty->get_config_vars("PLIGG_Visual_EditComment_ToReturn").'<br/><br/>';
	}

	if($current_user->authenticated) {
		if($current_user->owncomment=="YES"){
			$main_smarty->assign('comment_form', print_comment_form(true));
		}
	} 

	// pagename
	define('pagename', 'edit'); 
	$main_smarty->assign('pagename', pagename);
	// sidebar
	$main_smarty = do_sidebar($main_smarty);

	// show the template
	$main_smarty->assign('tpl_center', $the_template . '/edit_comment_center');
	$main_smarty->display($the_template . '/pligg.tpl');
}



// display comment for for editing
function print_comment_form($fetch = false) {
	global $link, $current_user, $main_smarty, $the_template;

	// misc smarty
	$main_smarty->assign('randkey', rand(1000000,100000000));
	$main_smarty->assign('link_id', $link->id);
	$main_smarty->assign('user_id', $current_user->user_id);

	if($fetch == false){
		// show the template
		$main_smarty->display($the_template . '/comment_form.tpl');
	} else {
		return $main_smarty->fetch($the_template . '/comment_form.tpl');
	}
}

function insert_comment () {
	global $commentownerid, $link, $db, $current_user, $main_smarty, $the_template;
        check_actions('story_edit_comment',$vars);

	// Check if is a POST of a comment
	if(sanitize($_POST['link_id'], 3) == $link->id && 
			$current_user->authenticated &&
			sanitize($_POST['user_id'], 3) == $current_user->user_id &&
			is_numeric(sanitize($_POST['randkey'], 3)) &&
			sanitize($_POST['randkey'], 3) > 0 && 
			sanitize($_POST['comment_content'], 4) != '' ) {
		require_once(mnminclude.'comment.php');
		$comment = new Comment;
		$comment->id=$link->commentid;
		$comment->read();
		$comment->link=$link->id;
		$comment->randkey=sanitize($_POST['randkey'], 3);
		$comment->author=$commentownerid;
		$comment->content=sanitize($_POST['comment_content'], 4);
		if (strlen($comment->content) > maxCommentLength)
		{
			$main_smarty->assign('url', $_SERVER['REQUEST_URI']);
			$main_smarty->assign('tpl_center', $the_template . '/comment_errors');
			$main_smarty->display($the_template . '/pligg.tpl');
			exit;
		}
		
		$comment->store();
		$vars['comment'] = $comment->id;
		check_actions( 'after_comment_edit', $vars ) ;
		header('Location: ' . getmyurl('story', sanitize($_POST['link_id'], 3)));
		die;
	}
}

?>