<?php
require_once "twitter.php";  

//
// Settings page
//
function tweet_showpage(){
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
		// Save settings
		if ($_POST['submit'])
		{
			misc_data_update('tweet_consumer_key', trim(sanitize($_REQUEST['tweet_consumer_key'], 3)));
			misc_data_update('tweet_consumer_secre', trim(sanitize($_REQUEST['tweet_consumer_secre'], 3)));
			misc_data_update('tweet_when_tweet', trim(sanitize($_REQUEST['tweet_when_tweet'], 3)));
			misc_data_update('tweet_from_users', trim(sanitize($_REQUEST['tweet_from_users'], 3)));
			misc_data_update('tweet_bitly_login', trim(sanitize($_REQUEST['tweet_bitly_login'], 3)));
			misc_data_update('tweet_bitly_key', trim(sanitize($_REQUEST['tweet_bitly_key'], 3)));

#			$main_smarty->assign('error', $error);
		}
		// breadcrumbs
			$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
			$navwhere['link1'] = getmyurl('admin', '');
			$navwhere['text2'] = "Modify tweet";
			$navwhere['link2'] = my_pligg_base . "/module.php?module=tweet";
			$main_smarty->assign('navbar_where', $navwhere);
			$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
		// breadcrumbs
		define('modulename', 'tweet'); 
		$main_smarty->assign('modulename', modulename);
		
		define('pagename', 'admin_modify_tweet'); 
		$main_smarty->assign('pagename', pagename);
		$main_smarty->assign('settings', get_tweet_settings());
		$main_smarty->assign('tpl_center', tweet_tpl_path . 'tweet_main');
		$main_smarty->display($template_dir . '/admin/admin.tpl');
	}
	else
	{
		header("Location: " . getmyurl('login', $_SERVER['REQUEST_URI']));
	}
}	

function tweet_do_submit3(&$vars)
{
	global $db, $current_user, $my_base_url;

	// Check if other module turned the story to 'discard' or 'spam' state
	$linkres = $vars['linkres'];
	if (!$linkres->id) return;
	if ($linkres->status!='discard' && $linkres->status!='spam')
		tweet_post($linkres,'submitted');
}

function tweet_post($linkres,$when)
{
    global $db, $current_user, $my_base_url;

    $settings = get_tweet_settings();
    if ($settings['when_tweet'] == $when)
    {
	if ($settings['from_users'] && ($users = preg_split('/[\s,]+/',$settings['from_users'])))
	{
	    $user = new User();
	    $user->id = $linkres->author;
	    $user->read();
	    if (!in_array($user->username,$users)) return;
	}

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
    		$to = new TwitterOauth($settings['consumer_key'], $settings['consumer_secret'], $settings['access_key'], $settings['access_secret']);
    		$tweetJson = json_decode($to->OAuthRequest('http://twitter.com/statuses/update.json', $options, 'POST'),true);
	} catch (exception $e) {
		print_r($e);
	}
    	if ($tweetJson[id_str])
	        $db->query("UPDATE ".table_links." SET tweet_id='".$db->escape($tweetJson[id_str])."' WHERE link_id='{$linkres->id}'");
    }
}

function tweet_published(&$vars)
{
	global $db, $current_user, $my_base_url;

	// Check if other module turned the story to 'discard' or 'spam' state
	$link_id = $vars['link_id'];
	if (!$link_id) return;

	$linkres = new Link();
	$linkres->id = $link_id;
	$linkres->read();

	tweet_post($linkres,'published');
}

// 
// Read module settings
//
function get_tweet_settings()
{
    return array(
		'consumer_key' => get_misc_data('tweet_consumer_key'), 
		'consumer_secret' => get_misc_data('tweet_consumer_secre'), 
		'access_key' => get_misc_data('tweet_access_key'), 
		'access_secret' => get_misc_data('tweet_access_secre'), 
		'when_tweet' => get_misc_data('tweet_when_tweet'), 
		'from_users' => get_misc_data('tweet_from_users'),
		'bitly_login' => get_misc_data('tweet_bitly_login'),
		'bitly_key' => get_misc_data('tweet_bitly_key')
		);
}

?>