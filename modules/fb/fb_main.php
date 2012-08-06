<?php
#ini_set('display_errors', 1);
#error_reporting(E_ALL ^ E_NOTICE);
require_once('facebook.php');
$fb_member_id = '';

//
// Create & return FB client object using given API key/secret
//
function fb_facebook_client() {
  static $facebook = null;

  if ($facebook === null) {
    $settings = fb_get_settings();
    $facebook = new Facebook(array(
	  'appId'  => $settings['key'],
	  'secret' => $settings['secret'],
	  'cookie' => true,
	));
  }
  return $facebook;
}


//
// Check for FB login
// Tested 06/02/11
//
function fb_all_pages_top()
{
	global $settings, $db, $fb_db, $current_user, $main_smarty;

	try {
		$facebook = fb_facebook_client();
		$me = null;
		$fb_member_id = $member_id = $facebook->getUser();
		if ($fb_member_id)
			$permissions = $facebook->api('/me/permissions');
		else
		{
			require_once(mnminclude.'user.php');
			$user = new User();
	    		$user->id = $current_user->user_id;
	    		if ($user->read() && $user->extra_field['fb_access_token'])
			    $permissions = $facebook->api('/me/permissions', array(
				'access_token' => $user->extra_field['fb_access_token']));
	    	}
		$main_smarty->assign('has_permission', $permissions['data'][0]['publish_stream'] && $permissions['data'][0]['share_item']);
  	} catch (exception $e) {
	    	error_log($e);
  	}

	// Login to Pligg automatically
	$main_smarty->assign('user_fb_id', $member_id);
	if ($member_id && !$current_user->authenticated)
	{
/*		// Check for user friends list. Exception here means user is already logged out of Facebook site, however 
		// client still returns valid user ID
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
			if ($session['session_key'])
				$db->query($sql="UPDATE ".table_users." SET fb_access_token='".sanitize($session['session_key'],3)."' WHERE user_id='{$current_user->user_id}'");	

			$main_smarty->assign('user_logged_in', $current_user->user_login);
			$main_smarty->assign('user_authenticated', $current_user->authenticated);
		}
*/
	}
	elseif ($current_user->authenticated)
	{
		require_once(mnminclude.'user.php');
		$user = new User();
		$user->username = $current_user->user_login;
		$user->read();
		$main_smarty->assign('user_fb_id', $user->extra_field['user_fb']);
	}
}

//
// Handle Login form from module's login.php
// Tested 06/01/11
//
function fb_login()
{
	global $db, $current_user;
	$username = sanitize(trim($_POST['username']), 3);
	if ($_SESSION['fb_id'] && $username)
	{
		if ($db->get_var("SELECT user_login FROM ".table_users." WHERE user_fb='{$_SESSION['fb_id']}' AND user_login!='".$db->escape($username)."'"))
		    return;

		try {
		    $facebook = fb_facebook_client();
		    $profile = $facebook->api('/me');
		} catch (Exception $e) {
		    error_log($e);
		}
print_r($profile);

		$db->query($sql="UPDATE ".table_users." SET user_email=IF(user_email!='',user_email,'".$db->escape($profile['email'])."'), user_fb={$_SESSION['fb_id']}, fb_follow_friends='".sanitize($_POST['fb_follow_friends'],3)."' WHERE user_login='$username'");	
		unset($_SESSION['fb_id']);

		$user_id = $db->get_var("SELECT user_id FROM ".table_users."  WHERE user_login='".$db->escape($username)."'");	
		if ($_POST['fb_use_avatar'])
		    fb_copy_avatar($user_id);

		// Process friend list
		$current_user->authenticated = false;
		fb_all_pages_top();
	}
}

//
// Retrieve user image from facebook and save it as Pligg avatar
// Tested 06/02/11
//
function fb_copy_avatar($user_id)
{
	global $db;

	try {
		$facebook = fb_facebook_client();
		$user = $facebook->getUser();
		$me = null;
		// Session based API call.
		if ($user) {
		    $me = $facebook->api("/me?fields=picture");
		    $myfile = $me['picture'];
		}
  	} catch (exception $e) {
	    	error_log($e);
		return false;
  	}

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

//
// Submit a new link to FB wall
// Tested 06/02/11
//
function fb_do_submit3($vars)
{
	global $current_user;

	$linkres = $vars['linkres'];
	if (!$linkres->id || !$_POST['fb_post']) return;

	try{
	    require_once(mnminclude.'user.php');
	    $user = new User();
	    $user->id = $current_user->user_id;
	    if ($user->read() && $user->extra_field['fb_access_token'])
	    {
		$facebook = fb_facebook_client();
	    	$resp = $facebook->api('/me/links', 'post', array(
				'message'=> $linkres->title, 
				'access_token' => $user->extra_field['fb_access_token'],
				'link'=> getmyFullurl("storyURL", $linkres->category_safe_name($linkres->category), urlencode($linkres->title_url), $linkres->id), strip_tags($linkres->link_summary)
				));
	    }
	} catch (Exception $e) {
	    	error_log($e);
	}
}

//
// Save additional user profile fields
// Verified 12/24/09
//
function fb_profile_save(){
	global $user, $users_extra_fields_field;

	$user->extra['fb_follow_friends']=sanitize($_POST['fb_follow_friends']);	
}

//
// Show additional fields in user profile
// Verified 12/24/09
//
function fb_profile_show(){
	global $main_smarty, $user, $users_extra_fields_field;
	$main_smarty->assign('fb_follow_friends', $user->extra_field['fb_follow_friends']);
}

// 
// Read module settings
// Verified 12/24/09
//
function fb_get_settings()
{
    return array(
		'key' => get_misc_data('fb_key'),
		'secret' => get_misc_data('fb_secret')
//		'dont_validate' => get_misc_data('fb_dont_validate'),
//		'hide_captcha' => get_misc_data('fb_hide_captcha')
		);
}

//
// Settings page
//
function fb_showpage(){
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
			misc_data_update('fb_key', trim(sanitize($_REQUEST['fb_key'], 3)));
			misc_data_update('fb_secret', trim(sanitize($_REQUEST['fb_secret'], 3)));
//			misc_data_update('fb_dont_validate', sanitize($_REQUEST['fb_dont_validate'], 3));
//			misc_data_update('fb_hide_captcha', sanitize($_REQUEST['fb_hide_captcha'], 3));
		}
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'fb'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modifyfb'); 
		$main_smarty->assign('pagename', pagename);

		$main_smarty->assign('settings', fb_get_settings());
		$main_smarty->assign('tpl_center', fb_tpl_path . 'fb_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

$fb_validate = 1;
function fb_pligg_validate(&$vars)
{
	global $fb_validate;
	$settings = fb_get_settings();
	if ($fb_validate==0 || ($settings['dont_validate'] && $_SESSION['fb_id'])) $fb_validate = $vars['validate'] = 0;
}

?>
