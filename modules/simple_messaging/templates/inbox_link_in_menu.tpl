{config_load file=$simple_messaging_lang_conf}
{if $user_authenticated eq true}
	<li {if $modulename_sm neq ""}class="active"{/if}>
		<a href="{$URL_simple_messaging_inbox}" {if $msg_new_count gt 0}class="simple_messaging_alert"{/if}>{#PLIGG_MESSAGING_Inbox#}{if $msg_new_count gt 0} <span class="label label-warning">{$msg_new_count}</span>{/if}</a>
	</li>
{/if}
{config_load file=simple_messaging_pligg_lang_conf}