<?php
session_start();

$_SERVER["SCRIPT_NAME"] = str_replace('/modules/status', '', $_SERVER["SCRIPT_NAME"]);
chdir('../../');
include_once('internal/Smarty.class.php');
$main_smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include_once(mnminclude.'utils.php');
include(mnminclude.'search.php');
include(mnminclude.'user.php');
include(mnminclude.'group.php');
include(mnminclude.'smartyvariables.php');
include_once(mnmmodules . 'status/status_main.php');

// sidebar
$main_smarty = do_sidebar($main_smarty);

// pagename	
define('pagename', 'status'); 
$main_smarty->assign('pagename', pagename);

$isadmin = checklevel('admin');
$isadmin = checklevel('moderator');

if (is_numeric($_GET['lid']) && $_GET['action']=='likes')
{
	$results = $db->get_results("SELECT * FROM ".table_prefix."likes WHERE like_update_id='{$_GET['lid']}'");
	$user = new User;
	foreach ($results as $row)
	{
		$user->id = $row->like_user_id;
		if ($user->read())
		    print $user->username."<br>\n";
	}
    	exit;
}
elseif (is_numeric($_GET['id']))
{
	$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM ".table_prefix."updates a
			LEFT JOIN ".table_prefix."likes ON like_user_id={$current_user->user_id} AND like_update_id=update_id
			LEFT JOIN ".table_friends." b ON a.update_user_id=b.friend_to
			LEFT JOIN ".table_users." c ON a.update_user_id=c.user_id
			WHERE update_id={$_GET['id']}";
	$update = $db->get_row($sql);
	if ($update->update_id && $update->user_level!='Spammer')
	{
		$main_smarty->assign('posttitle','Status Update #'.$_GET['id']);
		$main_smarty->assign('update',get_object_vars ($update));
		$main_smarty->assign('settings',$settings=get_status_settings());
		$main_smarty->assign('current_user', get_object_vars($current_user));
		$main_smarty->assign('current_username', '@'.$current_user->user_login);
		$main_smarty->assign('tpl_center', '../modules/status/templates/status_permalink');
		$main_smarty->display($the_template . '/pligg.tpl');		
		exit;
	}
	else 
	{
		$main_smarty->assign('tpl_center', 'error_404_center');
		$main_smarty->display($the_template . '/pligg.tpl');		
		die();
	}
}


$user = new User;
$user->id = $current_user->user_id;
if (get_misc_data('status_switch')=='1' && $user->read() && status_is_allowed($user) && $user->extra_field['status_switch']) // && strstr(get_misc_data('status_profile_level'),$current_user->user_level))
{
// Post an update (reply)
if ($_POST['status'])
{
    unset($_SESSION['status_error']);
    $_SESSION['status_text'] = $_POST['status'];

    if (!$isadmin)
        $text  = sanitize($_POST['status'],3);
    else
        $text  = mysql_real_escape_string(close_tags($_POST['status']));

    // Post to a group
    if (enable_group && ($groupname = strstr($text,'!')))
    {
	$groupname = substr($groupname,1);
	// Check if user is allowed to post to the group
	$groups = $db->get_results("SELECT * FROM ".table_groups." WHERE group_status='Enable' ORDER BY group_name DESC");
	foreach ($groups as $group)
	if (strpos($groupname,$group->group_name)===0)
	{
	    $group_id = $group->group_id;
	    break;
	}
	if ($group_id && isMemberActive($group_id)!='active')
	    $_SESSION['status_error'] = '<div class="error_message">You are not a member of the group "'.$group->group_name.'"</div>';
    }

    // Post to all users
    if (preg_match('/\*(\w+)/',$text,$m))
    {
	$level = strtolower($m[1]);
	if ($isadmin)
	{
	    // Admin can message all existing levels
	    $levels = $db->get_results("SELECT DISTINCT user_level FROM ".table_users);
	    foreach ($levels as $l)
		if ($l->user_level == $level)
		    break;
	    if ($l->user_level!=$level && $level!='all')
		$_SESSION['status_error'] = '<div class="error_message">There is no such user level "'.$level.'"</div>';
	    else
	    	$level_sql = "update_level='$level',";
	}
	// Admins can message to admins and moderators
	elseif ($isadmin && in_array($level,array('admin','moderator')))
	    $level_sql = "update_level='$level',";
    }

    // Limit text size if needed
    $limit = get_misc_data('status_max_chars');
    if ($limit > 0)
 	    $text  = substr($text,0,$limit);
    $id = is_numeric($_POST['id']) ? $_POST['id'] : 0;

    if (!$_SESSION['status_error'])
    {
    	unset($_SESSION['status_text']);
	$db->query($sql="INSERT INTO ".table_prefix."updates SET update_time=UNIX_TIMESTAMP(), 
							    update_type='m',
							    update_user_id='{$current_user->user_id}',
							    update_link_id='$id',
							    update_group_id='$group_id',
							    $level_sql
							    update_text='$text'");
	$newid = $db->insert_id;
	// Send email notifications
	if (get_misc_data('status_email'))
	{
    	    $main_smarty->config_load('../modules/status/lang.conf');

	    // To specified user
	    if (preg_match_all('/@([^\s]+)/',$text,$m))
		$users = $m[1];
	    else
		$users = array();
	    foreach ($users as $username)
	    {
		// Notify mentioned user by email
		$user = new User;
		$user->username = $username;
		if ($user->read() && $user->extra_field['status_email'])
		{
		    $subject = $main_smarty->get_config_vars('PLIGG_Status_Email_Subject');
		    $body = sprintf( $main_smarty->get_config_vars('PLIGG_Status_Email_Body'),
					$current_user->user_login,
					my_base_url.getmyurl('user2', $current_user->user_login, 'profile').'#'.$newid);
		    $headers = 'From: ' . $main_smarty->get_config_vars("PLIGG_Status_From") . "\r\n";
		    $headers .= "Content-type: text/html; charset=utf-8\r\n";

		    mail($user->email, $subject, $body, $headers);
		}
	    }
	}
    }
}
// Delete update
elseif (is_numeric($_GET['did']))
{
    if ($isadmin || $isadmin)
  	$db->query("DELETE FROM ".table_prefix."updates WHERE update_id='{$_GET['did']}'");
    else
  	$db->query("DELETE FROM ".table_prefix."updates WHERE update_id='{$_GET['did']}' AND update_user_id='{$current_user->user_id}'");
}
// Like/dislike
elseif (is_numeric($_GET['lid']))
{
    if ($db->query("INSERT INTO ".table_prefix."likes SET like_update_id='{$_GET['lid']}', like_user_id='{$current_user->user_id}'"))
    	$db->query("UPDATE ".table_prefix."updates SET update_likes=update_likes+1 WHERE update_id='{$_GET['lid']}'");
    else
    {
        $db->query("DELETE FROM ".table_prefix."likes WHERE like_update_id='{$_GET['lid']}' AND like_user_id='{$current_user->user_id}'");
    	$db->query("UPDATE ".table_prefix."updates SET update_likes=update_likes-1 WHERE update_id='{$_GET['lid']}'");
    }
    $count = $db->get_var("SELECT COUNT(*) FROM ".table_prefix."likes WHERE like_update_id='{$_GET['lid']}'");
    print $count;
    exit;
}
// Hide update
elseif (is_numeric($_GET['hid']))
{
  	$db->query("UPDATE ".table_users." SET status_excludes=IF(status_excludes!='',CONCAT(status_excludes,'".','.$_GET['hid']."'),'".$_GET['hid']."') WHERE user_id='{$current_user->user_id}'");
}
}

if ($_SERVER['HTTP_REFERER'])
    header("Location: ".$_SERVER['HTTP_REFERER']);
else
    header("Location: ".getmyurl('user2', $current_user->user_login, 'profile'));
?>
