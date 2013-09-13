<div class="simple_messaging_wrapper">

	{include file="./modules/simple_messaging/templates/menu.tpl"}
	{config_load file=$simple_messaging_lang_conf}
	
	<h4>{#PLIGG_MESSAGING_SendAMessageTo#}<a href="{$my_pligg_base}/user.php?login={$msgToName}">{$msgToName}</a></h4>

	<form method="get" action="module.php" role="form">

		<input type = "hidden" name="module" value="simple_messaging">
		<input type = "hidden" name="return" value="{$return}">
		<input type = "hidden" name="view" value="send">
		<input type="hidden" name="msg_to" id="msg_to" value="{$msgToName}">
		
		<div class="form-group">
			<label><strong>{#PLIGG_MESSAGING_Subject#}:</strong></label>
			<input class="form-control" id="msg_subject" name="msg_subject" type="text" value="{$msg_subject}" tabindex="1" required="yes">
		</div>
		<div class="form-group">
			<label><strong>{#PLIGG_MESSAGING_Message#}:</strong></label>
			<textarea class="form-control" id="msg_body" name="msg_body" tabindex="2" rows="10" required="yes" /></textarea>
		</div>
		<div class="form-group">
			<a class="btn btn-default" href="{$URL_simple_messaging_inbox}" tabindex="3">{#PLIGG_MESSAGING_Close#}</a>
			<input class="btn btn-primary" type="submit" value="{#PLIGG_MESSAGING_Send#}" tabindex="4">
		</div>
		
	</form>
	
</div>

{config_load file=simple_messaging_pligg_lang_conf}