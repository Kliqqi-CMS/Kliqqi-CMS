{config_load file=status_lang_conf}
<div class="status_update">
	<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/modules/status/templates/status_update.css" media="screen">
	<script>
	var my_pligg_base = '{$my_pligg_base}';
	var likes = "{#PLIGG_Status_Likes#}";
	var nolikes = "{#PLIGG_Status_No_Likes#}";
	</script>
	<script src='{$my_pligg_base}/modules/status/status.js'></script>

	<br />
	{checkActionsTpl location="status_update_top"}

	{$settings.pre_format}
	{php}
		$this->_vars['isadmin'] = checklevel('admin');
		$this->_vars['isadmin'] = checklevel('moderator');
	{/php}


	<div class="status_message_wrapper">
		<a id='{$update.update_id}'></a>
		{if $update.update_type=='c'}
		{$settings.pre_comment}
		{elseif $update.update_type=='s'}
		{$settings.pre_story}
		{elseif strstr($update.update_text,$current_username)}
		{$settings.pre_username}
		{/if}
		<div class="status_message_content_wrapper">
			<div class="status_message_tools">
				{checkActionsTpl location="status_tools_1"}

			{if $current_user.user_id>0 && $update.update_user_id!=$current_user.user_id}
				<a href="{$my_pligg_base}/modules/status/status.php?lid={$update.update_id}" onclick='like({$update.update_id}); return false'><span id='like{$update.update_id}' {if $update.like_user_id}style='display:none;'{/if}>{#PLIGG_Status_Like#}</span><span id='unlike{$update.update_id}' {if !$update.like_user_id}style='display:none;'{/if}>{#PLIGG_Status_Unlike#}</span></a>
				| 
			{/if}

			<a href='#' id='count{$update.update_id}' onclick='show_likes({$update.update_id}); return false;' {if $update.update_likes<=0}disabled{/if}>{if $update.update_likes>0}{$update.update_likes} {#PLIGG_Status_Likes#}{else}{#PLIGG_Status_No_Likes#}{/if}</a>
			<div id='likes{$update.update_id}' style='display: none'></div> | 

				<a href="{$my_pligg_base}{php}
				global $URLMethod, $my_base_url, $my_pligg_base;
				if ($URLMethod==2) print "/status/"; 
				else print "/modules/status/status.php?id=";{/php}{$update.update_id}">{#PLIGG_Status_Permalink#}{if $settings.show_permalinks} {$update.update_id}</a> 
				{/if}
				{checkActionsTpl location="status_tools_2"}
				{if $current_user.user_id && ($update.update_user_id==$current_user.user_id || $isadmin || $isadmin)}
					| <a href="{$my_pligg_base}/modules/status/status.php?did={$update.update_id}">{#PLIGG_Status_Delete#}</a>
					{assign var='slash' value='1'}
				{/if}
				{if $current_user.user_id && $update.update_user_id!=$current_user.user_id}
					{if $slash} | {/if}
					<a href="#" onclick="document.getElementById('reply{$update.update_id}').style.display='block'; return false;">{#PLIGG_Status_Reply#}</a> |
					<a href="{$my_pligg_base}/modules/status/status.php?hid={$update.update_id}">{#PLIGG_Status_Hide#}</a>
				{/if}
				{checkActionsTpl location="status_tools_3"}
			</div>
			<div class="status_message_stats">
				<div class="status_message_username">
					{checkActionsTpl location="status_user_1"}
					<a href="{php}print getmyurl('user2', $this->_vars['update']['user_login'], 'profile');{/php}">
					<img alt="" class="status_message_avatar" src="{php}global $settings; print get_avatar($settings['avatar'], "", "", "", $this->_vars['update']['user_id']);{/php}" style="width:22px;height:22px;" />
					{checkActionsTpl location="status_user_2"}
					{$update.user_login}
					{checkActionsTpl location="status_user_3"}
				</div>
				<div class="status_message_time">
					</a> 
					{if $settings.clock=='12'}
						{php}print date("F j, Y h:ia",$this->_vars['update']['update_time']);{/php}
					{else}
						{php}print date("F j, Y H:i",$this->_vars['update']['update_time']);{/php}
					{/if}
				</div>
				<div class="status_clear"> </div>
			</div>
			<div class="status_message_content">
				{checkActionsTpl location="status_message_1"}
				{if $update.update_type=='m'}
					{php}
					print preg_replace(
						array("/@([^\s]+)/e",
							  "/#(\d+)/e"),
						array("'@<a href=\"'.getmyurl('user2', '\\1', 'profile').'\">\\1</a>'",
							  $settings['permalinks'] ? "'<a href=\"' .getmyurl('user2', {$this->_vars['update']['user_login']}, 'profile').($URLMethod == 2 ? '/page/\\1' : '&page=\\1').'#\\1\">#\\1</a>'" : ""),
						$this->_vars['update']['update_text']);
					{/php}
				{else}
					{$update.update_text}
				{/if}
				{checkActionsTpl location="status_message_2"}
			</div>

			{* Reply form *}
			<div id="reply{$update.update_id}" style="display: none;">
				<div class="status_reply">
					<h4>{#PLIGG_Status_Post_Reply#}</h4>
					<div class="status_reply_form">
						<form method='post' action='{$my_pligg_base}/modules/status/status.php'>
							<input value="{$update.update_id}" type="hidden" name="id">
							<textarea cols="43" rows="3" class="status_reply_textarea" name="status">@{$update.user_login} {if $settings.permalinks}#{$update.update_id} {/if}</textarea><br>
							<input value="{#PLIGG_Status_Submit_Reply#}" class="status_reply_submit" type="submit">
						</form>
					</div>
				</div>
			</div>
			{* end of Reply form *}
		</div>

		{if $update.update_type=='c'}
			{$settings.post_comment}
		{elseif $update.update_type=='s'}
			{$settings.post_story}
		{elseif strstr($update.update_text,$current_username)}
			{$settings.post_username}
		{/if}
	</div>

	{$settings.post_format}
	{checkActionsTpl location="status_update_bottom"}
</div>
{config_load file=status_pligg_lang_conf}