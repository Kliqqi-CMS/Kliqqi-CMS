{literal}
	<style type="text/css">
	.facebook-login {
		-moz-border-bottom-colors: none;
		-moz-border-left-colors: none;
		-moz-border-right-colors: none;
		-moz-border-top-colors: none;
		background-color: #435D9F;
		background-image: linear-gradient(to bottom, #4A64A5, #435D9F);
		background-repeat: repeat-x;
		border-color: #7E7E89 #7E7E89 #6D6D6D;
		border-image: none;
		border-radius: 3px 3px 3px 3px;
		border-style: solid;
		border-width: 1px;
		box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
		color: #FFFFFF;
		cursor: pointer;
		display: inline-block;
		font-size: 13px;
		line-height: 20px;
		margin-bottom: 10px;
		padding: 8px 18px;
		text-align: center;
		text-shadow: 0 1px 1px rgba(255, 255, 255, 0.40);
		vertical-align: middle;
	}
	.facebook-login:hover, .facebook-login:active {
		background-color: #435D9F;
		color: #FFFFFF;
	}
	.facebook-login:hover .facebook-login a:hover {
		background-color: #435D9F;
		background-position: 0 -15px;
		color: #FFFFFF;
		text-decoration: none;
		transition: background-position 0.1s linear 0s;
	}
	</style>
{/literal}

{if !$user_authenticated}
	<a class='facebook-login' style="font-weight:bold;color:#FFFFFF;" title="Register via Facebook" href='{$my_pligg_base}/modules/fb/fb.php?mode=start' onclick='window.open("{$my_pligg_base}/modules/fb/fb.php?mode=start","new","width=300, height=300, toolbar=no, location=yes, directories=no, menubar=no, fullscreen=no"); return false;'><img src="{$my_pligg_base}/modules/fb/images/fb-logo-white.png" style="margin-top:-2px;" /> Facebook Login</a>
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
		<a class='facebook-login' style="font-weight:bold;color:#FFFFFF;" title="Connect to Facebook" href='{$my_pligg_base}/modules/fb/fb.php?mode=start' onclick='window.open("{$my_pligg_base}/modules/fb/fb.php?mode=start","new","width=300, height=300, toolbar=no, location=yes, directories=no, menubar=no, fullscreen=no"); return false;'><img src="{$my_pligg_base}/modules/fb/images/fb-logo-white.png" style="margin-top:-2px;" /> Facebook Login</a>
	{php}
	}
	{/php}
{/if}
