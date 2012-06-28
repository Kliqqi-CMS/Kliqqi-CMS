{checkActionsTpl location="tpl_pligg_story_comments_submit_start"}
<h3><a name="discuss">{#PLIGG_Visual_Comment_Send#}</a></h3>	
<label>{#PLIGG_Visual_Comment_NoHTML#}</label><br />
<textarea name="comment_content" id="comment_content" class="comment-form" rows="6" />{if isset($TheComment)}{$TheComment}{/if}</textarea><br />
{if $Spell_Checker eq 1}<input type="button" name="spelling" value="{#PLIGG_Visual_Check_Spelling#}" class="log2" onClick="openSpellChecker('comment_content');"/>{/if}
{if isset($register_step_1_extra)}
	<br />
	{$register_step_1_extra}
{/if}
<input type="hidden" name="process" value="newcomment" />
<input type="hidden" name="randkey" value="{$randkey}" />
<input type="hidden" name="link_id" value="{$link_id}" />
<input type="hidden" name="user_id" value="{$user_id}" />
<input type="submit" name="submit" value="{#PLIGG_Visual_Comment_Submit#}" class="log2" />
{checkActionsTpl location="tpl_pligg_story_comments_submit_end"}
<br />
