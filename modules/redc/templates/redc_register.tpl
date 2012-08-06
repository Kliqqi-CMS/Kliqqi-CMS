{config_load file=redc_lang_conf}
<div class="linetop">&nbsp;</div>
<div class="leftwrapper">

<div !class="register-left">
<div class="error">{#PLIGG_REDC_Error#|replace:"%s":$domain}</div>
{config_load file=redc_pligg_lang_conf}
<form action="{$URL_register}" method="post" id="thisform">

	<h2>{#PLIGG_Visual_Register_Email#}:</h2>
	{if isset($form_email_error)}{ foreach value=error from=$form_email_error }<br /><div class="error">{$error}</div><br />{ /foreach }<br />{/if}
	{#PLIGG_Visual_Register_Lowercase#}<br />
	<input type="text" id="reg_email" name="reg_email" value="{if isset($reg_email)}{$reg_email}{/if}" size="25" tabindex="12" maxlength="128"/>
	<span id="checkit-reg-pass"><input type="button" name="reg-checkbutton2" id="reg-checkbutton2" value="{#PLIGG_Visual_Register_Verify#}" onclick="checkfield('email', this.form, this.form.reg_email)" class="submit-s" tabindex="13" /></span><br/><span id="reg_emailcheckitvalue"></span>

	{foreach from=$templatelite.post item=v key=k}
	    {if $k!='reg_email' && !strstr($k,'recaptcha_')}
		<input type="hidden" name="{$k}" value="{$v}"/>
	    {/if}
	{/foreach}

	{if isset($register_step_1_extra)}
		<br /><br />
		{$register_step_1_extra}
	{/if}


	<input type="submit" name="submit" value="{#PLIGG_Visual_Register_Create_User#}" class="log2" tabindex="16" />
</form>
</div>


</div>

