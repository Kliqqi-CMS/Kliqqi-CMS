{config_load file=fb_lang_conf}
{php}
global $current_user, $fb_user;
	if ($current_user->user_id)
	{
		$fb_user = new User;
		$fb_user->id = $current_user->user_id;
		$fb_user->read();
	}

	if ($fb_user->extra_field['user_fb'])
	{
{/php}
	 | <span id='fb-{$link_shakebox_index}'><a href="javascript://" onclick="fb_story({$link_shakebox_index},{$link_id});" style="border:0;">{#PLIGG_FB_Post_Story#}</a></span>
{php}
	}
{/php}
{config_load file=fb_pligg_lang_conf}