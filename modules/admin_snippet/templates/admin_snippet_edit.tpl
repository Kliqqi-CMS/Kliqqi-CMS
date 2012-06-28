{config_load file=admin_snippet_lang_conf}

{literal}
	<style type="text/css">
		td {line-height:18px;}
		.eip_editable { background-color: #ff9; padding: 3px; }
		.eip_savebutton { background-color: #36f; color: #fff; }
		.eip_cancelbutton { background-color: #000; color: #fff; }
		.eip_saving { background-color: #903; color: #fff; padding: 3px; }
		.eip_empty { color: #afafaf; }	
		.emptytext {padding:0px 6px 0px 6px;border-top:2px solid #828177;border-left:2px solid #828177;border-bottom:1px solid #B0B0B0;border-right:1px solid #B0B0B0;background:#F5F5F5;}
	</style>
{/literal}

{*<!-- Page WYSIWYG Editor -->
<link rel="stylesheet" type="text/css" href="{$my_pligg_base}/templates/admin/css/MooEditable.css" />
<script type='text/javascript' src="{$my_pligg_base}/templates/admin/js/mootools.js" ></script>	
<script type='text/javascript' src="{$my_pligg_base}/templates/admin/js/MooEditable.js" ></script>
{literal}
	<script type="text/javascript">
		MooEditable.Actions.extend({
			'h1' : {
				title: 'H1',
				tags: ['h1'],
				arguments: '<h1>',
				command: 'formatBlock',
				mode: 'text'
			},
			'h2' : {
				title: 'H2',
				tags: ['h2'],
				arguments: '<h2>',
				command: 'formatBlock',
				mode: 'text'
			},
			'h3' : {
				title: 'H3',
				tags: ['h3'],
				arguments: '<h3>',
				command: 'formatBlock',
				mode: 'text'
			},
			'p' : {
				title: 'P',
				tags: ['p'],
				arguments: '<p>',
				command: 'formatBlock',
				mode: 'text'
			}
		});
		
		window.addEvent('load', function(){
			$('textarea-1').mooEditable({
				buttons: 'bold,italic,underline,strikethrough,|,h1,h2,h3,p,|,insertunorderedlist,insertorderedlist,indent,outdent,|,undo,redo,|,createlink,unlink,|,urlimage,|,toggleview'
			});
		});
	</script>
{/literal}
*}

<fieldset><legend>{#PLIGG_Admin_Snippet_Add_New#}</legend>	

{if $snippet_error}
<div style="font-weight:bold;margin:10px;border:1px solid #bbb;background:#fff;padding:5px;">
	<font color=red>{$snippet_error}</font>
</div>
{/if}

	<form action="" method="POST" id="thisform">
	{#PLIGG_Admin_Snippet_Instructions_2#}
	<br />
		<table border="0">
		<tr>
		<td width="50"><label><strong>{#PLIGG_Admin_Snippet_Name#}: </strong></label></td><td><input type="text" name="snippet_name" id="snippet_name" size="66" value="{$snippet.snippet_name}" style="width: 420px;"/></td>
		</tr>
		<tr>
		<td><label><strong>{#PLIGG_Admin_Snippet_Location#}: </strong></label></td><td><select name="snippet_location" style="width: 420px;">
			{foreach from=$admin_snippet_locations item=location}
				<option value='{$location.0}' {if $snippet.snippet_location==$location.0}selected{/if}>{$location.0} - {$location.1}</option>
			{/foreach}
			</select></td>
		</tr>
		{if $snippet.snippet_updated}
		<tr>
		<td width="50"><label><strong>{#PLIGG_Admin_Snippet_Updated#}: </strong></label></td><td><input type="text" id="snippet_updated" size="66" value="{$snippet.snippet_updated}" style="width: 420px;" disabled readonly/></td>
		</tr>
		{/if}
		<tr>
		<td colspan="2">
		<label><strong>{#PLIGG_Admin_Snippet_Content#}</strong></label>
		<br />
		<div class="width100">
			{* snippet_content must have "|escape" modifier to prevent bug with textarea code in textarea *}
			<textarea !class="mooeditable" id="textarea-1" name="snippet_content" !name="editable1" rows="30" style="width: 100%;">{$snippet.snippet_content|escape}</textarea>
		</div>
		<div class="submitbuttonfloat">
		<br />
			<input type="submit" name="submit" value="{#PLIGG_Admin_Snippet_Submit#}" class="log2" />
		</div>
		<input type="hidden" name="snippet_id" value="{$snippet.snippet_id}" />
		</td></tr>
		</table>
	</form>
</fieldset>

{config_load file=admin_snippet_pligg_lang_conf}