<form method="get">
	<input type="hidden" name="widget" value="setting_limit">
	<p style="margin:10px 0 0 10px;">
		<strong>Limit Users</strong> 
		<input type="text" name="limit_size" value="{$limit_size}" maxlength="10"> 		
		<input class="btn btn-primary" type="submit" value="{#PLIGG_LLIU_Save#}">
	</p>
</form>

<p><img src="{$my_base_url}{$my_pligg_base}/widgets/last_logged_in_users/templates/heart.gif" style="vertical-align: middle;" /> By <a href="http://sirwan.me">sirwan.me</a></p>