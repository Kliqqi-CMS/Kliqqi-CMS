{config_load file=fb_lang_conf}

	{php}
	global $current_user;
	if ($current_user->user_id)
	{
		$fb_user = new User;
		$fb_user->id = $current_user->user_id;
		$fb_user->read();
	}

	if ($fb_user->extra_field['user_fb'])
	{
	{/php}
		<table class="masonry table table-bordered table-striped span4">
			<thead class="table_title">
				<tr>
					<td colspan="2"><strong>Facebook</strong></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="width:20px;"><input type="checkbox" name="fb_follow_friends" id=fb_follow_friends"" value="1" {if $fb_follow_friends}checked{/if}/></td>
					<td><label>{#PLIGG_FB_Follow_Friends#}</label></td>
				</tr>
				<tr>
					<td colspan="2"><button class="btn btn-warning" onclick='document.location.href="{$my_pligg_base}/modules/fb/login.php?disconnect=1"; return false;'>{#PLIGG_FB_Disconnect#}</button></td>
				</tr>
			</tbody>
		</table>
	{php}
	}
	{/php}

{config_load file=fb_pligg_lang_conf}
