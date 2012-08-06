{config_load file=twitter_lang_conf}

{php}
	global $current_user;
	if ($current_user->user_id) {
		$fb_user = new User;
		$fb_user->id = $current_user->user_id;
		$fb_user->read();
	}

	if ($fb_user->extra_field['user_twitter_id']) {
	{/php}
		<table class="table table-bordered table-striped span4">
			<thead class="table_title">
				<tr>
					<td colspan="2"><strong>Twitter</strong></td>
				</tr>
			</thead>
			<tbody>
				{php} 
				$settings = get_twitter_settings();
				if ($settings['when_twitter'] != 'never') { {/php}
					<tr>
						<td style="width:20px;"><input type="checkbox" name="twitter_tweet" id="twitter_tweet" value="1" {if $twitter_tweet}checked{/if}/></td>
						<td><label>{#PLIGG_Twitter_Tweet#}</label></td>
					</tr>
				{php} }	{/php}
				<tr>
					<td style="width:20px;"><input type="checkbox" name="twitter_follow_friends" id="twitter_follow_friends" value="1" {if $twitter_follow_friends}checked{/if}/></td>
					<td><label>{#PLIGG_Twitter_Follow_Friends#}</label></td>
				</tr>
				<tr>
					<td colspan="2"><button class="btn btn-warning" onclick='document.location.href="{$my_pligg_base}/modules/twitter/login.php?disconnect=1"; return false;'>{#PLIGG_Twitter_Disconnect#}</button></td>
				</tr>
			</tbody>
		</table>
	{php} } {/php}
	
{config_load file=twitter_pligg_lang_conf}