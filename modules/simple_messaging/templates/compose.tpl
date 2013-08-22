{include file="./modules/simple_messaging/templates/menu.tpl"}

{config_load file=$simple_messaging_lang_conf}
<legend>{#PLIGG_MESSAGING_SendAMessageTo#}<a href="{$my_pligg_base}/user.php?login={$msgToName}">{$msgToName}</a></legend>
<form method="get" action="module.php">
	<input type = "hidden" name="module" value="simple_messaging">
	<input type = "hidden" name="return" value="{$return}">
	<input type = "hidden" name="view" value="send">

	<label><strong>{#PLIGG_MESSAGING_Subject#}:</strong></label>
	<label><input id="msg_subject" name="msg_subject" type="text" value="{$msg_subject}" style="width:98%;" class="f-name" tabindex="1" required="yes"></label><br />
	<label><strong>{#PLIGG_MESSAGING_Message#}:</strong></label>
	<label><textarea id="msg_body" name="msg_body" tabindex="2" rows="10" style="width:98%;" requied="yes" /></textarea></label>
	<br />

	<a class="btn btn-default" href="{$URL_simple_messaging_inbox}">{#PLIGG_MESSAGING_Close#}</a>

	<input class="btn btn-primary" type="submit" value="{#PLIGG_MESSAGING_Send#}" tabindex="3">
	<input type="hidden" name="msg_to" id="msg_to" value="{$msgToName}">
</form>

{config_load file=simple_messaging_pligg_lang_conf}