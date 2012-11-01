<?php
	include_once('internal/Smarty.class.php');
	$main_smarty = new Smarty;
	
	include('config.php');
	include(mnminclude.'html1.php');
	include(mnminclude.'link.php');
	include(mnminclude.'tags.php');
	include(mnminclude.'user.php');
	include(mnminclude.'smartyvariables.php');
	
	$users_display = "";
	
	$start_up = isset($_REQUEST['start_up'])? $_REQUEST['start_up'] : "";
	$page_size = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : "";
	
	
$users = $db->get_results("SELECT user_karma, COUNT(*) FROM " . table_users . " WHERE user_karma > 0 $whether_to_show_user GROUP BY user_karma ORDER BY user_karma DESC", ARRAY_N);
	
	$ranklist = array();
	$rank = 1;
	if ($users)
		foreach ($users as $dbuser)
		{
			$ranklist[$dbuser[0]] = $rank;
			$rank += $dbuser[1];
		}
		
		
	$users = $db->get_results("SELECT user_id FROM pligg_users WHERE user_karma > 0 AND user_enabled = 1 AND user_level <> 'Spammer' AND (user_login != 'anonymous' OR user_lastip) ORDER BY user_karma DESC LIMIT $start_up, $page_size");
	
	$user = new User;
	
	if ($users) {
	
		foreach($users as $dbuser) {
			
			$user->id=$dbuser->user_id;
			$user->read();
			$user->all_stats();
			
			$main_smarty->assign('user_userlink', getmyurl("user", $user->username));
			$main_smarty->assign('user_username', $user->username);
			$main_smarty->assign('user_total_links', $user->total_links);
			$main_smarty->assign('user_published_links', $user->published_links);
			if($user->total_links>0) 
				$main_smarty->assign('user_published_links_percent', intval($user->published_links/$user->total_links*100));
			else
				$main_smarty->assign('user_published_links_percent', '');
			$main_smarty->assign('user_total_comments', $user->total_comments);
			$main_smarty->assign('user_total_votes', $user->total_votes);
			$main_smarty->assign('user_published_votes', $user->published_votes);
			if($user->total_votes>0) 
				$main_smarty->assign('user_published_votes_percent', intval($user->published_votes/$user->total_votes*100));
			else
				$main_smarty->assign('user_published_votes_percent', '');
			$main_smarty->assign('user_karma', $user->karma);
			$main_smarty->assign('user_rank', $ranklist[$user->karma]);
			$main_smarty->assign('user_avatar', get_avatar('small', "", $user->username, $user->email));
			
			echo $users_table = $main_smarty->fetch(The_Template . "/topusers_data.tpl");
		}
	}
?>