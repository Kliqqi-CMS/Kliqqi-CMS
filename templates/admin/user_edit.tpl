<!-- user_edit.tpl -->
{section name=nr loop=$userdata}
	<script>
		var message = "{#PLIGG_Visual_Register_Error_NoPassMatch#}";
		{literal}
		function check(form)
		{
			if (form.password.value != form.password2.value)
			{
			alert(message);
			form.password.focus();
			return false;
			}
			return true;
		}
		{/literal}
	</script>
	<legend>{#PLIGG_Visual_Breadcrumb_Edit_User#}: {$userdata[nr].user_login}</legend>
	<form id="form1" name="form1" method="post" action="admin_users.php" onsubmit="return check(this);">
    <input type="hidden" name="mode" value="{#PLIGG_Visual_Profile_Save#}" />
    <input type="hidden" name="token" value="{$uri_token_admin_users_edit}" />
    <input type="hidden" name="user_id" value="{$userdata[nr].user_id}" />
     {if isset($username_error)}
				<div class="alert">
					<button class="close" data-dismiss="alert">×</button>
					{ foreach value=error from=$username_error }
						<p class="error">{$error}</p>
					{ /foreach }
				</div>
		{/if}
        
        {if isset($email_error)}
				<div class="alert">
					<button class="close" data-dismiss="alert">×</button>
					{ foreach value=error from=$email_error }
						<p class="error">{$error}</p>
					{ /foreach }
				</div>
			{/if}	
        {if isset($password_error)}
				<div class="alert">
					<button class="close" data-dismiss="alert">×</button>
					{ foreach value=error from=$password_error }
						<p class="error">{$error}</p>
					{ /foreach }
				</div>
			{/if}	    	
		<table class="table table-bordered table-striped">
			<tr>
				<td style="width:215px;">
                <label>{#PLIGG_Visual_View_User_Login#}:</label></td>
				<td><input name=login value="{$userdata[nr].user_login}" readonly="readonly"></td>
			</tr>
			{if $userdata[nr].user_id neq 1}
				<tr>
					<td><label>{#PLIGG_Visual_View_User_Level#}:</label></td>
					<td><SELECT NAME="level">{html_options values=$levels output=$levels selected=$userdata[nr].user_level}</SELECT></td>
				</tr>
			{else}
				<tr>
					<td colspan="2"><input name="level" type="hidden" value="{$userdata[nr].user_level}" /></td>
				</tr>
			{/if}
			<tr>
				<td><label>{#PLIGG_Visual_View_User_Email#}:</label></td>
				<td><input name=email value="{$userdata[nr].user_email}"></td>
			</tr>
			<tr>
				<td><label>{#PLIGG_Visual_Profile_NewPass#}:</label></td>
				<td><input name=password type='password'></td>
			</tr>
			<tr>
				<td><label>{#PLIGG_Visual_Profile_VerifyNewPass#}:</label></td>
				<td><input name=password2 type='password'></td>
			</tr>
			{checkActionsTpl location="tpl_admin_user_edit_center_fields"}
			<tr>
				<td>
				</td>
				<td>
					<a class="btn" href="?mode=resetpass&user={$userdata[nr].user_login}{$uri_token_admin_users_edit}" onclick="return confirm('{#PLIGG_Visual_View_User_Reset_Pass_Confirm#}')">{#PLIGG_Visual_View_User_Reset_Pass#}</a>
				</td>
			</tr>
			<tr>
				<td>
					<button onclick="window.history.go(-1)" class="btn"><i class="icon-chevron-left"></i> {#PLIGG_Visual_View_User_Edit_Cancel#}</button>
					<a class="btn" href="{$my_base_url}{$my_pligg_base}/profile.php?login={$userdata[nr].user_login}">{#PLIGG_Visual_Submit3_Modify#} {#PLIGG_Visual_Breadcrumb_Profile#} {#PLIGG_Visual_Profile#}</a>
				</td>
				<td>
					{$hidden_token_admin_users_edit}
					<input type=submit name=mode value="{#PLIGG_Visual_Profile_Save#}" class="btn btn-primary">
				</td>
			</tr>
		</table>
	</form>	
{sectionelse}
	{include file="{$my_base_url}{$my_pligg_base}/templates/admin/user_doesnt_exist_center.tpl"}
{/section}
<!--/user_edit.tpl -->