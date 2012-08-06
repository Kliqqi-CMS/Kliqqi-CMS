<?php
//
// Send email notifications to all subscribers
// Tested 04/12/11
//
function comment_subscription_comment_submit(&$vars)
{
	global $db, $main_smarty;

	$comment = new Comment;
	$comment->id = $vars['comment'];
	if (!$comment->read()) return;

	$user=new User();
	$user->id = $comment->author;
	$linkres=new Link;
	$linkres->id = $comment->link;

	if($user->read() && $linkres->read()) 
	{
		$main_smarty->assign('link', get_object_vars($linkres));
		$main_smarty->assign('user_avatar', get_avatar('large', "", $user->username, $user->email));
		$main_smarty->assign('story_url', my_base_url.$linkres->get_internal_url());

		if ($user->username=='anonymous' && function_exists('get_comment_username'))
		{
		    $vars['comment_username']='anonymous';
		    $vars['comment_id'] = $vars['comment'];
		    get_comment_username($vars);
		    $user->username = $vars['comment_username'];
		}
		$main_smarty->assign('author', get_object_vars($user));
		$main_smarty->assign('comment', get_object_vars($comment));
		$main_smarty->assign('image_facebook', my_base_url.my_pligg_base . '/modules/comment_subscription/templates/images/facebook.png');
		$main_smarty->assign('image_twitter', my_base_url.my_pligg_base . '/modules/comment_subscription/templates/images/twitter.png');
		$main_smarty->assign('image_header', my_base_url.my_pligg_base . '/modules/comment_subscription/templates/images/email_header.jpg');
		$main_smarty->assign('image_sidebar', my_base_url.my_pligg_base . '/modules/comment_subscription/templates/images/email_sidebar.jpg');

		$settings = get_comment_subscription_settings();

	    // Select users who subscribed to that story notifications
	    $subs = $db->get_results($sql="SELECT * FROM `".table_prefix . "csubscription` WHERE subs_link_id='{$linkres->id}' AND subs_user_id!={$comment->author}",ARRAY_A);
	
	    // Send notification to author of parent comment (if presented)
	    if ($comment->parent)
	    {
		$comment1 = new Comment;
		$comment1->id = $comment->parent;
		if ($comment1->read())
		{
		    $user1 = new User();
		    $user1->id = $comment1->author;
		    if($user1->read() && $user1->extra_field['comment_subscription']) 
		    	$subs[] = array('subs_user_id' => $comment1->author);
		}
   	    }

	    if ($subs && $settings['from_email'])
		foreach ($subs as $sub)
		{
		    $user->id = $sub['subs_user_id'];
		    if ($user->read())
		    {
			$main_smarty->assign('unsubscribe_link', my_base_url.my_pligg_base . '/modules/comment_subscription/subscribe.php?linkid='.$linkres->id.'&unsub=1&uid='.$user->username.'&code='.md5($user->email . $user->karma . $user->username . pligg_hash()));
			$text = $main_smarty->fetch('../modules/comment_subscription/templates/email.tpl');

			if ($settings['from'])
		    		$headers = "From: \"{$settings['from']}\" <{$settings['from_email']}>\r\n";
			else
		    		$headers = "From: {$settings['from_email']}\r\n";
		    	$headers .= "Content-type: text/html; charset=utf-8\r\n";

		    	mail($user->email, trim($settings['subject']).' '.$linkres->title, $text, $headers);
		    }
		}
	}
}

//
// Subscribe author automatically on submit
// Tested 04/11/11
//
function comment_subscription_story_submit($vars)
{
	global $db, $main_smarty;

	$linkres = $vars['linkres'];
	if (!$linkres->id) return;

	$user=new User();
	$user->id = $linkres->author;

	if($user->read() && $user->extra_field['comment_subscription']) 
	    $db->query($sql="INSERT INTO ".table_prefix."csubscription SET subs_user_id='{$linkres->author}',
							    		   subs_link_id='{$linkres->id}'");
}

//
// Settings page
//
function comment_subscription_showpage(){
	global $db, $main_smarty, $the_template;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{	
		if ($_POST['submit'])
		{
			if ($_REQUEST['comment_subscription_level'])
			    $level = join(',',$_REQUEST['comment_subscription_level']);
			if ($_REQUEST['comment_subscription_profile_level'])
			    $level1 = join(',',$_REQUEST['comment_subscription_profile_level']);

			$_REQUEST = str_replace('"',"'",$_REQUEST);
			misc_data_update('cs_from', mysql_real_escape_string($_REQUEST['comment_subscription_from']));
			misc_data_update('cs_from_email', mysql_real_escape_string($_REQUEST['comment_subscription_from_email']));
			misc_data_update('cs_subject', mysql_real_escape_string($_REQUEST['comment_subscription_subject']));
			header("Location: ".my_pligg_base."/module.php?module=comment_subscription");
			die();
		}
		// breadcrumbs
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'comment_subscription'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifycomment_subscription'); 
		$main_smarty->assign('pagename', pagename);

		$main_smarty->assign('settings', get_comment_subscription_settings());
		$main_smarty->assign('tpl_center', comment_subscription_tpl_path . 'comment_subscription_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

// 
// Read module settings
//
function get_comment_subscription_settings()
{
    return array(
		'from' => get_misc_data('cs_from'), 
		'from_email' => get_misc_data('cs_from_email'), 
		'subject' => get_misc_data('cs_subject')
		);
}

function comment_subscription_profile_save(){
	global $user, $users_extra_fields_field;

	$user->extra['comment_subscription']=sanitize($_POST['comment_subscription']);	
}

function comment_subscription_profile_show(){
	global $main_smarty, $user, $users_extra_fields_field;
	$main_smarty->assign('comment_subscription', $user->extra_field['comment_subscription']);
}
?>
