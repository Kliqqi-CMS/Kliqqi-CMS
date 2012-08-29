<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

chdir('../');
include_once('../internal/Smarty.class.php');$main_smarty = new Smarty;

include('../config.php');
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include_once(mnminclude.'utils.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

require_once "twitter.php";  
require_once "twitter_main.php";  
$settings = get_twitter_settings();

$user = $db->get_row("SELECT * FROM ".table_users." WHERE user_id={$current_user->user_id}");	
if (!$user->user_twitter_token || !$user->user_twitter_secret) return "ERROR: You are not authorized to post on Twitter";

$link_id = $_REQUEST['linkid'];
if (!$link_id) return;

$linkres = new Link();
$linkres->id = $link_id;
$linkres->read();

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
	$tweetJson = json_decode($to->OAuthRequest('http://twitter.com/statuses/update.json', $options, 'POST'),true);
} catch (exception $e) {
	$message = $e->getMessage();
	if (preg_match('/"error":"([^"]+)"/',$message,$m))
	    print "ERROR: ".$m[1];
	else
	    print "ERROR: ".$message;
	exit;
}

?>
<img src="./modules/twitter/templates/images/tweet_submitted.gif" width="110" height="20" style="border:0;padding:0;marign:0;" alt="Tweet Submitted!" title="sent (<?=$tweetJson[id_str]?>)" />