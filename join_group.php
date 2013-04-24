<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'group.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

//to join and unjoin the group
if(isset($_REQUEST['id']))
{
	$gid = $_REQUEST['id'];
	$privacy = $_REQUEST['privacy'];
	if($_REQUEST['join'] == "true"){
		joinGroup($gid,$privacy);
	}
	if($_REQUEST['join'] == "false"){
		unjoinGroup($gid,$privacy);
	}
	//page redirect
	$redirect = '';
	$redirect = getmyurl("group_story", $gid);
	header("Location: $redirect");
	die;
}
//to activate the group from mail link
if( $_REQUEST['activate'] == 'true')
{
	$member_status = 'active';
	$group_id = $_REQUEST['group_id'];
	$user_id = $_REQUEST['user_id'];
	if (!is_numeric($user_id) || !is_numeric($group_id)) die();
	
	$canIhaveAccess = checklevel('admin');
	if (!$canIhaveAccess) {
	    $owner = $db->get_var("SELECT group_creator FROM " . table_groups . " WHERE group_id = $group_id");
	    $canIhaveAccess = ($owner == $current_user->user_id);
	    if (!$canIhaveAccess) {
		$member = $db->get_row("SELECT * FROM " . table_group_member . " WHERE member_group_id = $group_id AND member_user_id = '".$current_user->user_id ."' " );
		$canIhaveAccess = ($member->member_status=='active' && $member->member_role=='moderator');
	    }
	}
	if (!$canIhaveAccess) die("You don't have enough rights");

	//check for request
	$request_exists = $db->get_row("SELECT * FROM " . table_group_member . " WHERE member_user_id = $user_id");
	
	if($request_exists)
	{
		global $db, $current_user;
		$sql = "update ". table_group_member ."  set member_status = '".$member_status."' where member_user_id = ".$user_id." and member_group_id = ".$group_id." ";
		//echo $sql;
		$result1 = $db->query($sql);
		
		//update count
		$member_count = get_group_members($group_id);
		$member_update = "update ". table_groups ." set group_members = '".$member_count."' where group_id = '".$group_id."'";
		$results1 = $db->query($member_update);
	}
	//page redirect
	$requestTitle = $db->get_var("SELECT group_safename FROM " . table_groups . " WHERE group_id = $group_id");
	$redirect = str_replace("&amp;","&",getmyurl('group_story2', $requestTitle, 'members'));
	header("Location: $redirect");
	die;
}
//to deactivate the group from mail link
if($_REQUEST['activate'] == 'false')
{
	//sets the user in inactive state itself
	$member_status = 'inactive';
	$group_id = $_REQUEST['group_id'];
	$user_id = $_REQUEST['user_id'];
	if (!is_numeric($user_id) || !is_numeric($group_id)) die();
	
	$canIhaveAccess = checklevel('admin');
	if (!$canIhaveAccess) {
	    $owner = $db->get_var("SELECT group_creator FROM " . table_groups . " WHERE group_id = $group_id");
	    $canIhaveAccess = ($owner == $current_user->user_id);
	    if (!$canIhaveAccess) {
		$member = $db->get_row("SELECT * FROM " . table_group_member . " WHERE member_group_id = $group_id AND member_user_id = '".$current_user->user_id ."' " );
		$canIhaveAccess = ($member->member_status=='active' && $member->member_role=='moderator');
	    }
	}
	if (!$canIhaveAccess) die("You don't have enough rights");

	//check for request
	$request_exists = $db->get_row($sql = "SELECT * FROM " . table_group_member . " WHERE member_user_id = $user_id");
	
	if($request_exists)
	{
		global $db, $current_user;
		$sql = "update ". table_group_member ."  set member_status = '".$member_status."' where member_user_id = ".$user_id." and member_group_id = ".$group_id." ";
		//echo $sql;
		$result1 = $db->query($sql);
		
		//update count
		$member_count = get_group_members($group_id);
		$member_update = "update ". table_groups ." set group_members = '".$member_count."' where group_id = '".$group_id."'";
		$results1 = $db->query($member_update);
	}
	//page redirect
	$requestTitle = $db->get_var("SELECT group_safename FROM " . table_groups . " WHERE group_id = $group_id");
	$redirect = str_replace("&amp;","&",getmyurl('group_story2', $requestTitle, 'members'));
	header("Location: $redirect");
	die;
}
//to withdraw join group request
if( $_REQUEST['activate'] == 'withdraw')
{
	$group_id = $_REQUEST['group_id'];
	$user_id = $_REQUEST['user_id'];
	if (!is_numeric($user_id) || !is_numeric($group_id)) die();
	//check for request
	$request_exists = $db->get_row("SELECT * FROM " . table_group_member . " WHERE member_user_id = $user_id");
	
	if($request_exists)
	{
		global $db, $current_user;
		$sql2 = "delete from ". table_group_member ." where member_user_id = ".$user_id." and member_group_id = ".$group_id." ";
		//echo $sql;
		$result1 = $db->query($sql2);
	}	
	//page redirect
	$redirect = '';
	$redirect = getmyurl("group_story", $group_id);
	header("Location: $redirect");
	die;
}
//to activate the group from mail link
if(in_array($_REQUEST['action'],array('published','new','discard')))
{
	$linkid = $_REQUEST['link'];
	if (!is_numeric($linkid)) die();
	
	//update the field group_vote_to_publish
	$sql = "UPDATE " . table_links . " set link_group_status='{$_REQUEST['action']}' WHERE link_id=$linkid";
	
	//update the link status
	//$sql = "UPDATE " . table_links . " set link_status='published' WHERE link_id=$linkid";
	$db->query($sql);
	//page redirect
	//$redirect = '';
	//$redirect = getmyurl("group_story", $group_id);
	//header("Location: $redirect");
}
?>