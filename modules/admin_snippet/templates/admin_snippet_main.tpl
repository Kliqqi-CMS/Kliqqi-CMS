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

<fieldset><legend><img src="{$my_pligg_base}/templates/admin/images/page.gif" align="absmiddle" /> {#PLIGG_Admin_Snippet#}</legend>
<p>{#PLIGG_Admin_Snippet_Instructions_1#}</p>
<br />

{if $snippet_error}
<div style="font-weight:bold;margin:10px;border:1px solid #bbb;background:#fff;padding:5px;">
	<font color=red>{$snippet_error}</font>
</div>
{/if}

<form name="snippet" method="post" enctype='multipart/form-data'>
<table cellpadding="1" cellspacing="2" border="0">
	<tr><th width='40%'>{#PLIGG_Admin_Snippet_Name#}</th>
	<th width='30%'>{#PLIGG_Admin_Snippet_Location#}</th>
	<th width='15%'>{#PLIGG_Admin_Snippet_Updated#}</th>
	<th>{#PLIGG_Admin_Snippet_Order#}</th>
	<th><b>{#PLIGG_Admin_Snippet_Delete#}</b></th>
	</tr>
	{section name=id loop=$template_snippets}
	<tr>
		<td><a href="?module=admin_snippet&mode=edit&id={$template_snippets[id].snippet_id}">{$template_snippets[id].snippet_name}</a></td>
		<td>{$template_snippets[id].snippet_location}</td>
		<td>{$template_snippets[id].snippet_updated}</td>
		<td><center><input type="text" name="snippet_order[{$template_snippets[id].snippet_id}]" id="order-{$template_snippets[id].snippet_id}" value="{$template_snippets[id].snippet_order}" size="3"></center></td>
		<td><center><input type="checkbox" name="snippet_delete[{$template_snippets[id].snippet_id}]" id="delete-{$template_snippets[id].snippet_id}" value="1"></center></td>
	</tr>	
	{/section}		
</table>
<br>
<hr/>
<p align="right"><a href="javascript:check_all()">{#PLIGG_Admin_Snippet_Check_All#}</a>&nbsp;&nbsp;&nbsp;<a href="javascript:uncheck_all()">{#PLIGG_Admin_Snippet_Uncheck_All#}</a></p><br />
<p align="right">
<input type="submit" value="{#PLIGG_Admin_Snippet_Add_New#}" onclick="document.location='?module=admin_snippet&mode=new'; return false;" class="log2" /> 
<input type="submit" name="update" value="{#PLIGG_Admin_Snippet_Update#}" class="log2" />
<input type="submit" name="export" value="{#PLIGG_Admin_Snippet_Export_Selected#}" class="log2" />
<input type="submit" name="delete" value="{#PLIGG_Admin_Snippet_Delete_Selected#}" class="log2" />
</p>
<p align="right">
<input type="file" name="file" >
<input type="submit" name="import" value="{#PLIGG_Admin_Snippet_Import#}" class="log2" />
</p>
</form>

{literal}
<SCRIPT>
function check_all() {
	for (var i=0; i< document.snippet.length; i++) {
		if (document.snippet[i].type == "checkbox") {
			document.snippet[i].checked = true;
		}
	}
}
function uncheck_all() {
	for (var i=0; i< document.snippet.length; i++) {
		if (document.snippet[i].type == "checkbox") {
			document.snippet[i].checked = false;
		}
	}
}
</SCRIPT>
{/literal}

{config_load file=admin_snippet_pligg_lang_conf}