<a name="discuss"></a>
<div class="form-horizontal">
	<fieldset>

		{checkActionsTpl location="tpl_pligg_story_comments_submit_start"}
		
		<div class="control-group">
			<label for="fileInput" class="control-label">{#PLIGG_Visual_Comment_Send#}</label>
			<div class="controls">
				<textarea name="comment_content" id="comment_content" class="comment-form" rows="6" />{if isset($TheComment)}{$TheComment}{/if}</textarea>
				<p class="help-inline">{#PLIGG_Visual_Comment_NoHTML#}</p>
				{if $Spell_Checker eq 1}
					<input type="button" name="spelling" value="{#PLIGG_Visual_Check_Spelling#}" class="btn" onClick="openSpellChecker('comment_content');"/>
				{/if}
				
			</div>
		</div>
		
		{if isset($register_step_1_extra)}
			{$register_step_1_extra}
		{/if}

		{checkActionsTpl location="tpl_pligg_story_comments_submit_end"}
		
		<div class="form-actions">
			<input type="hidden" name="process" value="newcomment" />
			<input type="hidden" name="randkey" value="{$randkey}" />
			<input type="hidden" name="link_id" value="{$link_id}" />
			<input type="hidden" name="user_id" value="{$user_id}" />
			<input type="submit" name="submit" value="{#PLIGG_Visual_Comment_Submit#}" class="btn btn-primary" />
			
		</div>
	</fieldset>
</div>