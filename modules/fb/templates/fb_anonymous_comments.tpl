{config_load file=fb_lang_conf}

<fieldset><legend>{#PLIGG_Anonymous_Comment_Submit_Comment#}</legend>	
	<form action="" method="POST" id="thisform">
		<label>{#PLIGG_Anonymous_Comment_NoHTML#}</label><br clear="all" />
		<textarea name="comment_content" id="comment" rows="6" cols="60"/>{if isset($TheComment)}{$TheComment}{/if}</textarea><br />
		<br/>
		{if isset($register_step_1_extra)}
			<br />
			{$register_step_1_extra}
		{/if}
		<input type="submit" name="submit" value="{#PLIGG_Anonymous_Comment_Submit#}" class="btn" />
		<input type="hidden" name="process" value="newcomment" />
		<input type="hidden" name="randkey" value="{$randkey}" />
		<input type="hidden" name="link_id" value="{$link_id}" />
		<input type="hidden" name="user_id" value="{$anonymous_user_id}" />
		<input type="hidden" name="anon" value="1" />
	</form>
</fieldset>

{config_load file=fb_pligg_lang_conf}