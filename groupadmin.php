<?php
include_once('Smarty.class.php');
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
	$sql = "UPDATE " . table_group_member . " set member_role='".$role."' WHERE member_user_id 	=".$userid." and member_group_id =".$id."";
	//echo $sql;
	$db->query($sql);
	//page redirect
	$redirect = '';
	$redirect = getmyurl("group_story", $id);
	header("Location: $redirect");
	//$db->query("UPDATE " . table_group_member . " set member_role='".$role."' WHERE member_user_id 	=".$userid." and member_group_id 	=".$id."");
	die;
}
?>