{config_load file=status_lang_conf}
<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/modules/status/templates/status_update.css" media="screen">
{literal}
<script>
function checkall()
{
    var checks  = document.getElementsByTagName('INPUT');
    for (var i=0; i<checks.length; i++)
     	if (checks[i].type=="checkbox" && checks[i].id=='status_friend_list')
	    checks[i].checked = true;
}
</script>
{/literal}
{php}
	include(mnminclude.'friend.php');
	global $db, $main_smarty, $current_user;
	$friend = new Friend;
	$this->_vars['friends'] = $friend->get_friend_list($current_user->user_id);
	$settings = get_status_settings();
	$this->_vars['settings'] = $settings;
{/php}
<div class="masonry_wrapper">
	<table class="table table-bordered table-striped">
		<thead class="table_title">
			<tr>
				<td colspan="2"><strong>{#PLIGG_Status_Settings#}</strong></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="width:20px;"><input type="checkbox" name="status_switch" id="status_switch" class="checkbox" value="1" {if $status_switch}checked="yes"{/if}/></td>
				<td>{#PLIGG_Status_User_Switch#}</td>
			</tr>
			<tr>
				<td style="width:20px;"><input type="checkbox" name="status_friends" id="status_friends" class="checkbox" value="1" {if $status_friends}checked="yes"{/if}/></td>
				<td>{#PLIGG_Status_User_Friends#}</td>
			</tr>
			<tr>
				<td style="width:20px;"><input type="checkbox" name="status_story" id="status_story" class="checkbox" value="1" {if $status_story}checked="yes"{/if}/></td>
				<td>{#PLIGG_Status_User_Story#}</td>
			</tr>
			<tr>
				<td style="width:20px;"><input type="checkbox" name="status_comment" id="status_comment" class="checkbox" value="1" {if $status_comment}checked="yes"{/if}/></td>
				<td>{#PLIGG_Status_User_Comment#}</td>
			</tr>
			{if $enable_group eq "true"}
			<tr>
				<td style="width:20px;"><input type="checkbox" name="status_group" id="status_group" class="checkbox" value="1" {if $status_group}checked="yes"{/if}/></td>
				<td>{#PLIGG_Status_User_Group#}</td>
			</tr>
			{/if}
			{if $settings.email}
				<tr>
					<td style="width:20px;"><input type="checkbox" name="status_email" id="status_email" class="checkbox" value="1" {if $status_email}checked="yes"{/if}/></td>
					<td>{#PLIGG_Status_User_Email#}</td>
				</tr>
			{/if}
		</tbody>
		<thead class="table_title">
			<tr>
				<td style="width:20px;"><input type="checkbox" onclick="if (this.checked) checkall()" name="status_all_friends" id="status_all_friends" class="checkbox" value="1" {if $status_all_friends}checked="yes"{/if}/></td>
				<td><strong>{#PLIGG_Status_User_List_Friends#}</strong></td>
			</tr>
		</thead>
		<tbody>
			{if $friends}
				<div class="friends_status_list">
					{foreach from=$friends item=myfriend}
						<tr>
							{*php}
								$this->_vars['friend_avatar'] = get_avatar('small', $this->_vars['myfriend']['user_avatar_source'], $this->_vars['myfriend']['user_login'], $this->_vars['myfriend']['user_email']);
								$this->_vars['profileURL'] = getmyurl('user2', $this->_vars['myfriend']['user_login'], 'profile');
							<img src="{$friend_avatar}" align="absmiddle"/> <a href="{$profileURL}">{$myfriend.user_login}</a>
							{/php*}
							<td style="width:20px;"><input type="checkbox" onclick="if (!this.checked) document.getElementById('status_all_friends').checked=false" id="status_friend_list" class="checkbox" name="status_friend_list[]" value="{$myfriend.user_login}" {if in_array($myfriend.user_login,$status_friend_list)}checked="yes"{/if}/></td>
							<td>{$myfriend.user_login}</td>
						</tr>
					{/foreach}
				</div>
			{/if}
		</tbody>
	</table>
</div>
{config_load file=status_pligg_lang_conf}