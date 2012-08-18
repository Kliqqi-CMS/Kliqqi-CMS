{************************************
******* User Settings Template ******
*************************************}
<!-- profile_center.tpl -->
{checkActionsTpl location="tpl_pligg_profile_start"}
<div style="margin:0 0 10px 0;">
	<h1>
		{if $UseAvatars neq "0"}
			<img style="float:left;margin:0 15px 0 0;" src="{$Avatar_ImgLarge}" class="thumbnail" style="margin-bottom:4px;" alt="Avatar" />
		{/if}
		{$user_username|capitalize}
	</h1>
	<div style="margin-top:2px;">
		{checkActionsTpl location="tpl_user_profile_social_start"}
		{if $user_skype}
			<a href="callto://{$user_skype}" title="Skype {$user_username}" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/skype_round.png" /></a>
		{/if}
		{if $user_facebook}
			<a href="http://www.facebook.com/{$user_facebook}" title="{$user_username} on Facebook" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/facebook_round.png" /></a>
		{/if}
		{if $user_twitter}
			<a href="http://twitter.com/{$user_twitter}" title="{$user_username} on Twitter" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/twitter_round.png" /></a>
		{/if}
		{if $user_linkedin}
			<a href="http://www.linkedin.com/in/{$user_linkedin}" title="{$user_username} on LinkedIn" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/linkedin_round.png" /></a>
		{/if}
		{if $user_googleplus}
			<a href="https://plus.google.com/{$user_googleplus}" title="{$user_username} on Google+" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/google_round.png" /></a>
		{/if}
		{if $user_pinterest}
			<a href="http://pinterest.com/{$user_pinterest}/" title="{$user_username} on Pinterest" rel="nofollow" target="_blank"><img src="{$my_pligg_base}/templates/{$the_template}/images/pinterest_round.png" /></a>
		{/if}
		{checkActionsTpl location="tpl_user_profile_social_end"}
	</div>
	{checkActionsTpl location="tpl_show_extra_profile"}
	<div style="font-size:0.85em;line-height:1.3em;margin-top:2px;">		
		{if $user_publicemail ne ""}
			{php}
				// Method to try to trick automated email address collection bots
				global $main_smarty;
				$full_email = $this->_vars['user_publicemail'];
				list($email_start,$_) = explode('@',$full_email); $email_domain = ''.$_;
				$main_smarty->assign('email_start', $email_start);
				$main_smarty->assign('email_domain', $email_domain);
			{/php}
			<script type="text/javascript">
			<!--
				var string1 = "{$email_start}";
				var string2 = "@";
				var string3 = "{$email_domain}";
			//  document.write(string4);
				document.write("<a href=" + "mail" + "to:" + string1 + string2 + string3 + ">Email</a> | ");
			//-->
			</script>
		{/if}
		{if $user_url ne "" && $user_karma > "20" || $user_login eq $user_logged_in}
			<a href="{$user_url}" target="_blank" rel="nofollow">{$user_url}</a>
			<br />
		{/if}
		{checkActionsTpl location="tpl_user_profile_details_start"}
		{if $user_names ne ""}
			{$user_names} is
		{/if}
		{if $user_occupation ne ""}
			{if $user_names ne ""}a{/if} {$user_occupation}
		{/if}
		{if $user_location ne ""}
			from {$user_location}
		{/if}
		{checkActionsTpl location="tpl_user_profile_details_end"}
	</div>
	<div style="clear:both;"></div>
</div>
{checkActionsTpl location="tpl_user_center_just_below_header"}
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
{if $savemsg neq ""}<div class="alert alert-warning fade in"><a data-dismiss="alert" class="close">×</a>{$savemsg}</div>{/if} 
{checkActionsTpl location="tpl_pligg_profile_info_start"}
<div id="profile_container" style="position: relative;">
	{if $UseAvatars neq false}
		<table class="masonry table table-bordered table-striped span4" style="position: absolute; top: 0px; left: 0px;">
			<thead class="table_title">
				<tr>
					<th colspan="2">{#PLIGG_Visual_Profile_UploadAvatar2#}</th>
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
		<!--/$UseAvatars-->
	{/if}
	<form action="" method="post" id="thisform">
		{checkActionsTpl location="tpl_profile_center_fields"}
		{checkActionsTpl location="tpl_pligg_profile_info_middle"}
		<table class="masonry table table-bordered table-striped span4">
			<thead class="table_title">
				<tr>
					<th colspan="2">{#PLIGG_Visual_Profile_ModifyProfile#}</th>
				</tr>
			</thead>
			<tbody>
				{if $userlevel eq 'admin' or $userlevel eq 'moderator'}
					<tr>
						<td><label for="user_login" accesskey="1">{#PLIGG_Visual_Register_Username#}:</label></td>
						<td><input type="text" name="user_login" id="names" tabindex="1" value="{$user_login}"></td>
					</tr>
				{/if}
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Email#}:</label></td>
					<td><input type="text" name="email" id="email" tabindex="3" value="{$user_email}">
						<br /><em>{#PLIGG_Visual_Profile_OnlyAdmins#}</em></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_PublicEmail#}:</label></td>
					<td><input type="text" name="public_email" id="public_email" tabindex="5" value="{$user_publicemail}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Homepage#}:</label></td>
					<td><input type="text" name="url" id="url" tabindex="7" value="{$user_url}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_RealName#}:</label></td>
					<td><input type="text" name="names" id="names" tabindex="1" value="{$user_names}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Occupation#}:</label></td>
					<td><input type="text" name="occupation" id="occupation" tabindex="11" value="{$user_occupation}"></td>
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
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Facebook#}:</label></td>
					<td><input type="text" name="facebook" id="facebook" tabindex="2" value="{$user_facebook}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Twitter#}:</label></td>
					<td><input type="text" name="twitter" id="twitter" tabindex="4" value="{$user_twitter}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Linkedin#}:</label></td>
					<td><input type="text" name="linkedin" id="linkedin" tabindex="6" value="{$user_linkedin}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Googleplus#}:</label></td>
					<td><input type="text" name="googleplus" id="googleplus" tabindex="8" value="{$user_googleplus}"></td>
				</tr>
				<tr>
					<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Pinterest#}:</label></td>
					<td><input type="text" name="pinterest" id="pinterest" tabindex="12" value="{$user_pinterest}"></td>	
				</tr>
				
			{php}
			if (user_language)
			{
			{/php}
				{if count($languages) gt 1}
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Language#}:</label></td>
						<td><select name='language'>
								{foreach from=$languages value=lang}
									<option {if $lang==$user_language}selected{/if}>{$lang}</option>
								{/foreach}
							</select>
						</td>
					</tr>
				{/if}
			{php}
			}
			{/php}
			</tbody>
		</table>
		{checkActionsTpl location="tpl_pligg_profile_settings_start"}		
		<table class="masonry table table-bordered table-striped span4">
			<thead class="table_title">
				<tr>
					<th colspan="2">{#PLIGG_Visual_User_Setting#}</th>
				</tr>
			</thead>
			<tbody>
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
			</tbody>
		</table>
		{checkActionsTpl location="tpl_pligg_profile_settings_end"}
		<table class="masonry table table-bordered table-striped span4">
			<thead class="table_title">
				<tr>
					<th colspan="2">{#PLIGG_Visual_Profile_ChangePass#}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
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
			</tbody>
		</table>
	{* There is still an open <form> that needs to be closed *}
</div>
<div style="clear:both;"></div>
<div class="form-actions">
	<input type="hidden" name="process" value="1">
	<input type="hidden" name="user_id" value="{$user_id}">	
	<input type="submit" name="save_profile" value="{#PLIGG_Visual_Profile_Save#}" class="btn btn-primary" tabindex="16">
</div>
	</form>
{checkActionsTpl location="tpl_pligg_profile_end"}
<!--/profile_center.tpl -->