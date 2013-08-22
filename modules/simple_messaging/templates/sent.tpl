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
<form name="bulk_moderate" action="{$my_pligg_base}/module.php?module=simple_messaging&view=sent&action=bulkmod" method="post"> 
	<table class="table">
		<thead>
			<tr>
				<th style="width:25%">{#PLIGG_MESSAGING_To#}</th>
				<th>{#PLIGG_MESSAGING_Subject#}</th>
				<th style="width:125px">{#PLIGG_MESSAGING_Sent#}</th>
				<th style="width:40px;">{#PLIGG_MESSAGING_Delete#}</th>
			</tr>
		</thead>
		<tbody>
			{if $msg_array neq ""}
				{section name=themessage loop=$msg_array}
					<tr id="msg_row_{$msg_array[themessage].id}">
						<td><a href="{$my_pligg_base}/user.php?login={$msg_array[themessage].sender_name}">{$msg_array[themessage].sender_name}</a></td>
						<td>
							<a href="{$URL_simple_messaging_viewsentmsg}{$msg_array[themessage].id}">
								{$msg_array[themessage].title}
							</a>
						</td>
						<td>{$msg_array[themessage].date}</td>
						<td style="text-align:center;"><input type="checkbox" name="message[{$msg_array[themessage].id}]" id="message-{$msg_array[themessage].id}" value="delete"></td>
					</tr>
				{/section}
			{else}
				<tr>
					<td colspan="4"><div align="center">{#PLIGG_MESSAGING_No_Sent_Messages#}</div></td>
				</tr>
			{/if}
		</tbody>
	</table>

	{if $msg_array neq ""}
		<p align="right"><input type="submit" name="submit" value="{#PLIGG_MESSAGING_Delete_Selected#}" class="btn btn-default" /></p>
	{/if}

</form>

{config_load file=simple_messaging_pligg_lang_conf}