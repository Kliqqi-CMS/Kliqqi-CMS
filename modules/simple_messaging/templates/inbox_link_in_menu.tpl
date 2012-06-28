{config_load file=$simple_messaging_lang_conf}
{if $user_authenticated eq true}
	<div class="links">
		<div class="sectiontitle">
			{* note: currently the "new" count only appears on index because thats the only page that checks to see if there are new messages *}
			{* so it will have to be re-worked *}
			<a href="{$URL_simple_messaging_inbox}" class="main">
			<span>{#PLIGG_MESSAGING_Inbox#} {if $msg_new_count gt 0}({$msg_new_count} {#PLIGG_MESSAGING_New#}){/if} </span>
			</a>
		</div>
	</div>
{/if}
{config_load file=simple_messaging_pligg_lang_conf}