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
<h1>{#PLIGG_Visual_Breadcrumb_Edit_User#}: {$userdata[nr].user_login}</h1>
	<form id="form1" name="form1" method="get" action="" onsubmit="return check(this);">
		<input type=hidden name=user value="{$userdata[nr].user_login}">
		{$hidden_token_admin_users_edit}

		<a href="{$my_pligg_base}/profile.php?login={$userdata[nr].user_login}">{#PLIGG_Visual_Submit3_Modify#} {#PLIGG_Visual_Breadcrumb_Profile#} {#PLIGG_Visual_Profile#}</a>
		<br /><br />
		
		<label>{#PLIGG_Visual_View_User_Login#}:</label>
		<input name=login value="{$userdata[nr].user_login}"><br />
		
		{if $userdata[nr].user_id neq 1}
			<label>{#PLIGG_Visual_View_User_Level#}:</label>
			<SELECT NAME="level">{html_options values=$levels output=$levels selected=$userdata[nr].user_level}</SELECT><br/>
		{else}
			<input name="level" type="hidden" value="{$userdata[nr].user_level}" />
		{/if}

		<label>{#PLIGG_Visual_View_User_Email#}:</label>
		<input name=email value="{$userdata[nr].user_email}">
		<br /><br />

		<label>{#PLIGG_Visual_Profile_NewPass#}:</label>
		<input name=password type='password'><br />

		<label>{#PLIGG_Visual_Profile_VerifyNewPass#}:</label>
		<input name=password2 type='password'>
		<br /><br />
		
		<div class="admin_bottom_button"><a href="?mode=resetpass&user={$userdata[nr].user_login}{$uri_token_admin_users_edit}" onclick="return confirm('{#PLIGG_Visual_View_User_Reset_Pass_Confirm#}')"><img src="{$my_pligg_base}/templates/admin/images/user_reset.gif" style="margin-top:2px;"/><p style="margin:1px 0 0 3px;float:right;">{#PLIGG_Visual_View_User_Reset_Pass#}</p></a></div>
		<div style="clear:both;"> </div>

		{checkActionsTpl location="tpl_admin_user_edit_center_fields"}
		<br/><input type=submit name=mode value="{#PLIGG_Visual_Profile_Save#}" class="log2">&nbsp;&nbsp;&nbsp;<input type=button onclick="window.history.go(-1)" value="{#PLIGG_Visual_View_User_Edit_Cancel#}" class="log2">
	</form>	

{sectionelse}
	{include file="{$my_pligg_base}/templates/admin/user_doesnt_exist_center.tpl"}
{/section}