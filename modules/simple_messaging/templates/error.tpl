{include file="./modules/simple_messaging/templates/menu.tpl"}
{config_load file=$simple_messaging_lang_conf}

<h3>{#PLIGG_MESSAGING_Error#}</h3>

<div class="alert">
	<strong>{$message}</strong>
</div>
	
<a class="btn btn-default" href="#" onclick="history.go(-2);">{#PLIGG_MESSAGING_Back#}</a>

{config_load file=simple_messaging_pligg_lang_conf}
