{include file="./modules/simple_messaging/templates/menu.tpl"}

{config_load file=$simple_messaging_lang_conf}
<h3>{#PLIGG_MESSAGING_SendAMessageTo#}<a href="{$my_pligg_base}/user.php?login={$msgToName}">{$msgToName}</a></h3>
<form method="get" action="module.php">
	<input type = "hidden" name="module" value="simple_messaging">
	<input type = "hidden" name="return" value="{$return}">
	<input type = "hidden" name="view" value="send">

	<label><strong>{#PLIGG_MESSAGING_Subject#}:</strong></label><br />
	<label><input id="msg_subject" name="msg_subject" type="text" value="{$msg_subject}" size="50" class="f-name" tabindex="1" required="yes"></label><br />
	<br />
	<label><strong>{#PLIGG_MESSAGING_Message#}:</strong></label><br />
	<label><textarea id="msg_body" name="msg_body" tabindex="2" rows="10" cols="50" requied="yes" /></textarea></label><br />
	<br />

	<input type = "submit" value="{#PLIGG_MESSAGING_Send#}" tabindex="3">
	<input type = "hidden" name="msg_to" id="msg_to" value="{$msgToName}">
</form>

{config_load file=simple_messaging_pligg_lang_conf}