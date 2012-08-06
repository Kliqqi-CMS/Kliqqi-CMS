{config_load file=comment_subscription_lang_conf}
 {if $user_authenticated eq true}
	{php}
	global $current_user, $db;
	$subs = $db->get_row("SELECT * FROM `".table_prefix . "csubscription` WHERE subs_user_id={$current_user->user_id} AND subs_link_id='{$this->_vars['link_id']}'",ARRAY_A);
	$this->assign('subs_id',$subs['subs_link_id']);
	{/php}

	<span class="submit_cs" id="cs-{$link_shakebox_index|default:100}">
	{* {if $subs_id}{else}{/if} *}
	<a class="btn btn-mini" href="javascript://" onclick="comment_subscribe({$link_shakebox_index|default:100},{$link_id}{if $subs_id},1{/if});" ><i class="icon-envelope"></i> {if $subs_id}{#PLIGG_Comment_Subscription_Unsubscribe#}{else}{#PLIGG_Comment_Subscription_Subscribe#}{/if}</a>
	</span>
 {/if}
{config_load file="/languages/lang_".$pligg_language.".conf"}
