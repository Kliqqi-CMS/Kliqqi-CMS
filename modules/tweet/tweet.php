<?php
chdir('../');
include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');
include(mnminclude.'link.php');
include_once(mnminclude.'utils.php');
include(mnminclude.'user.php');
include(mnminclude.'smartyvariables.php');

require_once "twitter.php";  
require_once "tweet_main.php";  
$settings = get_tweet_settings();

error_reporting(E_ALL);

if (@$_GET['mode'] == 'start') {
	// get a request token + secret from Twitter and redirect to the authorization page
	//
	//echo "on";
	$ms = new TwitterOauth($settings['consumer_key'], $settings['consumer_secret']);
	$tok = $ms->getRequestToken();
	if (!isset($tok['oauth_token'])
	|| !is_string($tok['oauth_token'])
	|| !isset($tok['oauth_token_secret'])
	|| !is_string($tok['oauth_token_secret'])) {
#		error_log("Bad token from Twitter::getRequestToken(): ".var_export($tok, TRUE));
		echo "ERROR! Twitter::getRequestToken() returned an invalid response. Giving up.";
		exit;
	}
	$_SESSION['auth_state'] = "start";
	$_SESSION['request_token'] = $token = $tok['oauth_token'];
	$_SESSION['request_secret'] = $tok['oauth_token_secret'];
	header("Location: ".$ms->getAuthorizeURL($token));  
exit;
} else if (@$_GET['mode'] == 'callback') {
	// the user has authorized us at Twitter, so now we can pick up our access token + secret
	/*if (@$_SESSION['auth_state'] != "start") 
	{
		echo "Out of sequence.";
		exit;
	}*/
	if (strtolower($_GET['oauth_token']) != strtolower(urlencode($_SESSION['request_token']))) {
		echo "Token mismatch.";
		exit;
	}

	$ms = new TwitterOauth($settings['consumer_key'], $settings['consumer_secret'], $_SESSION['request_token'], $_SESSION['request_secret'], $_GET['oauth_verifier']);
	$tok = $ms->getAccessToken();
	if (!is_string($tok->key) || !is_string($tok->secret)) {
#		error_log("Bad token from Twitter::getAccessToken(): ".var_export($tok, TRUE));
		echo "ERROR! Twitter::getAccessToken() returned an invalid response. Giving up.";
		exit;
	}

	$_SESSION['access_token'] = $tok->key;
	$_SESSION['access_secret'] = $tok->secret;
	$_SESSION['auth_state'] = "done";
	
	header("Location: ".$_SERVER['SCRIPT_NAME']);
	exit;
}
else if (@$_SESSION['auth_state'] == 'done')
{
#	error_reporting(E_ERROR);
	
	misc_data_update('tweet_access_key', sanitize($_SESSION['access_token'], 3));
	misc_data_update('tweet_access_secre', sanitize($_SESSION['access_secret'], 3));
	
#print_r($_SESSION);
	
	header("Location: ../../module.php?module=tweet");
	exit;	
}
else
{
	// not authenticated yet, so give a link to use to start authentication.
	?><p><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>?mode=start">Click here to authenticate with Twitter</a></p><?php
	exit;
}
?>