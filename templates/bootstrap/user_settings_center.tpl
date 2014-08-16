{************************************
******* User Settings Template ******
*************************************}
{include file=$the_template"/user_navigation.tpl"}

<!-- user_settings_center.tpl -->
{***********************************************************************************}
{if $savemsg neq ""}<div class="alert alert-warning fade in"><a data-dismiss="alert" class="close">&times;</a>{$savemsg}</div>{/if} 
{checkActionsTpl location="tpl_pligg_profile_info_start"}
<form action="" method="post" id="thisform" role="form">
	<div id="profile_container" class="js-masonry">
		{checkActionsTpl location="tpl_user_edit_fields"}
		{checkActionsTpl location="tpl_pligg_profile_info_middle"}
		<div class=" masonry_wrapper">
			<table class="table table-bordered table-striped">
				<thead class="table_title">
					<tr>
						<th colspan="2">{#PLIGG_Visual_Profile_ModifyProfile#}</th>
					</tr>
				</thead>
				<tbody>
					{if $userlevel eq 'admin' or $userlevel eq 'moderator'}
						<tr>
							<td><label for="user_login" accesskey="1">{#PLIGG_Visual_Register_Username#}:</label></td>
							<td><input type="text" class="form-control" name="user_login" id="names" tabindex="1" value="{$user_login}"></td>
						</tr>
					{/if}
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Email#}:</label></td>
						<td><input type="text" class="form-control" name="email" id="email" tabindex="3" value="{$user_email}">
							<br /><div class="help-inline">{#PLIGG_Visual_Profile_OnlyAdmins#}</div></td>
					</tr>
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_PublicEmail#}:</label></td>
						<td><input type="text" class="form-control" name="public_email" id="public_email" tabindex="5" value="{$user_publicemail}"></td>
					</tr>
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Homepage#}:</label></td>
						<td><input type="text" class="form-control" name="url" id="url" tabindex="7" value="{$user_url}"></td>
					</tr>
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_RealName#}:</label></td>
						<td><input type="text" class="form-control" name="names" id="names" tabindex="1" value="{$user_names}"></td>
					</tr>
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Occupation#}:</label></td>
						<td><input type="text" class="form-control" name="occupation" id="occupation" tabindex="11" value="{$user_occupation}"></td>
					</tr>
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_Visual_Profile_Location#}:</label></td>
						<td><input type="text" class="form-control" name="location" id="location" tabindex="9" value="{$user_location}"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class=" masonry_wrapper">
			<table class="table table-bordered table-striped">	
				<thead class="table_title">
					<tr>
						<th colspan="2">{#PLIGG_User_Profile_Social#}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Skype#}:</label></td>
						<td><input type="text" class="form-control" name="skype" id="skype" tabindex="10" value="{$user_skype}"></td>
					</tr>
					
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_User_Profile_Facebook#}:</label></td>
						<td><input type="text" class="form-control" name="facebook" id="facebook" tabindex="2" value="{$user_facebook}"></td>
					</tr>
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_User_Profile_Twitter#}:</label></td>
						<td><input type="text" class="form-control" name="twitter" id="twitter" tabindex="4" value="{$user_twitter}"></td>
					</tr>
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_User_Profile_Linkedin#}:</label></td>
						<td><input type="text" class="form-control" name="linkedin" id="linkedin" tabindex="6" value="{$user_linkedin}"></td>
					</tr>
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_User_Profile_Googleplus#}:</label></td>
						<td><input type="text" class="form-control" name="googleplus" id="googleplus" tabindex="8" value="{$user_googleplus}"></td>
					</tr>
					<tr>
						<td><label for="name" accesskey="1">{#PLIGG_User_Profile_Pinterest#}:</label></td>
						<td><input type="text" class="form-control" name="pinterest" id="pinterest" tabindex="12" value="{$user_pinterest}"></td>	
					</tr>
				</tbody>
			</table>
		</div>
		{checkActionsTpl location="tpl_pligg_profile_settings_start"}		
		<div class=" masonry_wrapper">
			<table class="table table-bordered table-striped">
				<thead class="table_title">
					<tr>
						<th colspan="2">{#PLIGG_User_Display_Settings#}</th>
					</tr>
				</thead>
				<tbody>
					{php}
					if (user_language)
					{
					{/php}
						{*if count($languages) gt 1*}
							<tr>
								<td><label for="name" accesskey="1">{#PLIGG_Visual_User_Profile_Language#}:</label></td>
								<td><select name='language' class="form-control site_languages">
										{foreach from=$languages value=lang}
											<option {if $lang==$user_language}selected{/if}>{$lang}</option>
										{/foreach}
									</select>
								</td>
							</tr>
						{*/if*}
					{php}
					}
					{/php}
					{if $Allow_User_Change_Templates}
						{if count($templates) gt 1}
							<tr>
								<td><label>{#PLIGG_Visual_User_Setting_Template#}:</label></td>
								<td><select name="template" class="form-control site_template">
								{foreach from=$templates item=template}
									<option {if $template==$current_template}selected{/if}>{$template|capitalize}</option>
								{/foreach}
								</select>
								</td>
							</tr>
						{/if}
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
		</div>
		{checkActionsTpl location="tpl_pligg_profile_settings_end"}
		<div class=" masonry_wrapper">
			<table class="table table-bordered table-striped">
				<thead class="table_title">
					<tr>
						<th colspan="2">{#PLIGG_Visual_Profile_ChangePass#}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><label>{#PLIGG_Visual_Profile_OldPass#}:</label></td>
						<td><input type="password" class="form-control" id="oldpassword" name="oldpassword" size="25" tabindex="13"/></td>
					</tr>
					<tr>
						<td><label>{#PLIGG_Visual_Profile_NewPass#}:</label></td>
						<td><input type="password" class="form-control" id="newpassword" name="newpassword" size="25" tabindex="14"/></td>
					</tr>
					<tr>
						<td><label>{#PLIGG_Visual_Profile_VerifyNewPass#}:</label></td>
						<td><input type="password" class="form-control" id="verify" name="newpassword2" size="25" tabindex="15"/></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div style="clear:both;"></div>
	<div class="form-actions">
		{$hidden_token_profile_change}
		<input type="hidden" name="process" value="1">
		<input type="hidden" name="user_id" value="{$user_id}">	
		<input type="submit" name="save_profile" value="{#PLIGG_Visual_Profile_Save#}" class="btn btn-primary profile_settings_save" tabindex="16">
	</div>
</form>
{checkActionsTpl location="tpl_pligg_profile_end"}
<!--/user_settings_center.tpl -->