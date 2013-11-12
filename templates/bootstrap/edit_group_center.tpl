{************************************
******** Edit Group Template ********
*************************************}
<!-- edit_group_center.tpl -->
{if $is_group_admin eq '1'}
	{if $errors}
		<div class="alert alert-warning">
			<button class="close" data-dismiss="alert">&times;</button>
			{$errors}
		</div>
	{/if}
	{if $Avatar_uploaded neq ''}
		<div class="alert alert-success">
			<button class="close" data-dismiss="alert">&times;</button>
			{$Avatar_uploaded}
		</div>
	{/if}
	<fieldset>
		<!-- Group Avatar Form -->
		<form method="POST" class="form-horizontal" enctype="multipart/form-data" name="image_upload_form" action="{$edit_form_action}">
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Profile_UploadAvatar2#}</label>
				<div class="controls">
					<img src="{$imgsrc}" alt="Group Avatar" class="img-thumbnail" />
					{$hidden_token_edit_group}
					<input type="file" name="image_file" size="20">
					<input type="hidden" name="idname" value="{$group_id}"/>
					<input type="hidden" name="avatar" value="uploaded"/>
					<input type="hidden" name="avatarsource" value="useruploaded">
					<button type="submit" value="{#PLIGG_Visual_Group_Avatar_Upload#}" name="action" class="btn btn-primary"><i class="fa fa-white fa-picture-o"></i> {#PLIGG_Visual_Group_Avatar_Upload#}</button>
				</div>
			</div>
		</form> 
		<!-- Main Group Edit Form -->
		<form method="POST" class="form-horizontal" enctype="multipart/form-data" name="image_upload_form" action="{$edit_form_action}">
			{$hidden_token_edit_group}
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Submit_Group_Title#}:</label>
				<div class="controls">
					<input type="text" name="group_title" id="group_title" class="form-control col-md-7" value="{$group_name}" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Submit_Group_Description#}:</label>
				<div class="controls">
					<textarea type="text" name="group_description" rows="4" class="form-control col-md-7" id="group_description">{$group_description}</textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Submit_Group_Privacy#}:</label>
				<div class="controls">
					<select name="group_privacy" class="form-control" onchange="document.getElementById('group_email').style.display=this.selectedIndex==0 ? 'none' : 'block';">
						<option {if $group_privacy eq 'public'}SELECTED{/if} value = "public">{#PLIGG_Visual_Submit_Group_Public#}</option>
						<option {if $group_privacy eq 'private'}SELECTED{/if} value = "private">{#PLIGG_Visual_Submit_Group_Private#}</option>
						<option {if $group_privacy eq 'restricted'}SELECTED{/if} value = "restricted">{#PLIGG_Visual_Submit_Group_Restricted#}</option>
					</select>
					<div id='group_email' {if $group_privacy eq 'public'}style="display:none;"{/if}>
						<input type="checkbox" id="group_notify_email" size="4" name="group_notify_email" value="1" {if $group_notify_email}checked{/if}>			
						<p class="help-inline">{#PLIGG_Visual_Submit_Group_Notify#}</p>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Submit_Group_vote_to_publish#}:</label>
				<div class="controls">
					<input type="text" id="group_vote_to_publish" class="form-control input-mini" name="group_vote_to_publish" value="{$group_vote_to_publish}"><br />
					<p class="help-inline">{#PLIGG_Visual_Group_Submit_NoOfVoteInstruction#}</p>
				</div>
			</div>
			<div class="form-actions">
				<input type="submit" value="{#PLIGG_Visual_Group_Edit#}" class="btn btn-primary" name="action" />
				<input type="button" onclick="history.go(-1)" value="{#PLIGG_Visual_View_User_Edit_Cancel#}" class="btn btn-default" />
			</div>
		</form><!--/.form-horizontal -->
	</fieldset>
{else}
	{#PLIGG_Visual_Group_Admin_Error#}
{/if}
<!--/edit_group_center.tpl -->