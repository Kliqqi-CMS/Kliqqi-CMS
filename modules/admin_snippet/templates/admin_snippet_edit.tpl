{config_load file=admin_snippet_lang_conf}

<fieldset><legend>{#PLIGG_Admin_Snippet_Add_New#}</legend>	

{if $snippet_error}
	<div class="alert alert-error fade in">
		<a data-dismiss="alert" class="close">&times;</a>
		 {$snippet_error}
	</div>
{/if}

	{#PLIGG_Admin_Snippet_Instructions_2#}
	
	<form action="" method="POST" id="thisform">
		<table>
			<tbody>
				<tr>
					<td><label><strong>{#PLIGG_Admin_Snippet_Name#}: &nbsp;</strong></label></td>
					<td><input type="text" name="snippet_name" id="snippet_name" value="{$snippet.snippet_name}" class="form-control" /></td>
				</tr>
				<tr>
					<td><label><strong>{#PLIGG_Admin_Snippet_Location#}: &nbsp;</strong></label></td>
					<td>
						<select name="snippet_location" class="form-control">
						{foreach from=$admin_snippet_locations item=location}
							<option value='{$location.0}' {if $snippet.snippet_location==$location.0}selected{/if}>{$location.0} - {$location.1}</option>
						{/foreach}
						</select>
					</td>
				</tr>
				{if $snippet.snippet_updated}
					<tr>
						<td><label><strong>{#PLIGG_Admin_Snippet_Updated#}: &nbsp;</strong></label></td>
						<td><input type="text" id="snippet_updated" value="{$snippet.snippet_updated}" class="form-control" disabled readonly/></td>
					</tr>
				{/if}
			</tbody>
		</table>
		
		<label><strong>{#PLIGG_Admin_Snippet_Content#}: </strong></label>
		{* snippet_content must have "|escape" modifier to prevent bug with textarea code in textarea *}
		<textarea id="textarea-1" name="snippet_content" rows="15" class="form-control">{$snippet.snippet_content|escape}</textarea>
		<br />
		<input type="submit" name="submit" value="{#PLIGG_Admin_Snippet_Submit#}" class="btn btn-primary" />
		<input type="hidden" name="snippet_id" value="{$snippet.snippet_id}" />
	</form>
</fieldset>

{config_load file=admin_snippet_pligg_lang_conf}