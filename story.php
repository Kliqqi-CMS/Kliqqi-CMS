<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'group.php');
include(mnminclude.'smartyvariables.php');
include_once(mnminclude.'user.php');

$requestID = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0; 

if(isset($_GET['title']) && sanitize($_GET['title'], 3) != ''){$requestTitle = sanitize($_GET['title'], 3);}
// if we're using "Friendly URL's for categories"
if(isset($_GET['category']) && sanitize($_GET['category'], 3) != '')
{	
    // One or multiple categories in the URL
    $thecat = explode(',',$_GET['category']);
    if (sizeof($thecat)<=1)
        $thecat[0] = $db->get_var("SELECT category_id FROM " . table_categories . " WHERE `category_safe_name` = '".$db->escape(urlencode(sanitize($_GET['category'], 3)))."';"); 
    else
	foreach ($thecat as &$cat)
            $cat = $db->get_var("SELECT category_id FROM " . table_categories . " WHERE `category_safe_name` = '".$db->escape(urlencode(sanitize($cat, 3)))."';"); 
}

if($requestID > 0 && enable_friendly_urls == true){
	// if we're using friendly urls, don't call /story.php?id=XX  or /story/XX/
	// this is to prevent google from thinking it's spam
	// more work needs to be done on this

	$link = new Link;
	$link->id=$requestID;
	if ($link->read() == false || (sizeof($thecat)>0 && 
				      (array_diff($thecat, $link->additional_cats, array($link->category)) || 
				       sizeof($thecat)!=sizeof($link->additional_cats)+1)))
	{
		header("Location: $my_pligg_base/error_404.php");
		die();
	}

	$url = getmyurl("storyURL", $link->category_safe_names(), urlencode($link->title_url), $link->id);

	Header( "HTTP/1.1 301 Moved Permanently" );
	Header( "Location: " . $url );
	
	die();
}

// if we're using "Friendly URL's for stories"
if(isset($requestTitle)){
	$requestID = $db->get_var($sql="SELECT link_id FROM " . table_links . " WHERE `link_title_url` = '".$db->escape(sanitize($requestTitle,4))."';");
	// Search in old urls if not found
	if (!is_numeric($requestID)) 
		$requestID = $db->get_var($sql="SELECT old_link_id FROM " . table_old_urls . " WHERE `old_title_url` = '".$db->escape(sanitize($requestTitle,4))."';");
}

if(is_numeric($requestID)) {
	$id = $requestID;
	$link = new Link;
	$link->id=$requestID;
	if ($link->read() == false || (sizeof($thecat)>0 && 
				      (array_diff($thecat, $link->additional_cats, array($link->category)) || 
				       sizeof($thecat)!=sizeof($link->additional_cats)+1)) ||
				      (($link->status=='spam' || $link->status=='discard') && !checklevel('admin') && !checklevel('moderator'))){

		// check for redirects
		include(mnminclude.'redirector.php');
		$x = new redirector($_SERVER['REQUEST_URI']);

		header("Location: $my_pligg_base/error_404.php");
		die();
	}

	// Hide private group stories
	if ($link->link_group_id)
	{
	    $privacy = $db->get_var("SELECT group_privacy FROM " . table_groups . " WHERE group_id = {$link->link_group_id}");
	    if ($privacy == 'private' && !isMember($link->link_group_id))
	    {
		die('Access denied');
	    }
	}

	if(isset($_POST['process']) && sanitize($_POST['process'], 3) != ''){
		if (sanitize($_POST['process'], 3)=='newcomment') {
			check_referrer();
		
			$vars = array('user_id' => $link->author,'link_id' => $link->id);
			check_actions('comment_subscription', $vars);
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
	$main_smarty->assign('posttitle', $link->title);
	$navwhere['text1'] = $globals['category_name'];
	$navwhere['link1'] = getmyurl('maincategory', $globals['category_url']);
	$navwhere['text2'] = $link->title;
	$navwhere['link2'] = getmyurl('storycattitle', $globals['category_url'], urlencode($link->title_url));
	$main_smarty->assign('navbar_where', $navwhere);
	$main_smarty->assign('request_category', $globals['category_url']);
	$main_smarty->assign('request_category_name', $globals['category_name']);

	// for the comment form
	$randkey = rand(1000000,100000000);
	$main_smarty->assign('randkey', $randkey);
	$main_smarty->assign('link_id', $link->id);
	$main_smarty->assign('user_id', $current_user->user_id);
	$main_smarty->assign('randmd5', md5($current_user->user_id.$randkey));
	
	if(!$current_user->authenticated){
		$vars = '';
		check_actions('anonymous_user_id', $vars);
	}

	// for login to comment
	$main_smarty->assign('register_url', getmyurl("register", ''));
	$main_smarty->assign('login_url', getmyurl("login", $_SERVER['REQUEST_URI']));

	// for show who voted
	$main_smarty->assign('user_url', getmyurl('userblank', ""));
	$main_smarty->assign('voter', who_voted($id, 'large', '>0'));
	$main_smarty->assign('downvoter', who_voted($id, 'large', '<0'));

	// misc smarty
	$main_smarty->assign('Enable_Comment_Voting', Enable_Comment_Voting);
	$main_smarty->assign('enable_show_last_visit', enable_show_last_visit);
	$main_smarty->assign('UseAvatars', do_we_use_avatars());
	$main_smarty->assign('related_title_url', getmyurl('storytitle', ""));
	$main_smarty->assign('related_story', related_stories($id, $link->tags, $link->category));

	// meta tags
	$meta_description = preg_replace(array('/\r/', '/\n/'), '', $link->truncate_content());
	$main_smarty->assign('meta_description', strip_tags($meta_description));
	$main_smarty->assign('meta_keywords', $link->tags);
	
	//sidebar
	$main_smarty = do_sidebar($main_smarty);	

	// pagename
	define('pagename', 'story'); 
	$main_smarty->assign('pagename', pagename);
	
	if($current_user->authenticated != TRUE){
		$vars = '';
		check_actions('register_showform', $vars);
	}
	$story_url = getmyurl("storyURL", $link->category_safe_names(), urlencode($link->title_url), $link->id);
    $main_smarty->assign('story_url',$story_url);
	$main_smarty->assign('the_story', $link->print_summary('full', true));
	
	
	$parent_comment_id=sanitize($_GET['comment_id'], 3);
	
	if(isset($_GET['reply']) && !empty($parent_comment_id)){
		$main_smarty->assign('the_comments', get_comments(true,0,$_GET['comment_id']));
		$main_smarty->assign('parrent_comment_id',$parent_comment_id);
	}elseif(!empty($parent_comment_id)){	
		$main_smarty->assign('the_comments', get_comments(true,$parent_comment_id,0,1));
		$main_smarty->assign('parrent_comment_id',$parent_comment_id);
	}else{
		$main_smarty->assign('the_comments', get_comments(true));
		$main_smarty->assign('parrent_comment_id',0);
	}
	
	$main_smarty->assign('url', $link->url);
	$main_smarty->assign('enc_url', urlencode($link->url));
	
	$main_smarty->assign('story_comment_count', $link->comments());
	$main_smarty->assign('URL_rss_page', getmyurl('storyrss', isset($requestTitle) ? $requestTitle : urlencode($link->title_url), $link->category_safe_name($link->category)));

	$main_smarty->assign('tpl_center', $the_template . '/story_center');
	$main_smarty->display($the_template . '/pligg.tpl');
} else {

	// check for redirects
	include(mnminclude.'redirector.php');
	$x = new redirector($_SERVER['REQUEST_URI']);
	
	header("Location: $my_pligg_base/error_404.php");
//	$main_smarty->assign('tpl_center', 'error_404_center');
//	$main_smarty->display($the_template . '/pligg.tpl');		
	die();
}

function get_comments ($fetch = false, $parent = 0, $comment_id=0, $show_parent=0){
	Global $db, $main_smarty, $current_user, $CommentOrder, $link, $cached_comments;
	
	//Set comment order to 1 if it's not set in the admin panel
	if (isset($_GET['comment_sort'])) setcookie('CommentOrder', $CommentOrder = $_GET['comment_sort'], time()+60*60*24*180); 
	elseif (isset($_COOKIE['CommentOrder'])) $CommentOrder = $_COOKIE['CommentOrder'];

	if (!isset($CommentOrder)) $CommentOrder = 1;
	If ($CommentOrder == 1){$CommentOrderBy = "comment_votes DESC, comment_date DESC";}
	If ($CommentOrder == 2){$CommentOrderBy = "comment_date DESC";}
	If ($CommentOrder == 3){$CommentOrderBy = "comment_votes ASC, comment_date DESC";}
	If ($CommentOrder == 4){$CommentOrderBy = "comment_date ASC";}

	$output = '';

	if (checklevel('admin') || checklevel('moderator'))
	    $status_sql = " OR comment_status='moderated'";

	// get all parent comments
	
	if($comment_id!=0){
	
	$comments = $db->get_results("SELECT * 
	                                    FROM " . table_comments . " 
	                                    WHERE (comment_status='published' $status_sql) AND 
	                                           comment_link_id=$link->id AND comment_id = $comment_id 
	                                    ORDER BY " . $CommentOrderBy);
										
	}elseif($show_parent==1){
	$comments = $db->get_results("SELECT * 
	                                    FROM " . table_comments . " 
	                                    WHERE (comment_status='published' $status_sql) AND 
	                                           comment_link_id=$link->id AND comment_id = $parent 
	                                    ORDER BY " . $CommentOrderBy);
	}else{
	$comments = $db->get_results("SELECT * 
	                                    FROM " . table_comments . " 
	                                    WHERE (comment_status='published' $status_sql) AND 
	                                           comment_link_id=$link->id AND comment_parent = $parent 
	                                    ORDER BY " . $CommentOrderBy);	
	}
	if ($comments) {
		require_once(mnminclude.'comment.php');
	    $comment = new Comment;
		foreach($comments as $dbcomment) {
			$comment->id=$dbcomment->comment_id;
			$cached_comments[$dbcomment->comment_id] = $dbcomment;
			$comment->read();
			$output .= $comment->print_summary($link, true);

			$output .= "<div class='child-comment'>\n";
			if($comment_id==0)
			$output .= get_comments(true, $dbcomment->comment_id);
			$output .= "</div>\n";
	
 		}
 		  
		if($fetch == false){
			echo $output;
		} else {
			return $output;
		}
	}
}


function insert_comment () {
	global $link, $db, $current_user, $main_smarty, $the_template, $story_url;

        
		$main_smarty->assign('TheComment',$_POST['comment_content']);
		
	if($vars['error'] == true){
		$error = true;
		return;
	}
	require_once(mnminclude.'comment.php');
	$comment = new Comment;

	$cancontinue = false;
	
	//anonymous comment
	$cancontinue_anon = false;
	$anon = $_POST['anon'];

	$comment->content=sanitize($_POST['comment_content'], 4);
	if (strlen($comment->content) > maxCommentLength)
	{
		$main_smarty->assign('url', $_SERVER['REQUEST_URI']);
		$main_smarty->assign('tpl_center', $the_template . '/comment_errors');
		$main_smarty->display($the_template . '/pligg.tpl');
		exit;
	}

	if(sanitize($_POST['link_id'], 3) == $link->id && $current_user->authenticated && sanitize($_POST['user_id'], 3) == $current_user->user_id &&	sanitize($_POST['randkey'], 3) > 0) 
	{
		if(sanitize($_POST['comment_content'], 4) != '')
			// this is a normal new comment
			$cancontinue = true;
		if (is_array($_POST['reply_comment_content']))
		{
		    // comment replies
		    foreach ($_POST['reply_comment_content'] as $id => $value)
		    	if ($id > 0 && $value)
		    	{
			    $comment->content = sanitize($value, 4);
			    $comment->parent= $id;
			    $cancontinue = true;
			    break;
		    	}
		}
	}
	elseif($_POST['link_id'] == $link->id && $_POST['randkey'] > 0 && $anon == 1) 
	{
		if(strlen($_POST['comment_content']) > 0)
		{
			check_actions('register_check_errors', $vars);
			if($vars['error'] == true)
				$error = true;
			elseif(!$current_user->authenticated)
			{
				$vars = array('link_id' => $link->id,'randkey' => $_POST['randkey'],'user_id' => $_POST['user_id'],'a_email' => $_POST['a_email'],'a_username' => $_POST['a_username'],'a_website' => $_POST['a_website'],'comment_content' => sanitize($_POST['comment_content'],4));
				check_actions('anonymous_comment', $vars);
			}
		}
	}

    $parrent_comment_id=sanitize($_POST['parrent_comment_id'], 3);
	if($cancontinue == true)
	{
		$comment->link=$link->id;
		if($parrent_comment_id!=0)
		$comment->parent= $parrent_comment_id;
		else
		$comment->parent=0;
		
		$comment->randkey=sanitize($_POST['randkey'], 3);
		$comment->author=sanitize($_POST['user_id'], 3);
		$vars = array('comment'=>&$comment);
		check_actions('story_insert_comment',$vars);
		if($vars['comment']->status)
		    $comment->status = $vars['comment']->status;
		$comment->store();
		$vars['comment'] = $comment->id;
		check_actions( 'after_comment_submit', $vars ) ;
		$story_url = getmyurl("storyURL", $link->category_safe_names(), urlencode($link->title_url), $link->id);
		//$story_url;
		header('Location: '.$story_url."#comment-reply-".$comment->id);
		die;
	}	
}


?>
