{literal}
<style type="text/css">
.icon-twitter {
background: url({/literal}{$my_pligg_base}{literal}/modules/twitter/templates/images/twitter_icon_white.png);
width:16px;
height:16px;
}

.twitter_logon {
background: url({/literal}{$my_pligg_base}{literal}/modules/twitter/templates/images/sign_in.gif) top left no-repeat;
width:150px;
height:20px;
float:right;
margin:0 8px 0 0;
}

.twitter_logon:hover {
cursor:pointer;
}
.twitter_logon:active  {
cursor:pointer;
}

.twitter_connect {
background: url({/literal}{$my_pligg_base}{literal}/modules/twitter/templates/images/sign_in.gif) top left no-repeat;
float:right;
margin:0 8px 0 0;
}
.twitter_connect:hover {
background-position: 0 -40px;
}
.twitter_connect:active  {
background-position: 0 -20px;
}
</style>
{/literal}

{if $user_authenticated neq true}
{* Bootstrap Style *}
	<div class="btn-group">
		<a class="btn btn-info" style="color:#fff;" title="Twitter Logon" onclick='window.open("{$my_pligg_base}/modules/twitter/tweet.php?mode=start","new","width=500, height=300, toolbar=no, location=yes, directories=no, menubar=no, fullscreen=no"); return false;'><i class="icon-twitter"></i> Twitter Connect</a>
	</div>
{* Wistie Style 
	| &nbsp; <a title="Twitter Logon" onclick='window.open("{$my_pligg_base}/modules/twitter/tweet.php?mode=start","new","width=500, height=300, toolbar=no, location=yes, directories=no, menubar=no, fullscreen=no"); return false;'><div class="twitter_logon"></div></a>
*}
{else}
	{php}
	global $current_user, $tweet_user;
	if ($current_user->user_id && !$tweet_user)
	{
		$tweet_user = new User;
		$tweet_user->id = $current_user->user_id;
		$tweet_user->read();
	}

	if (!$tweet_user->extra_field['user_twitter_token'] || !$tweet_user->extra_field['user_twitter_secret'])
	{
	{/php}
	
	<a title="Connect to Twitter" href='#' onclick='window.open("{$my_pligg_base}/modules/twitter/tweet.php?mode=start","new","width=500, height=300, toolbar=no, location=yes, directories=no, menubar=no, fullscreen=no"); return false;'><div class="twitter_connect"></div></a>

	{php}
	}
	{/php}
{/if}
