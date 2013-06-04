<!-- hc_incorrect.tpl -->
{config_load file=hc_lang_conf}
{if $submit_error eq 'register_captcha_error'}
	<div class="alert alert-error">{#PLIGG_HC_Incorrect#}</div>
	<br/>
	{config_load file=hc_pligg_lang_conf}
	<form id="thisform">
		<input type="button" onclick="gPageIsOkToExit=true; document.location.href='{$my_base_url}{$my_pligg_base}/{$pagename}.php?id={$link_id}';" value="{#PLIGG_Visual_Submit3Errors_Back#}" class="submit" />
	</form>
{/if}
<!--/hc_incorrect.tpl -->