{* This template controls the user settings page *}

<ul class="nav nav-tabs" id="profiletabs">
	{checkActionsTpl location="tpl_pligg_profile_sort_start"}
	<li><a href="{$user_url_personal_data}">{#PLIGG_Visual_User_PersonalData#}</a></li>
	<li class="active"><a href="{$user_url_setting}">{#PLIGG_Visual_User_Setting#}</a></li>
	<li><a href="{$user_url_news_sent}">{#PLIGG_Visual_User_NewsSent#}</a></li>
	<li><a href="{$user_url_news_published}">{#PLIGG_Visual_User_NewsPublished#}</a></li>
	<li><a href="{$user_url_news_unpublished}">{#PLIGG_Visual_User_NewsUnPublished#}</a></li>
	<li><a href="{$user_url_commented}">{#PLIGG_Visual_User_NewsCommented#}</a></li>
	<li><a href="{$user_url_news_voted}">{#PLIGG_Visual_User_NewsVoted#}</a></li>
	<li><a href="{$user_url_saved}">{#PLIGG_Visual_User_NewsSaved#}</a></li>
	{checkActionsTpl location="tpl_pligg_profile_sort_end"}
</ul>

{if $savemsg neq ""}<div class="alert alert-success fade in"><a data-dismiss="alert" class="close">×</a>{$savemsg}</div>{/if} 

{checkActionsTpl location="tpl_pligg_profile_info_start"}

<div id="profile_container" style="position: relative;">
	{if $UseAvatars neq false}
		<table class="table table-bordered table-striped span4" style="position: absolute; top: 0px; left: 0px;">
			<thead class="table_title">
				<tr>
					<td colspan="2"><strong>{#PLIGG_Visual_Profile_UploadAvatar2#}</strong></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						{if $user_avatar_source eq "useruploaded"}
							{* This is the avatar upload form. It can't be inside of another form! *}
							<form method="POST" enctype="multipart/form-data" name="image_upload_form" action="{$form_action}">
								<div data-fileupload="image" class="fileupload fileupload-new"><input type="hidden">
									<div style="width: 30px; height: 30px;" class="fileupload-new thumbnail"><img src="{$Avatar_ImgLarge}" title="{#PLIGG_Visual_Profile_CurrentAvatar#}"></div>
									<div style="width: 30px; height: 30px; line-height: 30px;" class="fileupload-preview fileupload-exists thumbnail"></div>
									<span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="image_file" ><input type="hidden" name="avatar" value="uploaded"/></span>
									<a data-dismiss="fileupload" class="btn fileupload-exists" href="#">Remove</a>
									{*
										<img src="{$Avatar_ImgLarge}" alt="Large Avatar"/>
										<img src="{$Avatar_ImgSmall}" alt="Small Avatar"/>
									*}
									{$hidden_token_profile_change}
									<input type="submit" value="{#PLIGG_Visual_Profile_AvatarUpload#}" name="action" class="btn"><br />
								</div>
							</form>
						{/if}
						
						{* This is the main form for the page *}
						<form action="" method="post" id="thisform">
						{$hidden_token_profile_change}
						
						{if $UseAvatars neq false}
							<input type="radio" name="avatarsource" value="" {if $user_avatar_source eq ""}CHECKED{/if}> {#PLIGG_Visual_Profile_UseDefaultAvatar#}<br />
							<input type="radio" name="avatarsource" value="useruploaded" {if $user_avatar_source eq "useruploaded"}CHECKED{/if}> {#PLIGG_Visual_Profile_UploadAvatar#}<br/>
							<input type=submit name="save_profile" value="{#PLIGG_Visual_Profile_Save#}" class="btn btn-primary">
						{/if}
					</td>
				</tr>
			</tbody>
		</table>
	{/if}
		
	<form action="" method="post" id="thisform">
		
		{checkActionsTpl location="tpl_profile_center_fields"}
		{checkActionsTpl location="tpl_pligg_profile_info_middle"}
			
		<table class="table table-bordered table-striped span4">
			<thead class="table_title">
				<tr>
					<td colspan="2"><strong>{#PLIGG_Visual_Profile_ModifyProfile#}</strong></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_RealName#}:</label></td>
					<td><input type="text" name="names" id="names" tabindex="1" value="{$user_names}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_AIM#}:</label></td>
					<td><input type="text" name="aim" id="aim" tabindex="2" value="{$user_aim}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Email#}:</label></td>
					<td><input type="text" name="email" id="email" tabindex="3" value="{$user_email}">
						<br /><em>{#PLIGG_Visual_Profile_OnlyAdmins#}</em></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_MSN#}:</label></td>
					<td><input type="text" name="msn" id="msn" tabindex="4" value="{$user_msn}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_PublicEmail#}:</label></td>
					<td><input type="text" name="public_email" id="public_email" tabindex="5" value="{$user_publicemail}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Yahoo#}:</label></td>
					<td><input type="text" name="yahoo" id="yahoo" tabindex="6" value="{$user_yahoo}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Homepage#}:</label></td>
					<td><input type="text" name="url" id="url" tabindex="7" value="{$user_url}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_GTalk#}:</label></td>
					<td><input type="text" name="gtalk" id="gtalk" tabindex="8" value="{$user_gtalk}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Location#}:</label></td>
					<td><input type="text" name="location" id="location" tabindex="9" value="{$user_location}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Skype#}:</label></td>
					<td><input type="text" name="skype" id="skype" tabindex="10" value="{$user_skype}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Occupation#}:</label></td>
					<td><input type="text" name="occupation" id="occupation" tabindex="11" value="{$user_occupation}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_IRC#}: {#PLIGG_Visual_Profile_IRC_Instruct#}</label></td>
					<td><input type="text" name="irc" id="irc" tabindex="12" value="{$user_irc}"></td>	
				</tr>

			{php}
			if (user_language)
			{
			{/php}
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Language#}:</label></td>
					<td><select name='language'>
							{foreach from=$languages value=lang}
							<option {if $lang==$user_language}selected{/if}>{$lang}</option>
							{/foreach}
						</select>
					</td>
				</tr>
			{php}
			}
			{/php}
			
			</tbody>
		</table>
		
		{checkActionsTpl location="tpl_pligg_profile_settings_start"}		
		
		<table class="table table-bordered table-striped span4">
			<thead class="table_title">
				<tr>
					<td colspan="2"><strong>{#PLIGG_Visual_User_Setting#}</strong></td>
				</tr>
			</thead>		
			{if $Allow_User_Change_Templates}
				<tr>
					<td><label>{#PLIGG_Visual_User_Setting_Template#}:</label></td>
					<td><select name='template'>
					{foreach from=$templates item=template}
						<option {if $template==$current_template}selected{/if}>{$template}</option>
					{/foreach}
					</select>
					</td>
				</tr>
			{/if}
			<tr>
				<td><label>{#PLIGG_Visual_User_Setting_Categories#}:</label></td>
				<td>
				{foreach from=$category item=cat name="cate"}
					<input type="checkbox" name="chack[]" value="{$cat.category__auto_id}" {if !in_array($cat.category__auto_id,$user_category)} checked="checked"{/if}>
					{$cat.category_name}<br/>
				{/foreach}
				</td>
			</tr>
		</table>
		
		{checkActionsTpl location="tpl_pligg_profile_settings_end"}

		<table class="table table-bordered table-striped span4">
			<thead class="table_title">
				<tr>
					<td colspan="2"><strong>{#PLIGG_Visual_Profile_ChangePass#}</strong></td>
				</tr>
			</thead>		<tr>
				<td><label>{#PLIGG_Visual_Profile_OldPass#}:</label></td>
				<td><input type="password" id="oldpassword" name="oldpassword" size="25" tabindex="13"/></td>
			</tr>
			<tr>
				<td><label>{#PLIGG_Visual_Profile_NewPass#}:</label></td>
				<td><input type="password" id="newpassword" name="newpassword" size="25" tabindex="14"/></td>
			</tr>
			<tr>
				<td><label>{#PLIGG_Visual_Profile_VerifyNewPass#}:</label></td>
				<td><input type="password" id="verify" name="newpassword2" size="25" tabindex="15"/></td>
			</tr>
		</table>

</div>
<div style="clear:both;"></div>
<div class="form-actions">
	<input type="hidden" name="process" value="1">
	<input type="hidden" name="user_id" value="{$user_id}">	
	<input type="submit" name="save_profile" value="{#PLIGG_Visual_Profile_Save#}" class="btn btn-primary" tabindex="16">
</div>

	</form>

{checkActionsTpl location="tpl_pligg_profile_end"}