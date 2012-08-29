<?php
set_time_limit(300);
chdir('../');
include_once('../internal/Smarty.class.php');$main_smarty = new Smarty;

$do_not_include_in_pages_core[] = 'login';
include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include_once(mnminclude.'utils.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

include_once('fb_settings.php');
include_once('fb_main.php');

try {
    $facebook = fb_facebook_client();
    $member_id = $_SESSION['fb_id'] = $facebook->getUser();
    if ($member_id)
	$token = $facebook->getAccessToken();
} catch (Exception $e) {
    error_log($e);
}


// Show the form only if not logged in to Pligg and logged in to Facebook
if ($current_user->authenticated)
{
    if ($_GET['disconnect'])
    {
	$db->query($sql="UPDATE ".table_users." SET fb_access_token='', user_fb='' WHERE user_id='{$current_user->user_id}'");	

	// Reset password and email to the user
	$user= $db->get_row('SELECT * FROM ' . table_users . " where user_id={$current_user->user_id}");
	if ($user->user_email) {
		$to = $user->user_email;
		$subject = $main_smarty->get_config_vars("PLIGG_PassEmail_Subject");

		$password = substr(md5(uniqid(rand(), true)),0,8);
		$saltedPass = generateHash($password);
		$db->query('UPDATE `' . table_users . "` SET `user_pass` = '$saltedPass' where user_id={$current_user->user_id}");
		$body = sprintf($main_smarty->get_config_vars("PLIGG_PassEmail_PassBody"),
		$main_smarty->get_config_vars("PLIGG_Visual_Name"),
						$my_base_url . $my_pligg_base . '/login.php',
						$user->user_login,
						$password);

		$headers = 'From: ' . $main_smarty->get_config_vars("PLIGG_PassEmail_From") . "\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";

		mail($to, $subject, $body, $headers);
	}	
	header("Location: ../../profile.php");
    }
    elseif ($member_id)
    {
	$fb_user = new User;
	$fb_user->id = $current_user->user_id;
	$fb_user->read();

	$db->query($sql="UPDATE ".table_users." SET user_fb=$member_id, fb_access_token='".sanitize($token,3)."' WHERE user_id='{$fb_user->id}'");	
	header("Location: ../../index.php");
    }
    exit;
}

try {
#    $facebook = fb_facebook_client();
#    $session  = $facebook->getSession();
#    $member_id = $_SESSION['fb_id'] = $facebook->getUser();
    if ($member_id)
    {
		try{
	    		if ($friends = $facebook->api('/me/friends'))
				$friends = $friends['data'];
		    	$profile = $facebook->api('/me');
		}catch (exception $e) {
	    		error_log($e);
			return false;
		}

		if (!class_exists('User'))
	    	    require_once(mnminclude.'user.php');

		// If FB user is already associated with Pligg
		$u = $db->get_var($sql = "SELECT user_login FROM ".table_users." WHERE user_fb=$member_id");	
		if ($u)
		{
			$user = new User();
			$user->username = $u;
			$user->read();
			if (!$current_user->Authenticate($user->username, '', false, $user->pass))
				return false;

			if (!$user->email)
			{
				try{
				    	$profile = $facebook->api('/me');
					$db->query($sql="UPDATE ".table_users." SET user_email='".$db->escape($profile['email'])."' WHERE user_login='$u'");	
				}catch (exception $e) {
			    		error_log($e);
				}
			}

			// Make FB friends Pligg friends
			if ($user->extra_field['fb_follow_friends'] && $friends)
			{
				foreach ($friends as $friend)
				    $f[] = $friend['id'];
				$in = join(",",$f);
				if ($users = $db->get_results($sql = "SELECT a.* FROM ".table_prefix."users a
							   LEFT JOIN ".table_prefix."friends b ON a.user_id=b.friend_to AND b.friend_from={$current_user->user_id}
							   WHERE user_fb IN ($in) AND ISNULL(b.friend_id)"))
					foreach ($users as $user)
					    $db->query("INSERT INTO ".table_prefix."friends SET friend_from={$current_user->user_id}, friend_to={$user->user_id}");
			}

			// Save access token
			if ($token)
				$db->query($sql="UPDATE ".table_users." SET fb_access_token='".sanitize($token,3)."' WHERE user_id='{$current_user->user_id}'");	

			$main_smarty->assign('user_logged_in', $current_user->user_login);
			$main_smarty->assign('user_authenticated', $current_user->authenticated);

			unset($_SESSION['fb_id']);
			header("Location: ../../index.php");
			exit;
		}
    }


    if (!$member_id || $db->get_var("SELECT user_login FROM ".table_users." WHERE user_fb='$member_id'"))
    {
	unset($_SESSION['fb_id']);
	header("Location: ../../index.php");
	exit;
    }

    $profile = $facebook->api('/me');
} catch (Exception $e) {
    error_log($e);
}

if ($_POST['submit'])
{
    if ($profile['id']) 
    {
	if (!$_POST['reg_username'])
	{
		if (!$profile['username']) $profile['username'] = $profile['name'];
		if (!$profile['username']) $profile['username'] = 'FBuser';
		$_POST['reg_username'] = $profile['username'];
	}
	
	if (preg_match('/\pL/u', 'a')) // Check if PCRE was compiled with UTF-8 support
	    $_POST['reg_username'] = preg_replace('/[^_\-\d\p{L}\p{M}]/iu', '', $_POST['reg_username']);
	else 
	    $_POST['reg_username'] = preg_replace('/[~`@#%&=\/;:\.,<>!"\'\^\.\[\]\$\(\)\|\*\+\-\?\{\}\\]/', '', $_POST['reg_username']);
	
	if ($db->get_var("SELECT user_id FROM ".table_users." WHERE user_fb='".$db->escape($member_id)."'"))
	    	$main_smarty->assign('error', "Facebook account already added");
	elseif ($db->get_var("SELECT user_id FROM ".table_users." WHERE user_email='".$db->escape($profile['email'])."'"))
	    	$main_smarty->assign('error', "Email already exists");
	elseif ($db->get_var("SELECT user_id FROM ".table_users." WHERE user_login='".$db->escape($_POST['reg_username'])."'"))
	{
	    	$main_smarty->assign('error', "Username already exists");

		// Check for duplicates here
		for ($i=''; $db->get_var("SELECT user_id FROM ".table_users." WHERE user_login='".$db->escape($_POST['reg_username'].$i)."'"); $i++);
		$_POST['reg_username'] .= $i;
	}
	else
	{
		$db->query("INSERT INTO ".table_users." (user_login,user_level,user_modification,user_date,user_pass,user_email,user_lastlogin,user_fb,fb_follow_friends) VALUES ('".$db->escape($_POST['reg_username'])."','normal',NOW(),NOW(),'Facebook', '".$db->escape($profile['email'])."',NOW(),$member_id,'".$db->escape($_POST['fb_follow_friends'])."')");
		if ($_POST['fb_use_avatar'])
		    fb_copy_avatar($db->insert_id);
	
		$current_user->Authenticate($_POST['reg_username'], '', false, 'Facebook');
	    unset($_SESSION['fb_id']);
#	    header("Location: ../../index.php");
	    header("Location: login.php");
	    exit;
	}
    } else
    {
	    unset($_SESSION['fb_id']);
	    header("Location: ../../index.php");
	    exit;
    }
}

if (!$profile['username']) $profile['username'] = str_replace(' ','',$profile['name']);
if (!$profile['username']) $profile['username'] = 'FBuser';
if (preg_match('/\pL/u', 'a')) // Check if PCRE was compiled with UTF-8 support
    $profile['username'] = preg_replace('/[^_\-\d\p{L}\p{M}]/iu', '', $profile['username']);
else 
    $profile['username'] = preg_replace('/[~`@#%&=\/;:\.,<>!"\'\^\.\[\]\$\(\)\|\*\+\-\?\{\}\\]/', '', $profile['username']);

if ($_POST['reg_username'])
    $main_smarty->assign('reg_username',$_POST['reg_username']);
else
    $main_smarty->assign('reg_username',$profile['username']);
$main_smarty->assign('reg_email',$profile['email']);

// pagename
define('pagename', 'register'); 
$main_smarty->assign('pagename', pagename);

// sidebar
$main_smarty = do_sidebar($main_smarty);

$vars = '';
chdir('../');
check_actions('register_showform', $vars);

chdir('modules');
$main_smarty->assign('tpl_center', fb_tpl_path . '/fb_step2');    
$main_smarty->display($the_template . '/pligg.tpl');
?>