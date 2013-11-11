<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

if(isset($_REQUEST["role"])){
		
	$id = $_REQUEST["id"];
	$userid = $_REQUEST["userid"];
	if(!is_numeric($id) || !is_numeric($userid)){die();}
	$role = $db->escape($_REQUEST["role"]);

	if ($userid == $current_user->user_id) die();

	$sql = "UPDATE " . table_group_member . " set member_role='".$role."' WHERE member_user_id 	=".$userid." and member_group_id =".$id."";
	//echo $sql;
	$db->query($sql);
	//page redirect
	$redirect = '';
	
	$grup_sql="SELECT group_safename FROM " . table_groups . " WHERE group_id = $id";
	$group_details=$db->get_row($grup_sql);
	
	
	//echo $redirect = getmyurl("group_story", $id);
	$redirect =  getmyurl('group_story2', $group_details->group_safename, 'members');
	header("Location: $redirect");
	//$db->query("UPDATE " . table_group_member . " set member_role='".$role."' WHERE member_user_id 	=".$userid." and member_group_id 	=".$id."");
	die;
}
?>