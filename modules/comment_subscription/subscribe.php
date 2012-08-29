<?php
// Tested 04/11/11
chdir('../');
include_once('../internal/Smarty.class.php');$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include_once(mnminclude.'utils.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$link_id = $db->escape($_REQUEST['linkid']);
$link_shakebox_index = $db->escape($_REQUEST['htmlid']);
if (!$link_id) return;

$rcode=$db->escape(trim($_GET['code']));
$username=$db->escape(trim($_GET['uid']));

// Load settings
include_once(mnmmodules.'comment_subscription/comment_subscription_settings.php');

$smarty = new Smarty;
$smarty->config_load('/../../'.comment_subscription_lang_conf);

// Unsubscription link from email
if ($_GET['unsub'])
{
	$result = $db->get_row ("SELECT * FROM " . table_users . " WHERE user_login = '$username'");
	if($result)
	{
	    $decode=md5($result->user_email . $result->user_karma .  $username. pligg_hash());
	    if($rcode==$decode)
	    {
		$linkres=new Link;
		$linkres->id = $link_id;
		if ($linkres->read())
		{
			// Unsibscribe
			$db->query("DELETE FROM `".table_prefix . "csubscription` WHERE subs_user_id={$result->user_id} AND subs_link_id='$link_id'");
	
			// Show the message
			$main_smarty->assign('link', get_object_vars($linkres));
			$main_smarty->assign('story_url', $linkres->get_internal_url());
			$main_smarty->assign('message', $smarty->get_config_vars('PLIGG_Comment_Subscription_Unsubscribed_Message'));
		}		
	        else
			$main_smarty->assign('error', $smarty->get_config_vars('PLIGG_Comment_Subscription_Invalid_Code'));
	    }
	    else
		$main_smarty->assign('error', $smarty->get_config_vars('PLIGG_Comment_Subscription_Invalid_Code'));
	}
	else
	    $main_smarty->assign('error', $smarty->get_config_vars('PLIGG_Comment_Subscription_No_User'));


	define('pagename', 'story'); 
	$main_smarty->assign('pagename', pagename);
	$main_smarty = do_sidebar($main_smarty);

	$main_smarty->assign('tpl_center', comment_subscription_tpl_path . '/unsubscribe');    
	$main_smarty->display($the_template . '/pligg.tpl');
}
// Unsubscribe from story page
elseif ($_REQUEST['uns'])
{
    $db->query("DELETE FROM `".table_prefix . "csubscription` WHERE subs_user_id={$current_user->user_id} AND subs_link_id='$link_id'");
    print "<a href=\"javascript://\" onclick=\"comment_subscribe({$link_shakebox_index},{$link_id});\" style=\"border:0;\">".$smarty->get_config_vars('PLIGG_Comment_Subscription_Subscribe')."</a>";
}
// Subscribe from story page
else
{
    $db->query("INSERT IGNORE INTO `".table_prefix . "csubscription` SET subs_user_id={$current_user->user_id}, subs_link_id='$link_id'");
    print "<a href=\"javascript://\" onclick=\"comment_subscribe({$link_shakebox_index},{$link_id},1);\" style=\"border:0;\">".$smarty->get_config_vars('PLIGG_Comment_Subscription_Unsubscribe')."</a>";
}
?>
