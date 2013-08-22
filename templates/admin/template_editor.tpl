<!-- template_editor.tpl -->
<legend>{#PLIGG_Visual_AdminPanel_Editor#}</legend>
{if $templatelite.post.open}
	{* If the open button has been pressed *}
    {if !$error}
		<h3>{#PLIGG_Visual_AdminPanel_Template_File_Opened#}</h3>
		<form action="" method="post" {if $filedata}onsubmit="if (this.updatedfile.value!='' || confirm('{#PLIGG_Visual_AdminPanel_Template_Empty_Confirm#}')) this.isempty.value=1; else return false;"{/if}>	
			<input type="hidden" name="the_file2" value="{$the_file}" />
			<p><strong>{#PLIGG_Visual_AdminPanel_Template_Currently_Open#}: {$the_file}</strong></p>
			<textarea rows="30" class="col-md-12" id="editor" name="updatedfile">{$filedata}</textarea>
			<br/>
			<input type="button" value="Cancel" onClick="javascript:location.href='{$my_base_url}{$my_pligg_base}/admin/admin_editor.php'" class="btn btn-default" />
			<input type="reset" value="Reset" class="btn btn-default">
			<input type="hidden" name="isempty" value="{if $filedata}0{else}1{/if}">
			<input type="submit" class="btn btn-primary" name="save" value="Save Changes" class="btn btn-default"/>
		</form>
    {else}
		<div class="alert alert-block alert-danger">
			<h4 class="alert-heading">{#PLIGG_Visual_AdminPanel_Template_Error#}</h4>
			{#PLIGG_Visual_AdminPanel_Template_Cant_Open#}
		</div>
    {/if}
{elseif $templatelite.post.save}
	{* If save button has been pushed.... *}
    {$error}
{else}
	{* show list of files *}
    {if $files}
		<form action="" method="post">
			<h3>{#PLIGG_Visual_AdminPanel_Editor_Choose#}</h3>
			{#PLIGG_Visual_AdminPanel_Editor_Choose_Chmod#}<br />
			<br />
			<select name="the_file" class="input-xlarge">
				{foreach from=$files item=file}
					<option value="{$file}">{$file}</option>
				{/foreach}
			</select>
			<input type="submit" class="btn btn-primary" name="open" value="Open" id="open_template" />	
		</form>
    {else}
		<div class="alert alert-block alert-danger fade in">
			<h4 class="alert-heading">{#PLIGG_Visual_AdminPanel_Template_Error#}</h4>
			{#PLIGG_Visual_AdminPanel_Template_Cant_Open#}
		</div>
    {/if}
{/if}
<!--/template_editor.tpl -->