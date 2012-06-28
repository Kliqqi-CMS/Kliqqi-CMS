  {checkActionsTpl location="tpl_pligg_register_start"}
<div class="linetop">&nbsp;</div>
<div class="leftwrapper">

<div class="register-left">
<form action="{$URL_register}" method="post" id="thisform">

	<h2>{#PLIGG_Visual_Register_Username#}:</h2>
	{if isset($form_username_error)}{ foreach value=error from=$form_username_error }<br /><div class="error">{$error}</div><br />{ /foreach }<br />{/if}
	<input type="text" name="reg_username" id="reg_username" value="{if isset($reg_username)}{$reg_username}{/if}" size="25" tabindex="10" maxlength="32"/>
	<span id="checkit-reg-username"><input type="button" name="reg-checkbutton1" id="reg-checkbutton1" value="{#PLIGG_Visual_Register_Verify#}" onclick="checkfield('username', this.form, this.form.reg_username)" class="submit-s" tabindex="11" /></span><br/><span id="reg_usernamecheckitvalue"></span>

	<br />
	
	<h2>{#PLIGG_Visual_Register_Email#}:</h2>
	{if isset($form_email_error)}{ foreach value=error from=$form_email_error }<br /><div class="error">{$error}</div><br />{ /foreach }<br />{/if}
	{#PLIGG_Visual_Register_Lowercase#}<br />
	<input type="text" id="reg_email" name="reg_email" value="{if isset($reg_email)}{$reg_email}{/if}" size="25" tabindex="12" maxlength="128"/>
	<span id="checkit-reg-pass"><input type="button" name="reg-checkbutton2" id="reg-checkbutton2" value="{#PLIGG_Visual_Register_Verify#}" onclick="checkfield('email', this.form, this.form.reg_email)" class="submit-s" tabindex="13" /></span><br/><span id="reg_emailcheckitvalue"></span>
	
	<br />
	
	<h2>{#PLIGG_Visual_Register_Password#}:</h2>
	{if isset($form_password_error)}{ foreach value=error from=$form_password_error }<br /><div class="error">{$error}</div><br />{ /foreach }<br />{/if}

	{#PLIGG_Visual_Register_FiveChar#}<br />
	<input type="password" id="reg_password" name="reg_password" value="{if isset($reg_password)}{$reg_password}{/if}" size="25" tabindex="14"/>

	<br /><br />

	<h2>{#PLIGG_Visual_Register_Verify_Password#}: </h2>
	<input type="password" id="reg_verify" name="reg_password2" value="{if isset($reg_password2)}{$reg_password2}{/if}" size="25" tabindex="15"/>

	{if isset($register_step_1_extra)}
		<br /><br />
		{$register_step_1_extra}
	{/if}
	
	<input type="submit" name="submit" value="{#PLIGG_Visual_Register_Create_User#}" class="log2" tabindex="16" />
	<input type="hidden" name="regfrom" value="full"/>
</form>
</div>

<div class="register-right">
	<h2>{#PLIGG_Visual_Register_Description_Title#}</h2>
	<p>{#PLIGG_Visual_Register_Description_Paragraph#}
	<ul>
		{#PLIGG_Visual_Register_Description_Points#}
	</ul>
	</p>
</div>

</div>
    {checkActionsTpl location="tpl_pligg_register_end"}