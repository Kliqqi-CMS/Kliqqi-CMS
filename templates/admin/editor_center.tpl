<h2 style="margin-top:8px;"><img src="{$my_pligg_base}/templates/admin/images/template_edit.gif" align="absmiddle"/> {#PLIGG_Visual_AdminPanel_Editor#}</h2>
<a href="./admin_config.php?page=Template">{#PLIGG_Visual_AdminPanel_Editor_Change#}</a><br />

{* If the open button has been pressed *}
{if $templatelite.post.open}
    {if !$error}
		<h3>{#PLIGG_Visual_AdminPanel_Template_File_Opened#}</h3>

		<form action="" method="post" {if $filedata}onsubmit="if (this.updatedfile.value!='' || confirm('{#PLIGG_Visual_AdminPanel_Template_Empty_Confirm#}')) this.isempty.value=1; else return false;"{/if}>	
		<input type="hidden" name="the_file2" value="{$the_file}" />
		<p><strong>{#PLIGG_Visual_AdminPanel_Template_Currently_Open#}: {$the_file}</strong></p>
		
		<textarea rows="30" id="editor" name="updatedfile">{$filedata}</textarea>
		<br/>
		<input type="button" value="Cancel" onClick="javascript:location.href='{$my_base_url}{$my_pligg_base}/admin/admin_editor.php'" class="log2" />
		<input type="reset" value="Reset" class="log2">
		<input type="hidden" name="isempty" value="{if $filedata}0{else}1{/if}">
		<input type="submit" name="save" value="Save Changes" class="log2"/>
		
		</form>
		
    {else}
		<div style="padding:10px 8px;margin:12px 5px 20px 5px;background:#fff;border:1px solid #bbb;">
			<h3 style="color:#8F1111;padding:0;margin:0;border-bottom:1px dotted #bbb;">{#PLIGG_Visual_AdminPanel_Template_Error#}</h3>
			<p>{#PLIGG_Visual_AdminPanel_Template_Cant_Open#}</p>
		</div>
    {/if}
	
{* If save button has been pushed.... *}
{elseif $templatelite.post.save}
    {$error}

{* show list of files *}
{else}
    {if $files}

	<form action="" method="post">
	<br />
	<h3>{#PLIGG_Visual_AdminPanel_Editor_Choose#}</h3>
	{#PLIGG_Visual_AdminPanel_Editor_Choose_Chmod#}<br />

	<select name="the_file">
	    {foreach from=$files item=file}
		<option value="{$file}">{$file}</option>
	    {/foreach}
	</select>
	<br/>
	<input type="submit" name="open" value="Open" class="log2" />	
	</form>

    {else}
		<div style="padding:10px 8px;margin:12px 5px 20px 5px;background:#fff;border:1px solid #bbb;">
			<h3 style="color:#8F1111;padding:0;margin:0;border-bottom:1px dotted #bbb;">{#PLIGG_Visual_AdminPanel_Template_Error#}</h3>
			<p>{#PLIGG_Visual_AdminPanel_Template_Cant_Open#}</p>
		</div>
    {/if}
{/if}
	
