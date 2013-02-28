<?php
if (!class_exists('TwitterOauth'))
    require_once "twitter.php";  

//
// Save additional user profile fields
// Verified 12/24/09
//
function twitter_profile_save(){
	global $user, $users_extra_fields_field;

	$user->extra['twitter_follow_friends']=sanitize($_POST['twitter_follow_friends']);	
	$user->extra['twitter_tweet']=sanitize($_POST['twitter_tweet']);	

}

//
// Show additional fields in user profile
// Verified 12/24/09
//
function twitter_profile_show(){
	global $main_smarty, $user, $users_extra_fields_field, $db, $current_user;
	$main_smarty->assign('twitter_follow_friends', $user->extra_field['twitter_follow_friends']);
	$main_smarty->assign('twitter_tweet', $user->extra_field['twitter_tweet']);

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
}

// 
// Read module settings
//
function get_twitter_settings()
{
    return array(
		'consumer_key' => get_misc_data('twitter_consumer_key'), 
		'consumer_secret' => get_misc_data('twitter_consumer_sec'), 
		'when_twitter' => get_misc_data('twitter_when_twitter'), 
		'bitly_login' => get_misc_data('twitter_bitly_login'),
		'bitly_key' => get_misc_data('twitter_bitly_key')
		);
}

//
// Settings page
//
function twitter_showpage(){
	global $db, $main_smarty, $the_template;
		
	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);

	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('admin');
	
	if($canIhaveAccess == 1)
	{	
		if ($_POST['submit'])
		{
			misc_data_update('twitter_consumer_key', trim(sanitize($_REQUEST['twitter_consumer_key'], 3)));
			misc_data_update('twitter_consumer_sec', trim(sanitize($_REQUEST['twitter_consumer_secre'], 3)));
			misc_data_update('twitter_when_twitter', trim(sanitize($_REQUEST['twitter_when_twitter'], 3)));
			misc_data_update('twitter_bitly_login', trim(sanitize($_REQUEST['twitter_bitly_login'], 3)));
			misc_data_update('twitter_bitly_key', trim(sanitize($_REQUEST['twitter_bitly_key'], 3)));
#			header("Location: ".my_pligg_base."/module.php?module=fb");
#			die();
		}
		// breadcrumbs
#			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
#			$navwhere['link1'] = getmyurl('admin', '');
#			$navwhere['text2'] = "Modify Snippet";
#			$navwhere['link2'] = my_pligg_base . "/module.php?module=fb";
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'twitter'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifyfb'); 
		$main_smarty->assign('pagename', pagename);

		$main_smarty->assign('settings', get_twitter_settings());
		$main_smarty->assign('tpl_center', twitter_tpl_path . 'twitter_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	


//
// Handle Login form from module's login.php
// Tested 12/25/09
//
function twitter_login()
{
	global $db, $current_user;
	$username = sanitize(trim($_POST['username']), 3);
	if ($_SESSION['access_token'] && $username)
	{
		if ($db->get_var("SELECT user_login FROM ".table_users." WHERE user_twitter_id='{$_SESSION['twitter_id']}' AND user_login!='".$db->escape($username)."'"))
		    return;

		$db->query($sql="UPDATE ".table_users." SET user_twitter_id={$_SESSION['twitter_id']}, user_twitter_token='{$_SESSION['access_token']}', user_twitter_secret='{$_SESSION['access_secret']}', twitter_follow_friends='".sanitize($_POST['twitter_follow_friends'],3)."', twitter_tweet='".sanitize($_POST['twitter_tweet'],3)."' WHERE user_login='$username'");	

		// Make FB friends Pligg friends
		if ($_POST['twitter_follow_friends'])
		{
		    $settings = get_twitter_settings();
		    $to = new TwitterOauth($settings['consumer_key'], $settings['consumer_secret'], $_SESSION['access_token'], $_SESSION['access_secret']);
		    $friends = json_decode($to->OAuthRequest("http://api.twitter.com/1/friends/ids.json?user_id={$_SESSION['twitter_id']}", array(), 'GET'),true);

		    if ($friends)
		    {
		    	$in = join(",",$friends);
			if ($users = $db->get_results($sql = "SELECT a.* FROM ".table_prefix."users a
						   LEFT JOIN ".table_prefix."friends b ON a.user_id=b.friend_to AND b.friend_from={$vars['id']}
						   WHERE user_twitter_id IN ($in) AND ISNULL(b.friend_id)"))
				foreach ($users as $user)
				    $db->query("INSERT INTO ".table_prefix."friends SET friend_from={$vars['id']}, friend_to={$user->user_id}");
		    }
		}

		$user_id = $db->get_var("SELECT user_id FROM ".table_users."  WHERE user_login='".$db->escape($username)."'");	
		if ($_POST['twitter_use_avatar'])
		    twitter_copy_avatar($user_id);

#		unset($_SESSION['twitter_id']);
		unset($_SESSION['access_token']);
		unset($_SESSION['access_secret']);
	}
}

//
// Retrieve profile image from Twitter and save it as Pligg avatar
//
function twitter_copy_avatar($user_id)
{
	global $db;

	$user = $db->get_row("SELECT * FROM ".table_users."  WHERE user_id=$user_id");	
        $settings = get_twitter_settings();

	// Retrieve Twitter info
	$to = new TwitterOauth($settings['consumer_key'], $settings['consumer_secret'], $user->user_twitter_token, $user->user_twitter_secret);

	$tweetJson = json_decode($to->OAuthRequest("http://api.twitter.com/1/users/show/{$user->user_twitter_id}.json", array(), 'GET'),true);
	$myfile  = $tweetJson['profile_image_url'];
	$user_image_path = mnmpath."avatars/user_uploaded" . "/";
	$user_image_apath = "/" . $user_image_path;

	// If there is an image
	if ($myfile && ($content=file_get_contents($myfile)))
	{
		$imagename = $user_id . "_original.jpg";
		$newimage = $user_image_path . $imagename ;
		file_put_contents($newimage,$content);

		$imagesize = getimagesize($newimage);
		$width = $imagesize[0];
		$height = $imagesize[1];	

		// create large avatar
		include mnminclude . "class.pThumb.php";
		$img=new pThumb();
		$img->pSetSize(Avatar_Large, Avatar_Large);
		$img->pSetQuality(100);
		$img->pCreate($newimage);
		$img->pSave($user_image_path . $user_id . "_".Avatar_Large.".jpg");
		$img = "";

		// create small avatar
		$img=new pThumb();
		$img->pSetSize(Avatar_Small, Avatar_Small);
		$img->pSetQuality(100);
		$img->pCreate($newimage);
		$img->pSave($user_image_path . $user_id . "_".Avatar_Small.".jpg");
		$img = "";

		$db->query($sql="UPDATE ".table_users." SET user_avatar_source='useruploaded' WHERE user_id='$user_id'");	
	}
}

function twitter_do_submit3(&$vars)
{
	global $db, $current_user, $my_base_url;

	// Check if other module turned the story to 'discard' or 'spam' state
	$linkres = $vars['linkres'];
	if (!$linkres->id) return;
	if ($linkres->status!='discard' && $linkres->status!='spam')
		twitter_post($linkres,'submitted');
}

function twitter_post($linkres,$when)
{
    global $db, $current_user, $my_base_url;

    $settings = get_twitter_settings();
    if ($settings['when_twitter'] == $when)
    {
	$user = $db->get_row("SELECT * FROM ".table_users." WHERE user_id={$linkres->author}");	
	if (!$user->twitter_tweet || !$user->user_twitter_token || !$user->user_twitter_secret) return;

	$url = $my_base_url.getmyurl('storycattitle', $linkres->category_safe_name(), urlencode($linkres->title_url));
	if ($settings['bitly_login'] && $settings['bitly_key'])
	{
	    $url1 = trim(file_get_contents($r="http://api.bit.ly/v3/shorten?login={$settings['bitly_login']}&apiKey={$settings['bitly_key']}&longUrl=".urlencode($url)."&format=txt"));
	    if ($url1)
		$url = $url1;
	}
	
    	$msg = $linkres->title.' '.$url;
	if (strlen($msg) > 140)
	    if ($url1)
    	    	$msg = substr($linkres->title,0,139-strlen($url1)).' '.$url1;
	    else
    	    	$msg = substr($linkres->title,0,139-strlen($my_base_url.getmyurl('story', $linkres->id))).' '.$my_base_url.getmyurl('story', $linkres->id);
    	$options = array('status' => stripslashes($msg));
	try {
    		$to = new TwitterOauth($settings['consumer_key'], $settings['consumer_secret'], $user->user_twitter_token, $user->user_twitter_secret);
   		$tweetJson = json_decode($to->OAuthRequest('http://api.twitter.com/1/statuses/update.json', $options, 'POST'),true);
	} catch (exception $e) {
#print_r($e);
	}
    }
}

function twitter_published(&$vars)
{
	global $db, $current_user, $my_base_url;

	// Check if other module turned the story to 'discard' or 'spam' state
	$link_id = $vars['link_id'];
	if (!$link_id) return;

	$linkres = new Link();
	$linkres->id = $link_id;
	$linkres->read();

	twitter_post($linkres,'published');
}

?>
