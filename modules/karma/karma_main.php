<?php
//
// Settings page
//
function karma_showpage(){
	global $db, $main_smarty, $the_template;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	
	if($canIhaveAccess == 1)
	{	
		// Save settings
		if ($_POST['submit'])
		{
			misc_data_update('karma_submit_story', sanitize($_REQUEST['karma_submit_story'], 3));
			misc_data_update('karma_submit_comment', sanitize($_REQUEST['karma_submit_comment'], 3));
			misc_data_update('karma_story_publish', sanitize($_REQUEST['karma_story_publish'], 3));
			misc_data_update('karma_story_vote', sanitize($_REQUEST['karma_story_vote'], 3));
			misc_data_update('karma_story_unvote', sanitize($_REQUEST['karma_story_vote_remove'], 3));
			misc_data_update('karma_comment_vote', sanitize($_REQUEST['karma_comment_vote'], 3));
			misc_data_update('karma_story_discard', sanitize($_REQUEST['karma_story_discard'], 3));
			misc_data_update('karma_story_spam', sanitize($_REQUEST['karma_story_spam'], 3));
			misc_data_update('karma_comment_delete', sanitize($_REQUEST['karma_comment_delete'], 3));

			if ($_REQUEST['karma_username'] && $_REQUEST['karma_value']!=0)
			{
        		    $db->query($sql="UPDATE " . table_users . " SET user_karma=user_karma+'".$db->escape($_REQUEST['karma_value'])."' WHERE user_login='".$db->escape($_REQUEST['karma_username'])."'");
			    if (!$db->rows_affected)
				$error = "Wrong username ".sanitize($_REQUEST['karma_username'], 1);
			}

			$main_smarty->assign('error', $error);
		}
		// breadcrumbs
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = "Modify Karma";
			$navwhere['link2'] = my_pligg_base . "/module.php?module=karma";
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'karma'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modify_karma'); 
		$main_smarty->assign('pagename', pagename);
		$main_smarty->assign('settings', str_replace('"','&#034;',get_karma_settings()));
		$main_smarty->assign('tpl_center', karma_tpl_path . 'karma_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

function karma_do_submit3(&$vars)
{
	global $db, $current_user;


	$settings = get_karma_settings();
        $db->query("UPDATE " . table_users . " SET user_karma=user_karma+'{$settings['submit_story']}' WHERE user_id={$current_user->user_id}");

/*	// Check if other module turned the story to 'discard' or 'spam' state
	$linkres = $vars['linkres'];
	if (!$linkres->id) return;
	if ($linkres->status=='discard')
  	{
	    $vars['link_id'] = $linkres->id;
            karma_story_discard($vars);
	}
	elseif ($linkres->status=='spam')
  	{
	    $vars['link_id'] = $linkres->id;
            karma_story_spam($vars);
	}
*/
}

function karma_comment_submit(&$vars)
{
	global $db, $current_user;

	$settings = get_karma_settings();
        $db->query($sql="UPDATE " . table_users . " SET user_karma=user_karma+'{$settings['submit_comment']}' WHERE user_id={$current_user->user_id}");
}

function karma_published(&$vars)
{
	global $db, $current_user;

	$link_id = $vars['link_id'];
	if (!$link_id) return;
	$user_id = $db->get_var("SELECT link_author FROM ".table_links." WHERE link_id='".$db->escape($link_id)."'");

	$settings = get_karma_settings();
        $db->query("UPDATE " . table_users . " SET user_karma=user_karma+'{$settings['story_publish']}' WHERE user_id=$user_id");
}

function karma_vote(&$vars)
{
	global $db, $current_user;
	$settings = get_karma_settings();
        $db->query($sql="UPDATE " . table_users . " SET user_karma=user_karma+'{$settings['story_vote']}' WHERE user_id={$current_user->user_id}");
}

function karma_unvote(&$vars)
{
	global $db, $current_user;
	$settings = get_karma_settings();
        $db->query($sql="UPDATE " . table_users . " SET user_karma=user_karma+'{$settings['story_vote_remove']}' WHERE user_id={$current_user->user_id}");
}

function karma_comment_vote(&$vars)
{
	global $db, $current_user;

	$settings = get_karma_settings();
        $db->query("UPDATE " . table_users . " SET user_karma=user_karma+'{$settings['comment_vote']}' WHERE user_id={$current_user->user_id}");
}

function karma_story_discard(&$vars)
{
	global $db;

	$link_id = $vars['link_id'];
	if (!$link_id) return;
	$user_id = $db->get_var("SELECT link_author FROM ".table_links." WHERE link_id='".$db->escape($link_id)."'");

	$settings = get_karma_settings();
        $db->query("UPDATE " . table_users . " SET user_karma=user_karma+'{$settings['story_discard']}' WHERE user_id='$user_id'");
}

function karma_story_spam(&$vars)
{
	global $db;

	$link_id = $vars['link_id'];
	if (!$link_id) return;
	$user_id = $db->get_var("SELECT link_author FROM ".table_links." WHERE link_id='".$db->escape($link_id)."'");

	$settings = get_karma_settings();
        $db->query("UPDATE " . table_users . " SET user_karma=user_karma+'{$settings['story_spam']}' WHERE user_id='$user_id'");
}

function karma_comment_spam(&$vars)
{
	global $db, $current_user;

	$comment_id = $vars['comment_id'];
	if (!$comment_id) return;
	$user_id = $db->get_var("SELECT comment_user_id FROM ".table_comments." WHERE comment_id='".$db->escape($comment_id)."'");

	$settings = get_karma_settings();
        $db->query($sql="UPDATE " . table_users . " SET user_karma=user_karma+'{$settings['story_spam']}' WHERE user_id='$user_id'");
}

function karma_comment_deleted(&$vars)
{
	global $db;

	$comment_id = $vars['comment_id'];
	if (!$comment_id) return;

	$user_id = $db->get_var("SELECT comment_user_id FROM ".table_comments." WHERE comment_id='".$db->escape($comment_id)."'");

	$settings = get_karma_settings();
    $db->query($sql="UPDATE " . table_users . " SET user_karma=user_karma+'{$settings['comment_delete']}' WHERE user_id='$user_id'");
}


// 
// Read module settings
//
function get_karma_settings()
{
    return array(
		'submit_story' => get_misc_data('karma_submit_story'), 
		'submit_comment' => get_misc_data('karma_submit_comment'),
		'story_publish' => get_misc_data('karma_story_publish'),
		'story_vote' => get_misc_data('karma_story_vote'),
		'story_vote_remove' => get_misc_data('karma_story_unvote'),
		'comment_vote' => get_misc_data('karma_comment_vote'),
		'story_discard' => get_misc_data('karma_story_discard'),
		'story_spam' => get_misc_data('karma_story_spam'),
		'comment_delete' => get_misc_data('karma_comment_delete')
		);
}

?>