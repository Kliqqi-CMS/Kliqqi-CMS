<!-- whitehat captcha.tpl -->
<div class="control-group{if isset($register_captcha_error)} error{/if}">
	<label for="input01" class="control-label">CAPTCHA</label>
	<div class="controls">
		{if isset($register_captcha_error)}
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert">&times;</button>
				{$register_captcha_error}
			</div>
		{/if}
		<div id="whitehat_challenge">
			<div id="whitehat_image">
				<img src="{$captcha_path}captchas/WhiteHat/CaptchaSecurityImages.php" />
			</div>
			<input style="width:125px;margin:5px 0 0 0;" class="form-control col-md-3 whitehat_input" type="text" tabindex="10" size="20" name="security_code" />
			<input type="hidden" name="token" value="{$token_registration_captcha}"/>
			<p class="help-inline whitehat_details">
				{#Pligg_Captcha_Whitehat_Help#}
			</p>
			<br /><br />
		</div>
	</div>
</div>
<!--/ whitehat captcha.tpl -->