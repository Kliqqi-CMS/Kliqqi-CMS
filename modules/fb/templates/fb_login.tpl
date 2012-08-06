{if !$user_authenticated}
	<a href='{$my_pligg_base}/modules/fb/fb.php?mode=start' onclick='window.open("{$my_pligg_base}/modules/fb/fb.php?mode=start","new","width=300, height=300, toolbar=no, location=yes, directories=no, menubar=no, fullscreen=no"); return false;'><img src="{$my_pligg_base}/modules/fb/images/sign_in.gif"></a>
{else}
	{php}
	global $current_user;
	if ($current_user->user_id)
	{
		$fb_user = new User;
		$fb_user->id = $current_user->user_id;
		$fb_user->read();
	}

	if (!$fb_user->extra_field['user_fb'])
	{
	{/php}
	
		<a title="Connect to Facebook" href='{$my_pligg_base}/modules/fb/fb.php?mode=start' onclick='window.open("{$my_pligg_base}/modules/fb/fb.php?mode=start","new","width=300, height=300, toolbar=no, location=yes, directories=no, menubar=no, fullscreen=no"); return false;'><img src="{$my_pligg_base}/modules/fb/images/sign_in.gif"></a>

	{php}
	}
	{/php}
{/if}
