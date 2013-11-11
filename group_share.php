<?php

include_once('internal/Smarty.class.php');
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
    $group_id = $_GET['group_id'];
    $link_id = $_GET['link_id'];
    if (!is_numeric($group_id)) die();
    if (!is_numeric($link_id)) die();

    $role = $db->get_var("SELECT member_role FROM " . table_group_member . " WHERE member_group_id = $group_id AND member_user_id = '".$current_user->user_id ."'" );
    if ($role == 'banned') die();

    $privacy = $db->get_var("SELECT group_privacy FROM " . table_groups . " WHERE group_id = '$group_id';");
    if (($privacy!='private' || isMemberActive($group_id)=='active'))
    {
		global $db, $current_user;
		$current_userid = $current_user->user_id;

		$sql = "INSERT IGNORE INTO ". table_group_shared ." ( `share_link_id` , `share_group_id`, `share_user_id` ) VALUES ('".$link_id."', '".$group_id."','".$current_userid."' ) ";
		//echo $sql;
		$results = $db->query($sql);
		$redirect = '';
		$redirect = getmyurl("group_story", $group_id);
		header("Location: $redirect");
    } else {
		$redirect = getmyurl("groups");
		header("Location: $redirect");
    }
}
?>