{************************************
****** Registration Template ********
*************************************}

<div class="register-wrapper">

	<div class="span4 register-left">
		<h2>{#PLIGG_Visual_Register_Description_Title#}</h2>
		<p>{#PLIGG_Visual_Register_Description_Paragraph#}
			<ul>
				{#PLIGG_Visual_Register_Description_Points#}
			</ul>
		</p>
	</div>
	
	<div class="span5 register-right">
		{checkActionsTpl location="tpl_pligg_register_start"}
		<form action="{$URL_register}" class="form-horizontal" method="post" id="thisform">

			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Register_Username#}</label>
				<div class="controls">
					{if isset($form_username_error)}
						{ foreach value=error from=$form_username_error }
							<div class="alert">
								<button class="close" data-dismiss="alert">×</button>
								{$error}
							</div>
						{ /foreach }
					{/if}
					<input type="text" name="reg_username" class="input-medium reg_username" id="reg_username" value="{if isset($reg_username)}{$reg_username}{/if}" size="25" tabindex="10" maxlength="32"/>
					<br/><span class="reg_usernamecheckitvalue"></span>
				</div>
			</div>
			  
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Register_Email#}</label>
				<div class="controls">
					{if isset($form_email_error)}
						{ foreach value=error from=$form_email_error }
							<div class="alert">
								<button class="close" data-dismiss="alert">×</button>
								{$error}
							</div>
						{ /foreach }
					{/if}
					<input type="text" class="input-medium reg_email" id="reg_email" name="reg_email" value="{if isset($reg_email)}{$reg_email}{/if}" tabindex="12" maxlength="128"/>
					<br/><span class="reg_emailcheckitvalue"></span>
					<p class="help-inline">{#PLIGG_Visual_Register_Lowercase#}</p>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Register_Password#}</label>
				<div class="controls">
					{if isset($form_password_error)}
						{ foreach value=error from=$form_password_error }
							<div class="alert">
								<button class="close" data-dismiss="alert">×</button>
								{$error}
							</div>
						{ /foreach }
					{/if}
					<input type="password" class="input-medium" id="reg_password" name="reg_password" value="{if isset($reg_password)}{$reg_password}{/if}" size="25" tabindex="14"/>
					<p class="help-inline">{#PLIGG_Visual_Register_FiveChar#}</p>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label">{#PLIGG_Visual_Register_Verify_Password#}</label>
				<div class="controls">
					<input type="password" class="input-medium" id="reg_verify" name="reg_password2" value="{if isset($reg_password2)}{$reg_password2}{/if}" size="25" tabindex="15"/>
				</div>
			</div>

			{if isset($register_step_1_extra)}
				{$register_step_1_extra}
			{/if}
			<div class="form-actions">
				<input type="submit" name="submit" value="{#PLIGG_Visual_Register_Create_User#}" class="btn btn-primary" tabindex="16" />
				<input type="hidden" name="regfrom" value="full" />
			</div>
		</form>
	</div>

	 {checkActionsTpl location="tpl_pligg_register_end"}

</div>