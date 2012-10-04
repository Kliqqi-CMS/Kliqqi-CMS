<?php
//
// Settings page
//
function spam_trigger_showpage(){
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
		// Save settings
		if ($_POST['submit'])
		{
			misc_data_update('spam_trigger_light', sanitize($_REQUEST['spam_light'], 3));
			misc_data_update('spam_trigger_medium', sanitize($_REQUEST['spam_medium'], 3));
			misc_data_update('spam_trigger_hard', sanitize($_REQUEST['spam_hard'], 3));

			header("Location: ".my_pligg_base."/module.php?module=spam_trigger");
			die();
		}
		// breadcrumbs
		$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
		$navwhere['link1'] = getmyurl('admin', '');
		$navwhere['text2'] = "Modify spam_trigger";
		$navwhere['link2'] = my_pligg_base . "/module.php?module=spam_trigger";
		$main_smarty->assign('navbar_where', $navwhere);
		$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));

		define('modulename', 'spam_trigger'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifyspam_trigger'); 
		$main_smarty->assign('pagename', pagename);
		$main_smarty->assign('settings', str_replace('"','&#034;',get_spam_trigger_settings()));
		$main_smarty->assign('places',$spam_trigger_places);
		$main_smarty->assign('tpl_center', spam_trigger_tpl_path . 'spam_trigger_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

function spam_trigger_editlink()
{
	global $db, $current_user, $linkres;

	if (checklevel('moderator') || checklevel('admin')) return;
	if (!is_numeric($_POST['id'])) return;

	$settings = get_spam_trigger_settings();

	$str = $_POST['title']."\n".$_POST['bodytext']."\n".$_POST['summarytext']."\n".$_POST['tags'];
	// Killspam user
	if ($settings['spam_hard'] && !spam_trigger_check($str, $settings['spam_hard']))
	{
		$_SESSION['spam_trigger_story_error'] = 'deleted';
		spam_trigger_killspam($current_user->user_id);
		$linkres->status = 'spam';
	}
	// discard story
	elseif ($settings['spam_medium'] && !spam_trigger_check($str, $settings['spam_medium']))
	{
		$_SESSION['spam_trigger_story_error'] = 'discarded';
		$linkres->status = 'discard';
	}
	// set status to moderated
	elseif ($settings['spam_light'] && !spam_trigger_check($str, $settings['spam_light']))
	{
		$_SESSION['spam_trigger_story_error'] = 'moderated';
		$linkres->status = 'moderated';
	}
}

function spam_trigger_do_submit3($vars)
{
	global $db, $current_user;

	if (checklevel('moderator') || checklevel('admin')) return;
	$linkres = $vars['linkres'];
	if (!$linkres->id) return;

	$settings = get_spam_trigger_settings();

	$str = $linkres->title."\n".$linkres->content."\n".$linkres->link_summary."\n".$linkres->tags;
	// Killspam user
	if ($settings['spam_hard'] && !spam_trigger_check($str, $settings['spam_hard']))
	{
		$_SESSION['spam_trigger_story_error'] = 'deleted';
		spam_trigger_killspam($current_user->user_id);
		$linkres->status = 'spam';
	}
	// discard story
	elseif ($settings['spam_medium'] && !spam_trigger_check($str, $settings['spam_medium']))
	{
		$_SESSION['spam_trigger_story_error'] = 'discarded';
		$linkres->status = 'discard';
	}
	// set status to moderated
	elseif ($settings['spam_light'] && !spam_trigger_check($str, $settings['spam_light']))
	{
		$_SESSION['spam_trigger_story_error'] = 'moderated';
		$linkres->status = 'moderated';
	}
}

function spam_trigger_comment($vars)
{
	global $db, $current_user;

	$settings = get_spam_trigger_settings();

	$str = $_POST['comment_content'];
	// Killspam user
	if ($settings['spam_hard'] && !spam_trigger_check($str, $settings['spam_hard']))
	{
		$_SESSION['spam_trigger_story_error'] = 'deleted';
		spam_trigger_killspam($current_user->user_id);
		$vars['error'] = 1;
	}
	// delete comment
	elseif ($settings['spam_medium'] && !spam_trigger_check($str, $settings['spam_medium']))
	{
		$_SESSION['spam_trigger_story_error'] = 'deleted';
		$vars['error'] = 1;
	}
	// set status to moderated
	elseif ($settings['spam_light'] && !spam_trigger_check($str, $settings['spam_light']))
	{
		$_SESSION['spam_trigger_comment_error'] = 'moderated';
		$vars['status'] = 'moderated';
	}
}

function spam_trigger_killspam($id)
{
	global $db, $current_user;
#	include_once(mnminclude.'link.php');
#	include_once(mnminclude.'votes.php');
	$oldlevel = $current_user->user_level;
	$current_user->user_level = 'admin';
	killspam($id);
	$current_user->user_level = $oldlevel;
	return;

	$db->query('UPDATE `' . table_users . "` SET user_enabled=0, `user_pass` = '63205e60098a9758101eeff9df0912ccaaca6fca3e50cdce3', user_level='Spammer' WHERE `user_id` = $id");
	$db->query('UPDATE `' . table_links . '` SET `link_status` = "discard" WHERE `link_author` = "'.$id.'"');

	$results = $db->get_results("SELECT comment_id, comment_link_id FROM `" . table_comments . "` WHERE `comment_user_id` = $id");
	if ($results)
	    foreach ($results as $result)
	    {
		$comment_id = $result->comment_id;
		$db->query('DELETE FROM `' . table_comments . '` WHERE `comment_id` = "'.$comment_id.'"');
		$db->query('DELETE FROM `' . table_comments . '` WHERE `comment_parent` = "'.$comment_id.'"');
		$link = new Link;
		$link->id=$result->comment_link_id;
		$link->read();
		$link->recalc_comments();
		$link->store();
	    }
	$results = $db->get_results("SELECT vote_id,vote_link_id FROM `" . table_votes . "` WHERE `vote_user_id` = $id");
	if ($results)
	    foreach ($results as $result)
	    {
		$db->query('DELETE FROM `' . table_votes . '` WHERE `vote_id` = "'.$result->vote_id.'"');
		$link = new Link;
		$link->id=$result->vote_link_id;
		$link->read();

		$vote = new Vote;
		$vote->type='links';
		$vote->link=$result->vote_link_id;

		if(Voting_Method == 1){
			$link->votes=$vote->count();
			$link->reports = $link->count_all_votes("<0");
		} elseif(Voting_Method == 2) {
			$link->votes=$vote->rating();
			$link->votecount=$vote->count();
			$link->reports = $link->count_all_votes("<0");
		}
		$link->store_basic();
		$link->check_should_publish();
	    }
	$db->query('DELETE FROM `' . table_saved_links . '` WHERE `saved_user_id` = "'.$id.'"');
	$db->query('DELETE FROM `' . table_trackbacks . '` WHERE `trackback_user_id` = "'.$id.'"');
	$db->query('DELETE FROM `' . table_friends . '` WHERE `friend_id` = "'.$id.'"');
	$db->query('DELETE FROM `' . table_messages . "` WHERE `sender`=$id OR `receiver`=$id");
}

function spam_trigger_check($text, $wordlist)
{
	$words = explode("\n",$wordlist);
	foreach ($words as $word)
	{
	    $word = trim(str_replace("\r","",$word));
    	    if (strlen($word) && preg_match('/(^|[^\w])('.$word.')($|[^\w])/i',$text))
		return false;
	}
	return true;
}

// 
// Read module settings
//
function get_spam_trigger_settings()
{
    return array(
		'spam_light' => get_misc_data('spam_trigger_light'), 
		'spam_medium' => get_misc_data('spam_trigger_medium'), 
		'spam_hard' => get_misc_data('spam_trigger_hard')
		);
}
?>