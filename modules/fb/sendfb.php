<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

chdir('../');
include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include_once(mnminclude.'utils.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

#require_once "twitter.php";  
#require_once "twitter_main.php";  
#$settings = get_twitter_settings();

$user = new User();
$user->id = $current_user->user_id;
if ($user->read() && $user->extra_field['fb_access_token'])
{
	$link_id = $_REQUEST['linkid'];
	if (!$link_id) return;

	$linkres = new Link();
	$linkres->id = $link_id;
	$linkres->read();

	try {
	    $facebook = fb_facebook_client();
    	    $resp = $facebook->api('/me/links', 'post', array(
				'message'=> $linkres->title, 
				'access_token' => $user->extra_field['fb_access_token'],
				'link'=> getmyFullurl("storyURL", $linkres->category_safe_name($linkres->category), urlencode($linkres->title_url), $linkres->id), strip_tags($linkres->link_summary)
				));
	} catch (exception $e) {
		$message = $e->getMessage();
		if (preg_match('/"error":"([^"]+)"/',$message,$m))
		    print "ERROR: ".$m[1];
		else
		    print "ERROR: ".$message;
		exit;
        }
}

?>
Sent