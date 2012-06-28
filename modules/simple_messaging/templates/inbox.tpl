{checkActionsTpl location="tpl_pligg_module_simple_messaging_start"}
{include file="./modules/simple_messaging/templates/menu.tpl"}
{config_load file=$simple_messaging_lang_conf}

{literal}
<style type="text/css">
table { border-collapse:collapse; }
th {text-align:left;}
td { border-bottom:1px solid #eee;padding:3px 0 4px 0; }
</style>
{/literal}

{* table to display messages *}
<form name="bulk_moderate" action="{$my_pligg_base}/module.php?module=simple_messaging&view=inbox&action=bulkmod" method="post">
<table class="listing">
	<tr><th style="width:25%">{#PLIGG_MESSAGING_From#}</th><th width="250px">{#PLIGG_MESSAGING_Subject#}</th><th style="width:125px">{#PLIGG_MESSAGING_Sent#}</th><th style="width:50px">{#PLIGG_MESSAGING_Delete#}</th></tr>
	
	{if $msg_array neq ""}

	{section name=themessage loop=$msg_array}
		<tr id="msg_row_{$msg_array[themessage].id}">
			<td><a href="{$my_pligg_base}/user.php?login={$msg_array[themessage].sender_name}">{$msg_array[themessage].sender_name}</a></td>
			<td>
				{if $msg_array[themessage].readed eq 0}<strong> <img src="{$simple_messaging_path}images/new.png" align="absmiddle" /> </strong>{/if}
				<a href="{$URL_simple_messaging_viewmsg}{$msg_array[themessage].id}">
					{$msg_array[themessage].title}
				</a>
			</td>
			<td>{$msg_array[themessage].date}</td>
			<td><center><input type="checkbox" name="message[{$msg_array[themessage].id}]" id="message-{$msg_array[themessage].id}" value="delete"></center></td>
		</tr>
	{/section}
	
	{else}
	
	<tr><td colspan="3"><div align="center"><br />{#PLIGG_MESSAGING_No_Messages#}</div></td></tr>
	
	{/if}
	
</table>

	{if $msg_array neq ""}
	<br/>
	<p align="right"><input type="submit" name="submit" value="{#PLIGG_MESSAGING_Delete_Selected#}" class="log2" /></p>
	{/if}

</form>

{config_load file=simple_messaging_pligg_lang_conf}
{checkActionsTpl location="tpl_pligg_module_simple_messaging_end"}