{************************************
******* Group Story Content ********
*************************************}
<!-- group_summary.tpl -->
<div class="group_container">
	<div style="float:left;width:100px;margin:0 0 10px 0;">
		<a href="{$group_story_url}"><img src="{$imgsrc}" alt="{$group_name} Avatar" class="img-thumbnail" /></a>
	</div>
	<div style="float:left;margin:0 0 10px 10px;" class="col-md-7">
		<span class="group_title">
			{if $pagename eq 'group_story'}
				{$group_name}
			{else}
				<a href="{$group_story_url}">{$group_name}</a>
			{/if}
		</span>
		<br />
		{if $pagename eq 'group_story'}
			{checkActionsTpl location="tpl_pligg_group_list_start"}
		{/if}
		<span class="group_created_by">
			{#PLIGG_Visual_Group_Created_By#} <a href="{$submitter_profile_url}">{$group_submitter}</a>
		</span>
		<span class="group_created_on">
			{#PLIGG_Visual_Group_Created_On#}
			{$group_date}
		</span>
		<span class="group_members"> with {$group_members} {#PLIGG_Visual_Group_Member#}</span>
		<br />
		<p class="group_description">{$group_description}</p>
		{if $pagename eq 'group_story'}
			{checkActionsTpl location="tpl_pligg_group_list_end"}
			{if $user_logged_in neq $group_submitter}
				{if $user_logged_in neq ""}
					{if $is_group_member eq 0}
						{if $join_group_url neq '' || $join_group_privacy_url neq ''}
							{if $group_privacy eq 'public'}
								<a class="btn btn-default" href="{$join_group_url}" ><i class="fa fa-check"></i> {#PLIGG_Visual_Group_Join#}</a>
							{else}
								<a class="btn btn-default" href="{$join_group_privacy_url}" ><i class="fa fa-check"></i> {#PLIGG_Visual_Group_Join#}</a>
							{/if}
						{/if}
					{else}
						{if $is_member_active eq 'active'}
							<a class="btn btn-default" href="{$unjoin_group_url}" ><i class="fa fa-times"></i> {#PLIGG_Visual_Group_Unjoin#}</a>
						{/if}
						{if $is_member_active eq 'inactive'}
							<a class="btn btn-default" href="{$join_group_withdraw}" ><i class="fa fa-times"></i> {#PLIGG_Visual_Group_Withdraw_Request#}</a>
						{/if}	
					{/if}
				{/if}
			{/if}
			{if $is_group_admin eq '1'}
				<a class="btn btn-default" href="{$group_edit_url}"><i class="fa fa-edit"></i> {#PLIGG_Visual_Group_Text_edit#}</a>
				<a class="btn btn-default" href="#groupavatar" data-toggle="modal"><i class="fa fa-picture-o"></i> {#PLIGG_Visual_Group_Avatar_Upload#}</a>
				<a class="btn btn-danger" onclick="return confirm('{#PLIGG_Visual_Group_Delete_Confirm#}')" href={$group_delete_url}><i class="fa fa-white fa-trash-o"></i> {#PLIGG_Visual_Group_Text_Delete#}</a>
				{if $Avatar_uploaded neq ''}
					<br />
					<div class="alert alert-warning">
						<button class="close" data-dismiss="alert">&times;</button>
						{$Avatar_uploaded}
					</div>
				{/if}
				{* Group Avatar Upload Modal *}
				<div class="modal fade" id="groupavatar">
					<div class="modal-dialog">
						<form method="POST" enctype="multipart/form-data" name="image_upload_form" action="{$form_action}">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">{#PLIGG_Visual_Group_Avatar_Upload#}</h4>
								</div>
								<div class="modal-body">
									<p>Please choose a image file to represent your group. Our site will resize your image to fit our standards, but we encourage you to crop your image to square dimensions prior to uploading.</p>
									{$hidden_token_edit_group}
									<input type="file" name="image_file">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="submit" name="action" class="btn btn-primary"><span class="fa fa-white fa fa-picture"></span> {#PLIGG_Visual_Group_Avatar_Upload#}</button>
									<input type="hidden" name="idname" value="{$group_id}"/>
									<input type="hidden" name="avatar" value="uploaded"/>
									<input type="hidden" name="avatarsource" value="useruploaded">
								</div>
							</div><!-- /.modal-content -->
						</form>
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			{/if}
		{elseif $group_status eq 'disable'}
			<div class='group_approve'>
				<button onclick='document.location="?approve={$group_id}"'class='btn btn-primary group_approve_button'>Approve</button>
			</div>
		{/if}
	</div>
	<div style="clear:both;"></div>
</div>
<!--/group_summary.tpl -->