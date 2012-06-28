{include file="./modules/simple_messaging/templates/menu.tpl"}

{config_load file=$simple_messaging_lang_conf}

{literal}
	<style type="text/css">
		table td { background:none }
		a img {border:0;}
		.label {color:#999999;font-weight:bold;}
	</style>
{/literal}

<p>
	<table style="border:none;" cellspacing="5">
		<tr>
			<td align="right" class="label">{#PLIGG_MESSAGING_From#}:</td><td> <a href="{$my_pligg_base}/user.php?login={$msg_array.sender_name}">{$msg_array.sender_name}</a></td>
		</tr>
		<tr>
			<td align="right" class="label">{#PLIGG_MESSAGING_Sent#}:</td><td>{$msg_array.date}</td>
		</tr>
		<tr>
			<td align="right" class="label">{#PLIGG_MESSAGING_Subject#}:</td><td> {$msg_array.title}</td>
		</tr>		
		<tr>
			<td align="right" VALIGN="top" class="label">{#PLIGG_MESSAGING_Message#}:</td><td>{$msg_array.body}</td>
		</tr>
	</table>
	
	<br />
	<hr />
	<br />
	<div align="center">
		<a href="{$URL_simple_messaging_inbox}"><img src="{$simple_messaging_path}images/cross.png" align="absmiddle" /></a> <a href="{$URL_simple_messaging_inbox}">{#PLIGG_MESSAGING_Close#}</a>
	</div>
</p>
{config_load file=simple_messaging_pligg_lang_conf}
