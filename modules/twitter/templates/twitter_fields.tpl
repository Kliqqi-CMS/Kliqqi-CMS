{config_load file=twitter_lang_conf}
	<input type='checkbox' name='twitter_follow_friends' value='1'> {#PLIGG_Twitter_Follow_Friends#}<br> 
	<input type='checkbox' name='twitter_use_avatar' value='1'> {#PLIGG_Twitter_Use_Avatar#}<br>
{php}
$settings = get_twitter_settings();
if ($settings['when_twitter'] != 'never')
{
{/php}
	<input type='checkbox' name='twitter_tweet' value='1'> {#PLIGG_Twitter_Tweet#}<br> 
{php}
}
{/php}
{config_load file=twitter_pligg_lang_conf}
