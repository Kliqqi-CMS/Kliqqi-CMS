<?php
function joinGroup($group_id,$privacy)
{
	global $db, $current_user,$main_smarty,$the_template,$my_base_url,$my_pligg_base;
	if (!is_numeric($group_id)) die();

	// Enforce "Max Joinable Groups" config option
	if (reached_max_joinable_groups($db, $current_user))
		return;

	$privacy = $db->get_var("SELECT group_privacy FROM " . table_groups . " WHERE group_id = $group_id");
	if($privacy == 'public')
		$member_status = 'active';
	else
		$member_status = 'inactive';

        if (isMember($group_id)) return;
        
	$sql = "INSERT IGNORE INTO ". table_group_member ." ( `member_user_id` , `member_group_id`, `member_role`,`member_status` ) VALUES ('".$current_user->user_id ."', '".$group_id."','normal','".$member_status."' ) ";
	$db->query($sql);
	
	//member count update increase
	if(isMemberActive($group_id) == 'active')
	{
		$member_count = get_group_members($group_id);
		$member_update = "update ". table_groups ." set group_members = '".$member_count."' where group_id = '".$group_id."'";
		$db->query($member_update);
	}
	if($privacy != 'public')
	{
		$creator_id = get_group_creator($group_id);
		$to = get_group_user_email($creator_id);

		$subject = $main_smarty->get_config_vars('PLIGG_Visual_Group_Email_Subject');
		$body = sprintf(  $main_smarty->get_config_vars('PLIGG_Visual_Group_Email_Body'),
					my_base_url.getmyurl("user", $current_user->user_login),
					$current_user->user_login,
					my_base_url.my_pligg_base."/join_group.php?activate=true&group_id=".$group_id."&user_id=".$current_user->user_id,
					my_base_url.my_pligg_base."/join_group.php?activate=false&group_id=".$group_id."&user_id=".$current_user->user_id);
		$headers = 'From: ' . $main_smarty->get_config_vars("PLIGG_PassEmail_From") . "\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";

		mail($to, $subject, $body, $headers);
	}
}
function unjoinGroup($group_id,$privacy)
{
	global $db, $current_user;
	if (!is_numeric($group_id)) die();

	//$isMember = isMember($story_id);if($privacy == 'public')
	$sql2 = "delete from ". table_group_member ." where member_user_id = '".$current_user->user_id ."' and member_group_id = '".$group_id."' ";
	$db->query($sql2);

	//member count update decrease
	
	$member_count = get_group_members($group_id);
	$member_update = "update ". table_groups ." set group_members = '".$member_count."' where group_id = '".$group_id."' ";
	$db->query($member_update);
}
function isMember($group_id)
{
	global $db, $current_user;
	if (!is_numeric($group_id)) die();

	return $db->get_var("SELECT count(*) FROM " . table_group_member . " WHERE member_group_id = $group_id AND member_user_id = '".$current_user->user_id ."' " );
}
function isMemberActive($group_id)
{
	global $db, $current_user;
	if (!is_numeric($group_id)) die();

	return $db->get_var("SELECT member_status FROM " . table_group_member . " WHERE member_group_id = $group_id AND member_user_id = '".$current_user->user_id ."' " );
}
function get_group_members($group_id)
{
	global $db;
	if (!is_numeric($group_id)) die();

	$gid = $group_id;
	//$creator = $db->get_row("SELECT group_members FROM " . table_groups . " WHERE group_id = $gid");
	return $db->get_var("SELECT COUNT(*) FROM " . table_group_member . " WHERE member_group_id = $gid AND member_status = 'active'" );
	//return $creator->group_members;
}
//returns creator id from group id
function get_group_creator($group_id)
{
	global $db;
	if (!is_numeric($group_id)) die();

	$gid = $group_id;
	$creator = $db->get_row("SELECT group_creator FROM " . table_groups . " WHERE group_id = $gid");
	return $creator->group_creator;
}
//to return name from userid
function get_group_username($uid)
{
	$user_id = $uid;
	if (!is_numeric($user_id)) die();

	include_once(mnminclude.'user.php');
	$user = new User;
	$user->id = $user_id;
	$user->read('short');
	return $user->username;
}
//to return name from userid
function get_group_user_email($uid)
{
	$user_id = $uid;
	if (!is_numeric($user_id)) die();

	include_once(mnminclude.'user.php');
	$user = new User;
	$user->id = $user_id;
	$user->read('short');
	return $user->email;
}

//returns the groups of the loggedin user
function get_groupid_user($userid)
{
	global $db,$current_user;
	if (!is_numeric($userid)) die();

		$group_array = array();
// DB 01/08/09
		$groupdetail = $db->get_results("SELECT DISTINCT (group_id) AS group_id FROM " . table_group_member . " WHERE member_user_id =".$userid."");
//		$groupdetail = $db->get_results("SELECT DISTINCT (group_id) AS group_id FROM " . table_group_member . " , " . table_groups . " , ".table_links." WHERE link_group_id = member_group_id AND member_group_id = group_id AND member_user_id =".$userid."");
/////
		$group_array = $groupdetail;
		return $group_array;
		/*
		foreach($groupdetail as $groupcount)
		{
			return $groupcount->group_id;
			array_splice($groupcount, count($grouup_id), 0, $groupcount->group_id);
			//return $group_id_array;
		}	
		*/
}
/*function get_groupname_user()
{
	global $db,$current_user;
	$groupdetail = $db->get_row("SELECT group_name FROM " . table_group_member . " , " . table_groups . " , ".table_links." WHERE link_group_id = member_group_id AND member_group_id = group_id AND member_user_id =1");
	return $groupdetail->group_name;
}*/
function get_groupdetail_user()
{
	global $db,$current_user;
	
// DB 01/08/09
	$groupdetail = $db->get_results("SELECT DISTINCT (group_id) AS group_id,group_name FROM " . table_group_member . " WHERE member_user_id ='".$current_user->user_id ."'");
//	$groupdetail = $db->get_results("SELECT DISTINCT (group_id) AS group_id,group_name FROM " . table_group_member . " , " . table_groups . " , ".table_links." WHERE link_group_id = member_group_id AND member_group_id = group_id AND member_user_id ='".$current_user->user_id ."'");
/////
	return $groupdetail;
}
//returns votes to publish count
function group_check_to_publish($group_id)
{
	global $db;
	if (!is_numeric($group_id)) die();

	$gid = $group_id;
	$group_vote_to_publish = $db->get_row("SELECT group_vote_to_publish FROM " . table_groups . " WHERE group_id = $gid");
	return $group_vote_to_publish->group_vote_to_publish;
}

/** Find out if the user has already joined the maximum allowable number of groups.
 To enforce "Max Joinable Groups" config option. */
function reached_max_joinable_groups($db, $current_user) {
 $user_id = $current_user->user_id;
 if (!is_numeric($user_id)) die();

 $current_memberships = $db->get_var('SELECT COUNT(*) FROM ' . table_group_member 
  . " WHERE member_user_id = '$user_id'");

 return $current_memberships >= max_groups_to_join;
}

//displaying group as story
function group_display($requestID)
{
	global $db,$main_smarty,$the_template;
	if (!is_numeric($requestID)) die();

	$group = $db->get_row("SELECT * FROM " . table_groups . " WHERE group_id = $requestID");
	if($group)
	{
		$group_id=$group->group_id;
		$group_name=$group->group_name;
		$group_safename=$group->group_safename;
		$group_description=$group->group_description;
		$group_creator=$group->group_creator;
		$group_status=$group->group_status;
		$group_members=$group->group_members;
		$group_date=$group->group_date;
		$group_privacy=$group->group_privacy;
		$group_avatar=$group->group_avatar;
		$group_vote_to_publish=$group->group_vote_to_publish;
		$group_notify_email=$group->group_notify_email;
		$date = $db->get_var(" SELECT DATE_FORMAT(group_date, '%b, %e %Y') from ".table_groups . " WHERE group_id = $group->group_id");
		//echo $date;
		$group_date = $date;
		//$group_date = date('M j, Y', $group->group_date);
		
		//smarty variables	
		$main_smarty->assign('pretitle', "$group_name - $group_description");
		$main_smarty->assign('group_id', $group_id);
		$main_smarty->assign('group_name', $group_name);
		$main_smarty->assign('group_safename', $group_safename);
		$main_smarty->assign('group_description', $group_description);
		$main_smarty->assign('group_creator', $group_creator);
		$main_smarty->assign('group_status', $group_status);
		$main_smarty->assign('group_members', $group_members);
		$main_smarty->assign('group_privacy', $group_privacy);
		$main_smarty->assign('group_avatar', $group_avatar);
		$main_smarty->assign('group_date', $group_date);
		$main_smarty->assign('group_notify_email', $group_notify_email);
		$main_smarty->assign('group_vote_to_publish', $group_vote_to_publish);
		
		//get group avatar path
		if($group_avatar == "uploaded" && file_exists(mnmpath."avatars/groups_uploaded/".$group_id."_".group_avatar_size_width.".jpg"))
			$imgsrc = my_base_url . my_pligg_base."/avatars/groups_uploaded/".$group_id."_".group_avatar_size_width.".jpg";
		else
			$imgsrc = my_base_url . my_pligg_base."/templates/".$the_template."/images/group_large.gif";
		$main_smarty->assign('imgsrc', $imgsrc);
		
		//get group creator and his urls
		$g_name = get_group_username($group_creator);
		$main_smarty->assign('group_submitter', $g_name);
		$main_smarty->assign('submitter_profile_url', getmyurl('user', $g_name));
		$main_smarty->assign('group_avatar_url', getmyurl('group_avatar', $group_id));
		
		//check group admin
		global $current_user;
		$canIhaveAccess = $canIhaveAccess + checklevel('god');
		if($current_user->user_id == $group_creator || $canIhaveAccess == 1){$main_smarty->assign('is_group_admin', 1);}
		
		
		//check member
		//include_once(mnminclude.'group.php');
		$main_smarty->assign('is_group_member', isMember($group_id));
		
		//check isMemberActive
		$main_smarty->assign('is_member_active', isMemberActive($group_id));
		
		// Joining and unjoining member links
		// Set the url to an empty string if the user has already joined the maximum
		// allowable number of groups
		if (reached_max_joinable_groups($db, $current_user))
			$join_url = '';
		else
			$join_url = getmyurl('join_group', $group_id, $group_privacy);

		$main_smarty->assign('join_group_url', $join_url);
		$main_smarty->assign('join_group_privacy_url', $join_url);
		
		$main_smarty->assign('unjoin_group_url',getmyurl("unjoin_group",$group_id,$group_privacy));
		$main_smarty->assign('join_group_withdraw',getmyurl("join_group_withdraw",$group_id,$current_user->user_id));
		
		//check logged or not
		$main_smarty->assign('user_logged_in', $current_user->user_login);
		
		//sidebar
		$main_smarty = do_sidebar($main_smarty);	

		//$main_smarty->assign('form_action', $_SERVER["PHP_SELF"]);
		$group_story_url = getmyurl("group_story_title", $group_safename);
		$main_smarty->assign('form_action', $group_story_url);
		$main_smarty->assign('edit_form_action', getmyurl("editgroup", $group_id));
		$group_array = array($group_name, $group_description, $group_privacy);
		return $group_array;
	}
}
//displaying member of a group
function member_display($requestID)
{
	global $db,$main_smarty,$current_user;
	if (!is_numeric($requestID)) die();

	$change_role = $main_smarty->get_config_vars("PLIGG_Visual_Group_Change_Role");
	$role_normal = $main_smarty->get_config_vars("PLIGG_Visual_Group_Role_Normal");
	$role_admin = $main_smarty->get_config_vars("PLIGG_Visual_Group_Role_Admin");
	$role_moderator = $main_smarty->get_config_vars("PLIGG_Visual_Group_Role_Moderator");
	$role_flagged = $main_smarty->get_config_vars("PLIGG_Visual_Group_Role_Flagged");
	$role_banned = $main_smarty->get_config_vars("PLIGG_Visual_Group_Role_Banned");
	$gcreator = get_group_creator($requestID);
	if($gcreator == $current_user->user_id)
		$member = $db->get_results("SELECT * FROM " . table_group_member . " WHERE member_group_id = $requestID");
	else
		$member = $db->get_results("SELECT * FROM " . table_group_member . " WHERE member_group_id = $requestID and member_status = 'active'");
	if($member)
	{
		foreach($member as $memberid)
		{
			$member_user_id = $memberid->member_user_id;
			$member_role = $memberid->member_role;
			
			//role change urls
			$member_adminchange_url = getmyurl('group_admin', $requestID,'admin',$member_user_id);
			$member_normalchange_url = getmyurl('group_normal', $requestID,'normal',$member_user_id);
			$member_moderatorchange_url = getmyurl('group_moderator', $requestID,'moderator',$member_user_id);
			$member_flaggedchange_url = getmyurl('group_flagged', $requestID,'flagged',$member_user_id);
			$member_bannedchange_url = getmyurl('group_banned', $requestID,'banned',$member_user_id);
			
			//get group creator and his url,avatar
			$member_name = get_group_username($member_user_id);
			$group_member_url = getmyurl('user', $member_name);
			$group_member_avatar = get_avatar('large', "", "", "", $member_user_id);
			
			$member_display .= '<a href="' . $group_member_url . '" class="group_member"><img src="' . $group_member_avatar . '" alt="' . $member_name . '" border="0" align="absmiddle" /> ' . $member_name . '</a>';
			if($gcreator == $current_user->user_id)
			{
			    if ($memberid->member_status=='active')
			    {
				if($member_user_id == $current_user->user_id)
					$member_display .= '<span id="groupadminlinksbutton"> <a href="javascript://" onclick=\'var replydisplay=document.getElementById("ls_groupadminlinks-'.$index.'").style.display ? "" : "none";document.getElementById("ls_groupadminlinks-'.$index.'").style.display = replydisplay;\'>'.$change_role.'</a></span><br/>';
				else
					$member_display .= '<span id="groupadminlinksbutton"> <a href="javascript://" onclick=\'var replydisplay=document.getElementById("ls_groupadminlinks-'.$index.'").style.display ? "" : "none";document.getElementById("ls_groupadminlinks-'.$index.'").style.display = replydisplay;\'>'.$change_role.'</a> <a href="'.my_base_url . my_pligg_base . '/join_group.php?activate=false&group_id='.$requestID.'&user_id='.$member_user_id.'">Freeze</a></span><br/>';
			    }
			    else
				$member_display .= '<span id="groupadminlinksbutton"> <a href="'.my_base_url . my_pligg_base . '/join_group.php?activate=true&group_id='.$requestID.'&user_id='.$member_user_id.'">Activate</a></span><br/>';
			}
			$member_display .= '<span id="ls_groupadminlinks-'.$index.'" style="display:none">
					<span class="rolelinks" id="ls_groupadminlinks-'.$index.'">
						<a href="'.$member_adminchange_url.'">'.$role_admin.'</a>
						<a href="'.$member_normalchange_url.'">'.$role_normal.'</a>
						<a href="'.$member_moderatorchange_url.'">'.$role_moderator.'</a>
						<a href="'.$member_flaggedchange_url.'">'.$role_flagged.'</a>
						<a href="'.$member_bannedchange_url.'">'.$role_banned.'</a>
					</span>
				</span><br/><br/>';
				$index=$index+1;
		}
	}
		//echo $member_display;
		$main_smarty->assign('member_display', $member_display);
}
//get the upcoming story for groups
function group_stories($requestID,$catId)
{
	global $db,$main_smarty,$the_template,$page_size,$cached_links;
	if (!is_numeric($requestID)) die();

	$link = new Link;
	$group_upcoming_display = "";
	$group_published_display = "";

	if ($catId) 
        {
		$child_cats = '';
		// do we also search the subcategories? 
		if(! Independent_Subcategories){
			$child_array = '';

			// get a list of all children and put them in $child_array.
			children_id_to_array($child_array, table_categories, $catId);
			if ($child_array != '') {
				// build the sql
				foreach($child_array as $child_cat_id) {
					$child_cat_sql .= ' OR `link_category` = ' . $child_cat_id . ' ';
					if (Multiple_Categories)
						$child_cat_sql .= ' OR ac_cat_id = ' . $child_cat_id . ' ';
				}
			}
		}
		if (Multiple_Categories)
			$child_cat_sql .= " OR ac_cat_id = $catId ";
		$from_where .= " AND (link_category=$catId " . $child_cat_sql . ")";
        }

	$group_vote = group_check_to_publish($requestID);
	if ($_GET['view'] == 'upcoming')
		$from_where .= " AND link_votes<$group_vote AND link_status='queued'";
	else                
		$from_where .= " AND ((link_votes >= $group_vote AND link_status = 'queued') OR link_status = 'published')";

	$offset = (get_current_page()-1)*$page_size;
	$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . table_links . " WHERE link_group_id = $requestID AND link_group_status!='discard' $from_where GROUP BY link_id ORDER BY link_published_date DESC, link_date DESC LIMIT $offset, $page_size";
	// Search on additional categories
	if ($catId && Multiple_Categories)
	    $sql = str_replace("WHERE", " LEFT JOIN ".table_additional_categories. " ON ac_link_id=link_id WHERE", $sql);
	$links = $db->get_results($sql);
   	$rows = $db->get_var("SELECT FOUND_ROWS()");
	if ($links) {
		foreach($links as $dblink) {
			$link->id=$dblink->link_id;
			$cached_links[$dblink->link_id] = $dblink;
			$link->read();
			$group_display .= $link->print_summary('summary', true);
		}
	}
	$main_smarty->assign('group_display', $group_display);
	$main_smarty->assign('group_story_pagination', do_pages($rows, $page_size, 'group_story', true));
}
//get the shared story for groups
function group_shared($requestID,$catId)
{
	global $db,$main_smarty,$the_template, $page_size,$cached_links;
	if (!is_numeric($requestID)) die();

	$link = new Link;
	$group_shared_display = "";
	if ($catId) 
        {
		$child_cats = '';
		// do we also search the subcategories? 
		if(! Independent_Subcategories){
			$child_array = '';

			// get a list of all children and put them in $child_array.
			children_id_to_array($child_array, table_categories, $catId);
			if ($child_array != '') {
				// build the sql
				foreach($child_array as $child_cat_id) {
					$child_cat_sql .= ' OR `link_category` = ' . $child_cat_id . ' ';
					if (Multiple_Categories)
						$child_cat_sql .= ' OR ac_cat_id = ' . $child_cat_id . ' ';
				}
			}
		}
		if (Multiple_Categories)
			$child_cat_sql .= " OR ac_cat_id = $catId ";
		$from_where .= " AND (link_category=$catId " . $child_cat_sql . ")";
        }

	$offset = (get_current_page()-1)*$page_size;
	$sql="SELECT SQL_CALC_FOUND_ROWS b.* FROM " . table_group_shared . " a
				    LEFT JOIN " . table_links . " b ON link_id=share_link_id
				    WHERE share_group_id = $requestID AND !ISNULL(link_id) $from_where 
				    GROUP BY link_id
				    ORDER BY link_published_date DESC, link_date DESC  LIMIT $offset, $page_size";
	// Search on additional categories
	if ($catId && Multiple_Categories)
	    $sql = str_replace("WHERE", " LEFT JOIN ".table_additional_categories. " ON ac_link_id=link_id WHERE", $sql);
	$links = $db->get_results($sql);
   	$rows  = $db->get_var("SELECT FOUND_ROWS()");
	if ($links) {
		foreach($links as $dblink) {
			$link->id=$dblink->link_id;
			$cached_links[$dblink->link_id] = $dblink;
			$link->read();
			$group_shared_display .= $link->print_summary('summary', true);
		}
	}
	$main_smarty->assign('group_shared_display', $group_shared_display);
	$main_smarty->assign('group_story_pagination', do_pages($rows, $page_size, 'group_story', true));
}
//displaying group as story
function group_print_summary($requestID)
{
	global $db,$main_smarty,$the_template;
	if (!is_numeric($requestID)) die();

	$index = 0;
	$group = $db->get_row("SELECT group_id,group_creator, group_status, group_members, group_date, group_name, group_safename, group_description, group_privacy, group_avatar FROM " . table_groups . " WHERE group_id = $requestID");
	if($group)
	{
		$group_id=$group->group_id;
		$group_name=$group->group_name;
		$group_safename=$group->group_safename;
		$group_description=$group->group_description;
		$group_creator=$group->group_creator;
		$group_status=$group->group_status;
		$group_members=$group->group_members;
		$group_date=$group->group_date;
		$group_privacy=$group->group_privacy;
		$group_avatar=$group->group_avatar;
		//$group_date = date('M j, Y', $group->group_date);
		$date = $db->get_var(" SELECT DATE_FORMAT(group_date, '%b, %e %Y') from ".table_groups . " WHERE group_id = $group->group_id");
		//echo $date;
		$group_date = $date;
		
		//smarty variables	
		$main_smarty->assign('group_id', $group_id);
		$main_smarty->assign('group_name', $group_name);
		$main_smarty->assign('group_safename', $group_safename);
		$main_smarty->assign('group_description', $group_description);
		$main_smarty->assign('group_creator', $group_creator);
		$main_smarty->assign('group_status', $group_status);
		$main_smarty->assign('group_members', $group_members);
		$main_smarty->assign('group_privacy', $group_privacy);
		$main_smarty->assign('group_avatar', $group_avatar);
		$main_smarty->assign('group_date', $group_date);
		
		//get group avatar path
		if($group_avatar == "uploaded" && file_exists(mnmpath."avatars/groups_uploaded/".$group_id."_".group_avatar_size_width.".jpg"))
			$imgsrc = my_base_url . my_pligg_base."/avatars/groups_uploaded/".$group_id."_".group_avatar_size_width.".jpg";
		else
			$imgsrc = my_base_url . my_pligg_base."/templates/".$the_template."/images/group_large.gif";
		$main_smarty->assign('imgsrc', $imgsrc);
		
		//get group creator and his url
		$g_name = get_group_username($group_creator);
		$main_smarty->assign('group_submitter', $g_name);
		$submitter_profile_url = getmyurl('user', $g_name);
		$main_smarty->assign('submitter_profile_url', $submitter_profile_url);
		
		$main_smarty->assign('group_avatar_url', getmyurl('group_avatar', $group_id));
		
		//check group admin
		global $current_user;
		if($current_user->user_id == $group_creator){$main_smarty->assign('is_group_admin', 1);}
		
		
		//language
		$lang_Created_By = $main_smarty->get_config_vars("PLIGG_Visual_Group_Created_By");
		$lang_Created_On = $main_smarty->get_config_vars("PLIGG_Visual_Group_Created_On");
		$lang_Member = $main_smarty->get_config_vars("PLIGG_Visual_Group_Member");
		
		//check member
		//include_once(mnminclude.'group.php');
		$main_smarty->assign('is_group_member', isMember($group_id));
		
		// Joining and unjoining member links
		// Set the url to an empty string if the user has already joined the maximum
		// allowable number of groups
		if (reached_max_joinable_groups($db, $current_user))
			$join_url = '';
		else
			$join_url = getmyurl("join_group",$group_id);
		
		$main_smarty->assign('join_group_url',$join_url);
		$main_smarty->assign('unjoin_group_url',getmyurl("unjoin_group",$group_id));
		
		//check logged or not
		$main_smarty->assign('user_logged_in', $current_user->user_login);
		
		//sidebar
		$main_smarty = do_sidebar($main_smarty);	

		//$main_smarty->assign('form_action', $_SERVER["PHP_SELF"]);
		$group_story_url = getmyurl("group_story_title", $group_safename);
		$main_smarty->assign('group_story_url', $group_story_url);
		
		$group_edit_url = getmyurl("editgroup", $group_id);
		$group_delete_url = getmyurl("deletegroup", $group_id);
		
		$group_output .= $main_smarty->fetch(The_Template . '/group_summary.tpl'); 
				
		$index++;
	}
	return $group_output;
}
?>