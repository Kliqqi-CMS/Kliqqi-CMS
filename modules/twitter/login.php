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

require_once "twitter.php";  
include_once('twitter_settings.php');

if ($_GET['disconnect'])
{
	$db->query($sql="UPDATE ".table_users." SET user_twitter_id='', user_twitter_token='', user_twitter_secret='', twitter_follow_friends=0, twitter_tweet=0 WHERE user_id='{$current_user->user_id}'");	

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


if (!$_SESSION['access_token'] || !preg_match('/^(\d+)-/',$_SESSION['access_token'],$m))
{
	unset($_SESSION['access_token']);
	unset($_SESSION['access_secret']);
	header("Location: ../../index.php");
	exit;
}
$_SESSION['twitter_id'] = $m[1];

// Show the form only if not logged in to Pligg and logged in to Facebook
if ($current_user->authenticated)
{
	$tweet_user = new User;
	$tweet_user->id = $current_user->user_id;
	$tweet_user->read();

	if (!$tweet_user->extra_field['user_twitter_token'] || !$tweet_user->extra_field['user_twitter_secret'])
		$db->query($sql="UPDATE ".table_users." SET user_twitter_id={$_SESSION['twitter_id']}, user_twitter_token='{$_SESSION['access_token']}', user_twitter_secret='{$_SESSION['access_secret']}' WHERE user_id='{$tweet_user->id}'");	
}
elseif ($user1 = $db->get_row("SELECT * FROM ".table_users." WHERE user_twitter_token='".$db->escape($_SESSION['access_token'])."'"))
{
	$current_user->Authenticate($user1->user_login, '', false, $user1->user_pass);
}

if ($current_user->authenticated)
{
	// Make FB friends Pligg friends
	if ($user->extra_field['twitter_follow_friends'])
	{
	    $settings = get_twitter_settings();
	    $to = new TwitterOauth($settings['consumer_key'], $settings['consumer_secret'], $user->extra_field['user_twitter_token'], $user->extra_field['user_twitter_secret']);
	    $friends = json_decode($to->OAuthRequest("http://api.twitter.com/1/friends/ids.json?user_id={$_SESSION['twitter_id']}", array(), 'GET'),true);
	    if ($friends)
	    {
	    	$in = join(",",$friends);
		if ($users = $db->get_results($sql = "SELECT a.* FROM ".table_prefix."users a
					   LEFT JOIN ".table_prefix."friends b ON a.user_id=b.friend_to AND b.friend_from={$current_user->user_id}
					   WHERE user_twitter_id IN ($in) AND ISNULL(b.friend_id)"))
			foreach ($users as $user)
			    $db->query("INSERT INTO ".table_prefix."friends SET friend_from={$current_user->user_id}, friend_to={$user->user_id}");
	    }
	}

	unset($_SESSION['twitter_id']);
	unset($_SESSION['access_token']);
	unset($_SESSION['access_secret']);
	header("Location: ../../index.php");
	exit;
}

$to = new TwitterOauth($settings['consumer_key'], $settings['consumer_secret'], $_SESSION['access_token'], $_SESSION['access_secret']);
$tweetJson = json_decode($to->OAuthRequest("http://api.twitter.com/1/users/show/{$_SESSION['twitter_id']}.json", array(), 'GET'),true);

if ($_POST['submit'])
{
    if ($tweetJson['id']) 
    {
	if (!$_POST['reg_username'])
	{
		if (!$tweetJson['screen_name']) $tweetJson['screen_name'] = $tweetJson['name'];
		if (!$tweetJson['screen_name']) $tweetJson['screen_name'] = 'TWuser';
		$_POST['reg_username'] = $tweetJson['screen_name'];
	}
	
	if (preg_match('/\pL/u', 'a')) // Check if PCRE was compiled with UTF-8 support
	    $_POST['reg_username'] = preg_replace('/[^_\-\d\p{L}\p{M}]/iu', '', $_POST['reg_username']);
	else 
	    $_POST['reg_username'] = preg_replace('/[~`@#%&=\/;:\.,<>!"\'\^\.\[\]\$\(\)\|\*\+\-\?\{\}\\]/', '', $_POST['reg_username']);

	if ($db->get_var("SELECT user_id FROM ".table_users." WHERE user_twitter_id='".$db->escape($tweetJson['id'])."'"))
	    	$main_smarty->assign('error', "Twitter account already added");
	elseif ($db->get_var("SELECT user_id FROM ".table_users." WHERE user_login='".$db->escape($_POST['reg_username'])."'"))
	{
	    	$main_smarty->assign('error', "Username already exists");

		// Check for duplicates here
		for ($i=''; $db->get_var("SELECT user_id FROM ".table_users." WHERE user_login='".$db->escape($_POST['reg_username'].$i)."'"); $i++);
		$_POST['reg_username'] .= $i;
	}
	else
	{
		$db->query("INSERT INTO ".table_users." SET user_login='".$db->escape($_POST['reg_username'])."',
							    user_level='normal',
							    user_modification=NOW(),
							    user_date=NOW(),
							    user_pass='Twitter',
							    user_lastlogin=NOW(),
							    user_twitter_id='{$tweetJson['id']}', 
							    user_twitter_token='{$_SESSION['access_token']}', 
							    user_twitter_secret='{$_SESSION['access_secret']}', 
							    twitter_follow_friends='".sanitize($_POST['twitter_follow_friends'],3)."', 
						            twitter_tweet='".sanitize($_POST['twitter_tweet'],3)."'");

		if ($_POST['twitter_use_avatar'])
		    twitter_copy_avatar($db->insert_id);

		unset($_SESSION['twitter_id']);
		unset($_SESSION['access_token']);
		unset($_SESSION['access_secret']);

		$current_user->Authenticate($_POST['reg_username'], '', false, 'Twitter');

#	    header("Location: ../../index.php");
	    	header("Location: login.php");
	    	exit;
	}
    } else
    {
		unset($_SESSION['twitter_id']);
		unset($_SESSION['access_token']);
		unset($_SESSION['access_secret']);

	    header("Location: ../../index.php");
	    exit;
    }
}

if (!$tweetJson['screen_name']) $tweetJson['screen_name'] = $tweetJson['name'];
if (!$tweetJson['screen_name']) $tweetJson['screen_name'] = 'TWuser';
if (preg_match('/\pL/u', 'a')) // Check if PCRE was compiled with UTF-8 support
    $tweetJson['screen_name'] = preg_replace('/[^_\-\d\p{L}\p{M}]/iu', '', $tweetJson['screen_name']);
else 
    $tweetJson['screen_name'] = preg_replace('/[~`@#%&=\/;:\.,<>!"\'\^\.\[\]\$\(\)\|\*\+\-\?\{\}\\]/', '', $tweetJson['screen_name']);
if ($_POST['reg_username'])
    $main_smarty->assign('reg_username', $_POST['reg_username']);
else
    $main_smarty->assign('reg_username',$tweetJson['screen_name']);

$vars = '';
check_actions('register_top', $vars);
#twitter_register_top();

// pagename
define('pagename', 'register'); 
$main_smarty->assign('pagename', pagename);

// sidebar
$main_smarty = do_sidebar($main_smarty);

$vars = '';
chdir('../');
check_actions('register_showform', $vars);

chdir('modules');
$main_smarty->assign('tpl_center', twitter_tpl_path . '/twitter_step2');    
$main_smarty->display($the_template . '/pligg.tpl');
?>