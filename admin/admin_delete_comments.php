<?php
include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

check_referrer();

// require user to log in
force_authentication();

// restrict access to god only
$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');

if($canIhaveAccess == 0){	
	header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	die();
}


function delete_comment($key) {
    global $db;
    if (!is_numeric($key)) return;
   
	$link_id = $db->get_var("SELECT comment_link_id FROM `" . table_comments . "` WHERE `comment_id` = ".$key.";");
	
	$vars = array('comment_id' => $key);
	check_actions('comment_deleted', $vars);

	$comments = $db->get_results($sql="SELECT comment_id FROM " . table_comments . " WHERE `comment_parent` = '$key'");
	foreach($comments as $comment)
	{
	   	$vars = array('comment_id' => $comment->comment_id);
	   	check_actions('comment_deleted', $vars);
	}
	$db->query('DELETE FROM `' . table_comments . '` WHERE `comment_parent` = "'.$key.'"');
	$db->query('DELETE FROM `' . table_comments . '` WHERE `comment_id` = "'.$key.'"');

	$link = new Link;
	$link->id=$link_id;
	$link->read();
	$link->recalc_comments();
	$link->store();
}

$sql_query = "SELECT comment_id FROM " . table_comments . " WHERE comment_status = 'discard'";
$result = mysql_query($sql_query);
$num_rows = mysql_num_rows($result);
while($comment = mysql_fetch_object($result))
        delete_comment($comment->comment_id);
echo '<div style="padding:8px;margin:14px 2px;border:1px solid #bbb;background:#eee;">';
echo '	<h2 style="font-size: 18px;margin:0;padding:0;border-bottom:1px solid #629ACB;">'. $num_rows. ' '.$main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Discarded_Comments_Removed").'</h2>';

$query = "OPTIMIZE TABLE comments";
mysql_query($query);
if (mysql_error()){
	echo '	<p style=\'font:13px arial, "Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;\'>'.mysql_error().'</p>';
}else{
	echo '	<p style=\'font:13px arial, "Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;\'>'.$main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Discarded_Comments_Removed_Message").'</p>';
}
echo '	<p style=\'font:13px arial, "Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;\'><a style="color:#094F89;" href="admin_index.php" onclick="parent.$.fn.colorbox.close(); return false;">'.$main_smarty->get_config_vars("PLIGG_Visual_AdminPanel_Return_Comment_Management").'</a></p>';
echo '</div>';

?>