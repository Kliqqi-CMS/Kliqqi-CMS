<div id="profile"><div id="profile_content">
{if $savemsg neq ""}<p align=center><span class="saved">{$savemsg}</span></p>{/if} 
{checkActionsTpl location="tpl_pligg_profile_info_start"}
	{if $UseAvatars neq false}
		<h2>{#PLIGG_Visual_Profile_UploadAvatar2#}:</h2>
			{if $user_avatar_source eq "useruploaded"}
				{* this form can't be inside of another form! *}
				<form method="POST" enctype="multipart/form-data" name="image_upload_form" action="{$form_action}">
					<input type="file" name="image_file" size="20">
					<input type="hidden" name="avatar" value="uploaded"/>
					{$hidden_token_profile_change}
					<input type="submit" value="{#PLIGG_Visual_Profile_AvatarUpload#}" name="action" class="log2"><br>
				</form> 
			{/if}	
	{/if}
		
	<form action="" method="post" id="thisform">
		{$hidden_token_profile_change}
	{if $UseAvatars neq false}
			{#PLIGG_Visual_Profile_CurrentAvatar#}
			<span id="ls_avatar-large"><img src="{$Avatar_ImgLarge}" alt="Avatar"/></span>
			<span id="ls_avatar-small"><img src="{$Avatar_ImgSmall}" alt="Avatar"/></span>
			<br />
			<input type="radio" name="avatarsource" value="" {if $user_avatar_source eq ""}CHECKED{/if}> {#PLIGG_Visual_Profile_UseDefaultAvatar#}<br />
			<input type="radio" name="avatarsource" value="useruploaded" {if $user_avatar_source eq "useruploaded"}CHECKED{/if}> {#PLIGG_Visual_Profile_UploadAvatar#}<br/>
			<input type=submit name="save_profile" value="{#PLIGG_Visual_Profile_Save#}" class="log2">					
	{/if}

<table style="border:none">

	{checkActionsTpl location="tpl_profile_center_fields"}

<br /><br />
{checkActionsTpl location="tpl_pligg_profile_info_middle"}
	<tr>
		<td width="250px" align="right">
			<h2>Personal Information</h2>
		</td>
		<td width="300px" align="right">
			<h2>Communication</h2>
		</td>
	</tr>
	
	<tr>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_Profile_RealName#}:</label>
			<input type="text" name="names" id="names" tabindex="1" value="{$user_names}"><br />&nbsp;
		</td>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_AIM#}:</label>
			<input type="text" name="aim" id="aim" tabindex="2" value="{$user_aim}">
		</td>
	</tr>
	
	<tr>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_Profile_Email#}:</label>
			<input type="text" name="email" id="email" tabindex="3" value="{$user_email}"> <br /><em>{#PLIGG_Visual_Profile_OnlyAdmins#}</em>
		</td>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_MSN#}:</label>
			<input type="text" name="msn" id="msn" tabindex="4" value="{$user_msn}">
		</td>
	</tr>

	<tr>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_PublicEmail#}:</label>
			<input type="text" name="public_email" id="public_email" tabindex="5" value="{$user_publicemail}"><br />&nbsp;
		</td>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Yahoo#}:</label>
			<input type="text" name="yahoo" id="yahoo" tabindex="6" value="{$user_yahoo}">
		</td>
	</tr>

	<tr>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Homepage#}:</label>
			<input type="text" name="url" id="url" tabindex="7" value="{$user_url}"><br />&nbsp;
		</td>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_GTalk#}:</label>
			<input type="text" name="gtalk" id="gtalk" tabindex="8" value="{$user_gtalk}">
		</td>
	</tr>

	<tr>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_Profile_Location#}:</label>
			<input type="text" name="location" id="location" tabindex="9" value="{$user_location}"><br />&nbsp;
		</td>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Skype#}:</label>
			<input type="text" name="skype" id="skype" tabindex="10" value="{$user_skype}">
		</td>
	</tr>

	<tr>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_Profile_Occupation#}:</label>
			<input type="text" name="occupation" id="occupation" tabindex="11" value="{$user_occupation}">
		</td>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_IRC#}: {#PLIGG_Visual_Profile_IRC_Instruct#}</label>
			<input type="text" name="irc" id="irc" tabindex="12" value="{$user_irc}">
		</td>	
	</tr>

{php}
if (user_language)
{
{/php}
	<tr>
		<td align="right">
			<label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Language#}:</label>
			<select name='language'>
				{foreach from=$languages value=lang}
				<option {if $lang==$user_language}selected{/if}>{$lang}</option>
				{/foreach}
			</select>
		</td>
		<td align="right">
		</td>	
	</tr>
{php}
}
{/php}
		
</table>
{checkActionsTpl location="tpl_pligg_profile_end"}
<div class="linespacer">&nbsp;</div>

<h2>{#PLIGG_Visual_Profile_ChangePass#}</h2>

<table style="border:none">
	<tr>
		<td width="250px" align="right">
			<label>{#PLIGG_Visual_Profile_OldPass#}:</label><br />
			<input type="password" id="oldpassword" name="oldpassword" size="25" tabindex="13"/>
		</td>
		<td width="300px" align="right">
			<label>{#PLIGG_Visual_Profile_NewPass#}:</label><br />
			<input type="password" id="newpassword" name="newpassword" size="25" tabindex="14"/>
		</td>
	</tr>

	<tr>
		<td>
		</td>
		<td align="right">
			<label>{#PLIGG_Visual_Profile_VerifyNewPass#}:</label><br />
			<input type="password" id="verify" name="newpassword2" size="25" tabindex="15"/>
		</td>
	</tr>

	<input type="hidden" name="process" value="1">
	<input type="hidden" name="user_id" value="{$user_id}">	
</table>
	
<br />

{checkActionsTpl location="tpl_pligg_profile_end"}
<input type="submit" name="save_profile" value="{#PLIGG_Visual_Profile_Save#}" class="log2" tabindex="16"></p>

</form>

</div></div>