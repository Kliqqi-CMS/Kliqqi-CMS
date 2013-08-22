{config_load file=karma_lang_conf}

{if $error}
	<div class="alert alert-error">
		<button class="close" data-dismiss="alert">&times;</button>
		{$error}
    </div>
{elseif $templatelite.post.submit}
	<div class="alert alert-success">
		<button class="close" data-dismiss="alert">&times;</button>
		{#PLIGG_Karma_Saved#}
    </div>
{/if}

<legend>{#PLIGG_Karma#}</legend>
<p>{#PLIGG_Karma_Instructions#}</p>
<br />
<div class="col-md-6">
	<form action="" method="POST" id="thisform">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Description</th>
					<th>Value</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><label>{#PLIGG_Karma_Story_Published#}: </label></td>
					<td><input type="text" name="karma_story_publish" class="form-control col-md-12" value="{$settings.story_publish}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Karma_Story_Submit#}: </label></td>
					<td><input type="text" name="karma_submit_story" class="form-control col-md-12" value="{$settings.submit_story}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Karma_Comment_Submit#}: </label></td>
					<td><input type="text" name="karma_submit_comment" class="form-control col-md-12" value="{$settings.submit_comment}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Karma_Story_Discard#}: </label></td>
					<td><input type="text" name="karma_story_discard" class="form-control col-md-12" value="{$settings.story_discard}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Karma_Comment_Delete#}: </label></td>
					<td><input type="text" name="karma_comment_delete" class="form-control col-md-12" value="{$settings.comment_delete}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Karma_Story_Spam#}: </label></td>
					<td><input type="text" name="karma_story_spam" class="form-control col-md-12" value="{$settings.story_spam}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Karma_Story_Vote#}: </label></td>
					<td><input type="text" name="karma_story_vote" class="form-control col-md-12" value="{$settings.story_vote}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Karma_Story_Vote_Remove#}: </label></td>
					<td><input type="text" name="karma_story_vote_remove" class="form-control col-md-12" value="{$settings.story_vote_remove}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Karma_Comment_Vote#}: </label></td>
					<td><input type="text" name="karma_comment_vote" class="form-control col-md-12" value="{$settings.comment_vote}" /></td>
				</tr>
				<tr>
					<td><label>{#PLIGG_Karma_Add_User#}: </label></td>
					<td>
						{#PLIGG_Karma_Username#}: <input type="text" name="karma_username" class="form-control" />
						<br />
						{#PLIGG_Karma_Value#}: <input type="text" name="karma_value" class="form-control"/>
					</td>
				</tr>

				<tr>
					<td></td>
					<td>
						<input type="submit" name="submit" value="{#PLIGG_Karma_Submit#}" class="btn btn-primary" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>

{*
<hr />
<h2>{#PLIGG_Karma_Field_Definitions#}</h2>
<p>{#PLIGG_Karma_Field_Definitions_Desc#}</p>
*}

{config_load file=karma_pligg_lang_conf}