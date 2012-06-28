{config_load file=akismet_lang_conf}
<fieldset>
	<legend><img src="{$akismet_img_path}shield.png" align="absmiddle"/> {#PLIGG_Akismet_manage_key#}</legend>
	<p>{#PLIGG_Akismet_api_description#}<p>

	<form method="get" action="module.php">
		<input type="hidden" name="module" value="akismet">
		<input type="hidden" name="view" value="updateKey">
		<strong>{#PLIGG_Akismet_api_key#} <input type="text" name="key" value="{$wordpress_key}">
		<input type = "submit" value="{#PLIGG_Akismet_api_update#}">
	</form>
	<br />
	<a href="{$URL_akismet}">{#PLIGG_Akismet_return#}</a>
	
</fieldset>
{config_load file=akismet_pligg_lang_conf}