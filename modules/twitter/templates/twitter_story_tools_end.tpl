{config_load file=twitter_lang_conf}
{php}
global $current_user, $tweet_user;
if ($current_user->user_id && !$tweet_user)
{
	$tweet_user = new User;
	$tweet_user->id = $current_user->user_id;
	$tweet_user->read();
}

if ($tweet_user->extra_field['user_twitter_token'] && $tweet_user->extra_field['user_twitter_secret'])
{
{/php}
	 | <span class="submit_tweet" id="tweet-{$link_shakebox_index}"><a href="javascript://" onclick="tweet_story({$link_shakebox_index},{$link_id});" style="border:0;"><img src="{$my_pligg_base}/modules/twitter/templates/images/tweet.gif" width="77" height="20" style="border:0;margin:0;padding:0;vertical-align:bottom;" alt="{#PLIGG_Twitter_Tweet_Story#}" title="{#PLIGG_Twitter_Tweet_Story#}" /></a></span>
{php}
}
{/php}
{config_load file=twitter_pligg_lang_conf}