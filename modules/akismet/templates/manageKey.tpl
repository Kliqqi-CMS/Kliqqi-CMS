{config_load file=akismet_lang_conf}

{if $error || !$wordpress_key}
	<div class="alert alert-warning fade in">
		<a data-dismiss="alert alert-warning fade in" class="close">x</a>
		{#PLIGG_Akismet_Wrong_Key#}
	</div>
{elseif $templatelite.get.submit}
	<div class="alert alert-success fade in">
		<a data-dismiss="alert" class="close">x</a>
		{#PLIGG_Akismet_Saved#}
	</div>
{/if}

<fieldset>
	<legend>{#PLIGG_Akismet_manage_key#}</legend>
	<p>{#PLIGG_Akismet_api_description#}<p>

	<form method="get" action="module.php">
		<input type="hidden" name="module" value="akismet">
		<input type="hidden" name="view" value="updateKey">
		<div class="akismet_api_input">
			<strong>{#PLIGG_Akismet_api_key#}</strong>
			<input type="text" name="key" class="form-control" value="{$wordpress_key}">
		</div>
		<br />
		<div class="akismet_api_submit">
			<input type="submit" name="submit" class="btn btn-primary" value="{#PLIGG_Akismet_api_update#}">
		</div>
	</form>
	
	<br style="clear:both;" /><br />
	<a href="{$URL_akismet}">{#PLIGG_Akismet_return#}</a>
	
</fieldset>
{config_load file=akismet_pligg_lang_conf}