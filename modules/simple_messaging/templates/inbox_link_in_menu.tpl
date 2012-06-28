{config_load file=$simple_messaging_lang_conf}
{if $user_authenticated eq true}
	{* note: currently the "new" count only appears on index because thats the only page that checks to see if there are new messages *}
	{* so it will have to be re-worked *}
	<li {if $modulename_sm neq ""}class="active"{/if}>
		<a href="{$URL_simple_messaging_inbox}" class="main">{#PLIGG_MESSAGING_Inbox#}{if $msg_new_count gt 0} <div style="background:#F89406;color:#fff;font-size:0.8em;font-weight:bold;position:relative;display:inline;right:left;top:-5px;padding:1px 6px;border-radius:7px;" class="simple_messaging_alert" >{$msg_new_count}</div>{/if} </a>
	</li>
{/if}
{config_load file=simple_messaging_pligg_lang_conf}