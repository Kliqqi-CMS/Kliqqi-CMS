{config_load file=akismet_lang_conf}

{if $error}
	<div class="alert fade in">
		<a data-dismiss="alert" class="close">x</a>
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
		<div style="float:left;display:inline;">
			<strong>{#PLIGG_Akismet_api_key#} <input type="text" name="key" value="{$wordpress_key}">
		</div>
		<div style="float:left;margin:1px 0 0 4px;display:inline;">
			<input type="submit" name="submit" class="btn btn-primary" value="{#PLIGG_Akismet_api_update#}">
		</div>
	</form>
	
	<br style="clear:both;" /><br />
	<a href="{$URL_akismet}">{#PLIGG_Akismet_return#}</a>
	
</fieldset>
{config_load file=akismet_pligg_lang_conf}