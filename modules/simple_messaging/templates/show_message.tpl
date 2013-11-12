<div class="simple_messaging_wrapper">

	{include file="./modules/simple_messaging/templates/menu.tpl"}

	{config_load file=$simple_messaging_lang_conf}

	{literal}
		<style type="text/css">
			.sm_label {font-weight:bold;padding-right:10px;}
		</style>
	{/literal}

	<p>
		<table style="border:none;" cellspacing="5">
			<tr>
				<td align="right" class="sm_label">{#PLIGG_MESSAGING_From#}:</td>
				<td><a href="{$my_pligg_base}/user.php?login={$msg_array.sender_name}">{$msg_array.sender_name}</a></td>
			</tr>
			<tr>
				<td align="right" class="sm_label">{#PLIGG_MESSAGING_Sent#}:</td>
				<td>{$msg_array.date}</td>
			</tr>
			<tr>
				<td align="right" class="sm_label">{#PLIGG_MESSAGING_Subject#}:</td>
				<td>{$msg_array.title}</td>
			</tr>		
			<tr>
				<td align="right" VALIGN="top" class="sm_label">{#PLIGG_MESSAGING_Message#}:</td>
				<td>{$msg_array.body}</td>
			</tr>
		</table>

		<hr />
		<div align="center">
			<a class="btn btn-success" href="{$URL_simple_messaging_reply}{$msg_id}"><i class="fa fa-reply"></i> {#PLIGG_MESSAGING_Reply#}</a> 
			<a class="btn btn-default" href="{$URL_simple_messaging_inbox}"><i class="fa fa-envelope"></i> {#PLIGG_MESSAGING_Close#}</a>
			<a class="btn btn-danger" href="{$URL_simple_messaging_delmsg}{$msg_id}"><i class="fa fa-times"></i> {#PLIGG_MESSAGING_Delete#}</a> 
		</div>
	</p>
</div>
{config_load file=simple_messaging_pligg_lang_conf}