<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');
include_once(mnminclude.'user.php');

$requestID = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0; 

if(isset($_GET['title']) && sanitize($_GET['title'], 3) != ''){$requestTitle = sanitize($_GET['title'], 3);}
// if we're using "Friendly URL's for categories"
if(isset($_GET['category']) && sanitize($_GET['category'], 3) != ''){$thecat = $db->get_var("SELECT category_name FROM " . table_categories . " WHERE `category_safe_name` = '".urlencode(sanitize($_GET['category'], 3))."';");}

if($requestID > 0 && enable_friendly_urls == true){
	// if we're using friendly urls, don't call /story.php?id=XX  or /story/XX/
	// this is to prevent google from thinking it's spam
	// more work needs to be done on this

	$link = new Link;
	$link->id=$requestID;
	if($link->read() == false){
		$main_smarty->assign('tpl_center', 'error_404_center');
		$main_smarty->display($the_template . '/pligg.tpl');		
		die();
	}

	$url = getmyurl("storyURL", $link->category_safe_name($link->category), urlencode($link->title_url), $link->id);

	Header( "HTTP/1.1 301 Moved Permanently" );
	Header( "Location: " . $url );
	
	die();
}

// if we're using "Friendly URL's for stories"
// DB 08/01/08
$requestTitle = sanitize($requestTitle,4);
/////
if(isset($requestTitle)){$requestID = $db->get_var("SELECT link_id FROM " . table_links . " WHERE `link_title_url` = '$requestTitle';");}

if(is_numeric($requestID)) {
	$id = $requestID;
	$link = new Link;
	$link->id=$requestID;
	if(!$link->read()){

		// check for redirects
		include(mnminclude.'redirector.php');
		$x = new redirector($_SERVER['REQUEST_URI']);

		$main_smarty->assign('tpl_center', 'error_404_center');
		$main_smarty->display($the_template . '/pligg.tpl');		
		die();
	}
	if(isset($_POST['process']) && sanitize($_POST['process'], 3) != ''){
		if (sanitize($_POST['process'], 3)=='newcomment') {
		
			$vars = array('user_id' => $link->author,'link_id' => $link->id);
			check_actions('comment_subscription', $vars);
			
			/*if(comment_mail == true){
				$authormail = $db->get_var("SELECT user_email FROM ".table_users." WHERE `user_id` = '$link->author';");
				$subject= 'there is a new comment in your story';
				$message = "bodytext!";
				$headers = "From: noreply@pligg.com"  . "\r\nReply-To: noreply@pligg.com " . "\r\nX-Priority: 1\r\n";
				$to=$authormail;
				@mail($to, $subject, $message, $headers);
			}*/
			insert_comment();
		}
	}

	require_once(mnminclude.'check_behind_proxy.php');
	
	// Set globals
	$globals['link_id']=$link->id;
	$globals['category_id']=$link->category;
	$globals['category_name']=$link->category_name();
	$globals['category_url']=$link->category_safe_name();
	$vars = '';
	check_actions('story_top', $vars);

	$main_smarty->assign('link_submitter', $link->username());

	// setup breadcrumbs and page title
	$main_smarty->assign('posttitle', " - " . $link->title);
	$navwhere['text1'] = $globals['category_name'];
	$navwhere['link1'] = getmyurl('maincategory', $globals['category_url']);
	$navwhere['text2'] = $link->title;
	$navwhere['link2'] = getmyurl('storycattitle', $globals['category_url'], urlencode($link->title_url));
	$main_smarty->assign('navbar_where', $navwhere);

	// for the comment form
	$randkey = rand(1000000,100000000);
	$main_smarty->assign('randkey', $randkey);
	$main_smarty->assign('link_id', $link->id);
	$main_smarty->assign('user_id', $current_user->user_id);
	$main_smarty->assign('randmd5', md5($current_user->user_id.$randkey));

	// for login to comment
	$main_smarty->assign('register_url', getmyurl("register", ''));
	$main_smarty->assign('login_url', getmyurl("login", $_SERVER['REQUEST_URI']));

	// for show who voted
	$main_smarty->assign('user_url', getmyurl('userblank', ""));
	$main_smarty->assign('voter', who_voted($id, 'small'));

	// misc smarty
	$main_smarty->assign('Enable_Comment_Voting', Enable_Comment_Voting);
	$main_smarty->assign('enable_show_last_visit', enable_show_last_visit);
	$main_smarty->assign('UseAvatars', do_we_use_avatars());
	$main_smarty->assign('related_title_url', getmyurl('storytitle', ""));
	$main_smarty->assign('related_story', related_stories($id, $link->tags, $link->category));

	// meta tags
	$main_smarty->assign('meta_description', strip_tags($link->truncate_content()));
	$main_smarty->assign('meta_keywords', $link->tags);
	
	//sidebar
	$main_smarty = do_sidebar($main_smarty);	

	// pagename
	define('pagename', 'story'); 
	$main_smarty->assign('pagename', pagename);

	$main_smarty->assign('the_story', $link->print_summary('full', true));

	$main_smarty->assign('the_comments', get_comments(true));

	$main_smarty->assign('tpl_center', $the_template . '/story_center');
	$main_smarty->display($the_template . '/pligg.tpl');
} else {

	// check for redirects
	include(mnminclude.'redirector.php');
	$x = new redirector($_SERVER['REQUEST_URI']);
	
	$main_smarty->assign('tpl_center', 'error_404_center');
	$main_smarty->display($the_template . '/pligg.tpl');		
	die();
}

function get_comments ($fetch = false){
	Global $db, $main_smarty, $current_user, $CommentOrder, $link;
	
	//Set comment order to 1 if it's not set in the admin panel
	if(!isset($CommentOrder)){$CommentOrder = 1;}
	If ($CommentOrder == 1){$CommentOrderBy = "comment_votes DESC, comment_date DESC";}
	If ($CommentOrder == 2){$CommentOrderBy = "comment_date DESC";}
	If ($CommentOrder == 3){$CommentOrderBy = "comment_votes ASC, comment_date DESC";}
	If ($CommentOrder == 4){$CommentOrderBy = "comment_date ASC";}

	$output = '';

	// get all parent comments
	$comments = $db->get_col("SELECT comment_id FROM " . table_comments . " WHERE comment_link_id=$link->id and comment_parent = 0 ORDER BY " . $CommentOrderBy);
	if ($comments) {
		require_once(mnminclude.'comment.php');
		$comment = new Comment;
		foreach($comments as $comment_id) {
			$comment->id=$comment_id;
			$comment->read();
			$output .= $comment->print_summary($link, true);			
	
			// get all child comments
			$comments2 = $db->get_col("SELECT comment_id FROM " . table_comments . " WHERE comment_parent=$comment_id ORDER BY " . $CommentOrderBy);
			if ($comments2) {
				$output .= '<div style="margin-left:40px">';
				require_once(mnminclude.'comment.php');
				$comment2 = new Comment;
				foreach($comments2 as $comment_id) {
					$comment2->id=$comment_id;
					$comment2->read();
					$output .= $comment2->print_summary($link, true);
				}
				$output .= "</div>\n";
			}
	
 		} 
		if($fetch == false){
			echo $output;
		} else {
			return $output;
		}
	}
}


function insert_comment () {
	global $link, $db, $current_user;

	require_once(mnminclude.'comment.php');
	$comment = new Comment;

	$cancontinue = false;
	
	if(sanitize($_POST['link_id'], 3) == $link->id && $current_user->authenticated && sanitize($_POST['user_id'], 3) == $current_user->user_id &&	sanitize($_POST['randkey'], 3) > 0) {
		if(sanitize($_POST['comment_content'], 4) != ''){
			$comment->content=sanitize($_POST['comment_content'], 4);
			$cancontinue = true;
			// this is a normal new comment
		}

		$comment_parent_id = isset($_POST['comment_parent_id']) ? sanitize($_POST['comment_parent_id'], 3) : 0;
		$reply_content = isset($_POST['reply_comment_content-'.$comment_parent_id]) ? sanitize($_POST['reply_comment_content-'.$comment_parent_id], 4) : '';

		if($reply_content != ''){
			$comment->content = $reply_content;
			$comment->parent= $comment_parent_id;
			$cancontinue = true;
			// this is a reply to an existing comment
		}

		if($cancontinue == true){
			$comment->link=$link->id;
			$comment->randkey=sanitize($_POST['randkey'], 3);
			$comment->author=sanitize($_POST['user_id'], 3);
			$comment->store();
			//header('Location: '.$_SERVER['REQUEST_URI']);
			//die;
		}
	}
}
?>
