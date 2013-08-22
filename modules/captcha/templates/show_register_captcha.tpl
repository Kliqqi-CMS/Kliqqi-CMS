{config_load file=captcha_pligg_lang_conf}

<h2>{#PLIGG_Visual_Breadcrumb_RegisterStep2#}</h2>

{if isset($register_error_text)}
	<div class="error">{$register_error_text}</div>
{/if}

<form action="{$URL_register}" method="post" id="thisform">
	<fieldset><legend>{#PLIGG_Visual_Register_Validation#}</legend>		
		{$cap}
		<input type="submit" name="submit" value="{#PLIGG_Visual_Register_Continue#}" class="btn btn-primary" /></p>
		<input type="hidden" name="process" value="2" />
		<input type="hidden" name="email" value="{$email}" />
		<input type="hidden" name="regfrom" value="sidebar"/>
		<input type="hidden" name="username" value="{$username}" />
		<input type="hidden" name="password" value="{$password}" />
	</fieldset>
</form>
