{config_load file=spam_trigger_lang_conf}

{if $templatelite.session.spam_trigger_story_error == 'moderated'}
	<div class="spam_trigger_moderated spam_trigger">
		{#PLIGG_Spam_Trigger_Story_Moderated#}
	</div>
{elseif $templatelite.session.spam_trigger_story_error == 'discarded'}
	<div class="spam_trigger_discarded spam_trigger">
		{#PLIGG_Spam_Trigger_Story_Discarded#}
	</div>
{elseif $templatelite.session.spam_trigger_story_error == 'deleted'}
	<div class="spam_trigger_deleted spam_trigger">
		{#PLIGG_Spam_Trigger_Story_Deleted#}
	</div>
{/if}

{config_load file=spam_trigger_pligg_lang_conf}


{php}unset($_SESSION['spam_trigger_story_error']);{/php}
