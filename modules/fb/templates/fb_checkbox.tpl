{if $user_authenticated && $user_fb_id && $has_permission}
{config_load file=fb_lang_conf}
	<input type='checkbox' name='fb_post' value='1'> {#PLIGG_FB_Submit_to_Wall_Step_3#}<br>
{config_load file=fb_pligg_lang_conf}
{/if}