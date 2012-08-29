<?php

include_once('Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'group.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

if (isset($_GET['link_id']) && isset($_GET['group_id']))
{
	global $db, $current_user;
	//$isMember = isMember($story_id);
	$current_userid = $current_user->user_id;
	$group_id = $_GET['group_id'];
	$link_id = $_GET['link_id'];
	if (!is_numeric($group_id)) die();
	if (!is_numeric($link_id)) die();

	$sql = "INSERT IGNORE INTO ". table_group_shared ." ( `share_link_id` , `share_group_id`, `share_user_id` ) VALUES ('".$link_id."', '".$group_id."','".$current_userid."' ) ";
	//echo $sql;
	$results = $db->query($sql);
	$redirect = '';
	$redirect = getmyurl("group_story", $group_id);
	header("Location: $redirect");
}
?>
