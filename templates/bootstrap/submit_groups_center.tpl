{************************************
******* Create New Group Page *******
*************************************}
<!-- submit_groups_center.tpl -->
{if $enable_group eq "true" && $group_allow eq 1}
	<fieldset>
		{if $error}
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				{$error}
			</div>
		{/if}
		<form action="{$URL_submit_groups}" method="post" name="thisform" id="thisform" class="form-horizontal" enctype="multipart/form-data">
			{$hidden_token_submit_group}
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Submit_Group_Title#}:</label>
				<div class="controls">
					<input type="text" id="group_title" class="form-control col-md-7" name="group_title" value="{$templatelite.post.group_title|escape:"html"}" />
					<br /><p class="help-inline">{#PLIGG_Visual_Group_Submit_TitleInstruction#}</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Submit_Group_Description#}:</label>
				<div class="controls">
					<textarea name="group_description" rows="3" class="form-control" id="group_description" >{$templatelite.post.group_description|escape:"html"}</textarea>
					<br /><p class="help-inline">{#PLIGG_Visual_Group_Submit_DescriptionInstruction#}</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Submit_Group_Privacy#}:</label>
				<div class="controls">
					<select name="group_privacy" class="form-control" onchange="document.getElementById('group_email').style.display=this.selectedIndex==0 ? 'none' : 'block';">
						<option value = "public" {if $templatelite.post.group_privacy=='public'}selected{/if}>{#PLIGG_Visual_Submit_Group_Public#}</option>
						<option value = "private" {if $templatelite.post.group_privacy=='private'}selected{/if}>{#PLIGG_Visual_Submit_Group_Private#}</option>
						<option value = "restricted" {if $templatelite.post.group_privacy=='restricted'}selected{/if}>{#PLIGG_Visual_Submit_Group_Restricted#}</option>
					</select>
					<div id='group_email' {if $templatelite.post.group_privacy=='public' || $templatelite.post.group_privacy==''}style="display:none;"{/if}>
						<input type="checkbox" id="group_notify_email" size="4" name="group_notify_email" value="1" {if $templatelite.post.group_notify_email}checked{/if}> 
						{#PLIGG_Visual_Submit_Group_Notify#}
					</div>
					<br />{#PLIGG_Visual_Group_Submit_PrivacyInstruction#}
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Submit_Group_Mail_Friends#}:</label>
				<div class="controls">
					<input type="text" id="group_mailer" class="form-control col-md-7" name="group_mailer" value="{$templatelite.post.group_mailer|escape:"html"}">
					<br /><p class="help-inline">{#PLIGG_Visual_Group_Submit_Mail_Friends_Desc#}</p>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Submit_Group_vote_to_publish#}:</label>
				<div class="controls">
					<input type="text" id="group_vote_to_publish" class="form-control input-mini" name="group_vote_to_publish" value="{$templatelite.post.group_vote_to_publish|escape:"html"}">
					<br /><p class="help-inline">{#PLIGG_Visual_Group_Submit_NoOfVoteInstruction#}</p>
				</div>
			</div>
			<div class="form-actions">
				<input type="submit" value="{#PLIGG_Visual_Submit_Group_create#}" class="btn btn-primary" />
				<input type="button" onclick="history.go(-1)" value="{#PLIGG_Visual_View_User_Edit_Cancel#}" class="btn btn-default" />
			</div>
		</form>
	</fieldset>
{else}
	{#PLIGG_Visual_Group_Disabled#}
{/if}
<br />
<!--/submit_groups_center.tpl -->