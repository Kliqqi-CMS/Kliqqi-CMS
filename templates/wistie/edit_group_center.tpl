{if $is_group_admin eq '1'}
	<div id="group_container" style="width:650px;float:left;">
		<div id="group_left" style="width:110px;float:left;">
			<span>
				<img src="{$imgsrc}" alt="group_avatar" />
			</span>
			<br />
				<span class="group_avatar"><img src="{$my_base_url}{$my_pligg_base}/templates/{$the_template}/images/folder_images.gif" />&nbsp;<a style="text-decoration:none;font-weight:bold;left:4px;top:-3px;" href="javascript://" onclick="var replydisplay=document.getElementById('image_upload-1').style.display ? '' : 'none';document.getElementById('image_upload-1').style.display = replydisplay;">{#PLIGG_Visual_Group_Avatar_Upload#}</a>
		</div>
		<div id="group_right" style="width:500px;float:left;position:relative">
		{if $errors}<span class="problem">{$errors}</span>{/if}
		<form method="POST" enctype="multipart/form-data" name="image_upload_form" action="{$edit_form_action}">
			{$hidden_token_edit_group}
			<label>{#PLIGG_Visual_Submit_Group_Title#}:</label><br/>
			<input type="text" name="group_title" id="group_title" value="{$group_name}" /><br/>
			<br/>
			<label>{#PLIGG_Visual_Submit_Group_Description#}:</label><br/>
			<textarea type="text" name="group_description" rows="6" cols="50" id="group_description">{$group_description}</textarea>
			<br/><br/>
			<label>{#PLIGG_Visual_Submit_Group_Privacy#}:</label>
				<select name="group_privacy" onchange="document.getElementById('group_email').style.display=this.selectedIndex==0 ? 'none' : 'block';">
					<option {if $group_privacy eq 'public'}SELECTED{/if} value = "public">{#PLIGG_Visual_Submit_Group_Public#}</option>
					<option {if $group_privacy eq 'private'}SELECTED{/if} value = "private">{#PLIGG_Visual_Submit_Group_Private#}</option>
					<option {if $group_privacy eq 'restricted'}SELECTED{/if} value = "restricted">{#PLIGG_Visual_Submit_Group_Restricted#}</option>
				</select><br /><br/>
			<div id='group_email' {if $group_privacy eq 'public'}style="display:none;"{/if}>
				<input type="checkbox" id="group_notify_email" size="4" name="group_notify_email" value="1" {if $group_notify_email}checked{/if}>			
				<label>{#PLIGG_Visual_Submit_Group_Notify#}</label>
				<br /><br />
			</div>
			<label>{#PLIGG_Visual_Submit_Group_vote_to_publish#}:</label><br/>{#PLIGG_Visual_Group_Submit_NoOfVoteInstruction#}<br/>
			<input type="text" id="group_vote_to_publish" size="4" name="group_vote_to_publish" value="{$group_vote_to_publish}"><br /><br />
			<button type="submit" value="{#PLIGG_Visual_Group_Edit#}" name="action" class="submit"><span class="round"><span>{#PLIGG_Visual_Group_Edit#}</span></span></button><br>
		</form>
		
			{if $is_group_admin eq '1'}
				{if $Avatar_uploaded neq ''}<br/><span class="success"><img src="{$my_base_url}{$my_pligg_base}/templates/{$the_template}/images/green_check.gif"/>{$Avatar_uploaded}</span>{/if}	
				<span id = "image_upload-1" style="display:none;">
					<fieldset><legend>{#PLIGG_Visual_Profile_UploadAvatar2#}:</legend>
						<form method="POST" enctype="multipart/form-data" name="image_upload_form" action="{$edit_form_action}">
							{$hidden_token_edit_group}
							<input type="file" name="image_file" size="20">
							<input type="hidden" name="idname" value="{$group_id}"/>
							<input type="hidden" name="avatar" value="uploaded"/>
							<input type="hidden" name="avatarsource" value="useruploaded">
							<button type="submit" value="{#PLIGG_Visual_Profile_AvatarUpload#}" name="action" class="submit"><span class="round"><span>{#PLIGG_Visual_Profile_AvatarUpload#}</span></span></button><br>
						</form> 
					</fieldset>
				</span>
			{/if}
			
		</div>
	</div>
{else}
	{#PLIGG_Visual_Group_Admin_Error#}
{/if}