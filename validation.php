<?php

include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include(mnminclude.'smartyvariables.php');

// Get values from the end user
$rcode=$db->escape(trim($_GET['code']));
$username=$db->escape(trim($_GET['uid']));

// Retrieve values from database
$user=("SELECT user_email, user_pass, user_karma, user_lastlogin FROM " . table_users . " WHERE user_login = '$username'");
global $db;
$result = $db->get_row ($user);
if($result)
    if($_GET['email'])
	$decode=md5($_GET['email'] . $result->user_karma .  $username. pligg_hash().$main_smarty->get_config_vars('PLIGG_Visual_Name'));
    else
	$decode=md5($result->user_email . $result->user_karma .  $username. pligg_hash().$main_smarty->get_config_vars('PLIGG_Visual_Name'));
else
	$main_smarty->assign('error', $main_smarty->get_config_vars('PLIGG_Validation_No_Results'));

// Compare values
if($rcode==$decode)
{
	$lastlogin = $db->get_var("SELECT user_lastlogin FROM " . table_users . " WHERE user_login = '$username'");
	if($lastlogin == "0000-00-00 00:00:00"){
		$login_url=getmyurl("loginNoVar");
		$message = sprintf($main_smarty->get_config_vars('PLIGG_Validation_Message'),$login_url);
		$main_smarty->assign('message', $message);

		$sql="UPDATE " . table_users . " SET user_lastlogin = now() WHERE user_login='$username'";
		if(!@mysql_query($sql))
			$main_smarty->assign('error', $main_smarty->get_config_vars('PLIGG_Validation_Mysql_Error'));
	}
	elseif($_GET['email'] && $_GET['email']!=$result->user_email)
	{
		$login_url=getmyurl("loginNoVar");
		$message = sprintf($main_smarty->get_config_vars('PLIGG_Validation_Message'),$login_url);
		$main_smarty->assign('message', $message);

		$sql="UPDATE " . table_users . " SET user_email = '".mysql_real_escape_string($_GET['email'])."' WHERE user_login='$username'";
		if(!@mysql_query($sql))
			$main_smarty->assign('error', $main_smarty->get_config_vars('PLIGG_Validation_Mysql_Error'));
	}
	else
		$main_smarty->assign('error', $main_smarty->get_config_vars('PLIGG_Validation_Already_Activated'));
}
else
	$main_smarty->assign('error', $main_smarty->get_config_vars('PLIGG_Validation_Invalid_Code'));

define('pagename', 'validation'); 
$main_smarty->assign('pagename', pagename);

do_sidebar($main_smarty);

$main_smarty->assign('tpl_center', $the_template . '/user_validation_center');
$main_smarty->display($the_template . '/pligg.tpl');
?>