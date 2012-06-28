{config_load file=spam_trigger_lang_conf}

{if $templatelite.session.spam_trigger_comment_error == 'moderated'}
	<div class="spam_trigger_moderated spam_trigger">
		{#PLIGG_Spam_Trigger_Comment_Moderated#}
	</div>
{elseif $templatelite.session.spam_trigger_comment_error == 'deleted'}
	<div class="spam_trigger_moderated spam_trigger">
		{#PLIGG_Spam_Trigger_Comment_Deleted#}
	</div>
{/if}

{config_load file=spam_trigger_pligg_lang_conf}


{php}unset($_SESSION['spam_trigger_comment_error']);{/php}
