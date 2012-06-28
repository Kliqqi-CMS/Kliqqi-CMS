<!-- START SUBMIT_GROUPS.TPL -->
{if $enable_group eq "true" && $group_allow eq 1}
<div class="headline">
	{if $error}
		<div class="error">{$error}</div>
		<br />
	{/if}
	<form action="{$URL_submit_groups}" method="post" name="thisform" id="thisform" enctype="multipart/form-data">
		{$hidden_token_submit_group}
		<label>{#PLIGG_Visual_Submit_Group_Title#}:</label><br/>{#PLIGG_Visual_Group_Submit_TitleInstruction#}<br/>
		<input type="text" id="group_title" class="text" name="group_title" value="{$templatelite.post.group_title}" size="60" maxlength="120" />
		<br /><br/>
		<label>{#PLIGG_Visual_Submit_Group_Description#}:</label><br/>{#PLIGG_Visual_Group_Submit_DescriptionInstruction#}<br/>
		<textarea name="group_description" rows="10" cols="60" maxlength="600" id="group_description" >{$templatelite.post.group_description}</textarea><br />
		<br />
		<label>{#PLIGG_Visual_Submit_Group_Privacy#}: &nbsp;</label>
			<select name="group_privacy" onchange="document.getElementById('group_email').style.display=this.selectedIndex==0 ? 'none' : 'block';">
				<option value = "public" {if $templatelite.post.group_privacy=='public'}selected{/if}>{#PLIGG_Visual_Submit_Group_Public#}</option>
				<option value = "private" {if $templatelite.post.group_privacy=='private'}selected{/if}>{#PLIGG_Visual_Submit_Group_Private#}</option>
				<option value = "restricted" {if $templatelite.post.group_privacy=='restricted'}selected{/if}>{#PLIGG_Visual_Submit_Group_Restricted#}</option>
			</select>
			<br/>{#PLIGG_Visual_Group_Submit_PrivacyInstruction#}<br/>
			<div id='group_email' {if $templatelite.post.group_privacy=='public' || $templatelite.post.group_privacy==''}style="display:none;"{/if}>
			<input type="checkbox" id="group_notify_email" size="4" name="group_notify_email" value="1" {if $templatelite.post.group_notify_email}checked{/if}> <label>{#PLIGG_Visual_Submit_Group_Notify#}:</label>
			<br /><br />
			</div>
		<label>{#PLIGG_Visual_Submit_Group_Mail_Friends#}:</label><br />
		{#PLIGG_Visual_Group_Submit_Mail_Friends_Desc#}<br/>
		<textarea type="text" id="group_mailer" rows="4" cols="60" name="group_mailer" >{$templatelite.post.group_mailer}</textarea><br />
		<label>{#PLIGG_Visual_Submit_Group_vote_to_publish#}:</label><br/>{#PLIGG_Visual_Group_Submit_NoOfVoteInstruction#}<br/>
		<input type="text" id="group_vote_to_publish" size="4" name="group_vote_to_publish" value="{$templatelite.post.group_vote_to_publish}"><br /><br />
		<input type="submit" value="{#PLIGG_Visual_Submit_Group_create#}" class="submit" />
	</form>
</div>

{else}
	{#PLIGG_Visual_Group_Disabled#}
{/if}
<!-- END SUBMIT_GROUPS.TPL -->