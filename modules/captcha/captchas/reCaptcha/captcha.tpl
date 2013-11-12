{* Below, wrapped in literal tags, is code that changes the theme of ReCapthca.
   You can change the theme to one of the following values:
    - white : The Pligg default
	- blackglass : A mostly-black theme
	- red : The ReCaptcha default)
	- clean : A wider see-through (uses your CSS background) theme with a grey line border
	- custom : User-defined style. See the commented lines further below for an example.
*}
{literal}
<script>
var RecaptchaOptions = {
   theme : 'custom',
   custom_theme_widget: 'recaptcha_widget',
   tabindex : 10
};
</script>
<style type="text/css">
#recaptcha_image img {width: 100%; }
</style>
{/literal}
<div class="control-group{if isset($register_captcha_error)} error{/if}">
	<label for="input01" class="control-label">
		CAPTCHA 
		| <a href="javascript:Recaptcha.reload()"><i style="font-size:16px;" class="fa fa-refresh"></i></a>
		| <a href="javascript:Recaptcha.showhelp()"><i style="font-size:16px;" class="fa fa-info"></i></a></a>
	</label>
	<div class="controls">
		{if isset($register_captcha_error)}
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert">&times;</button>
				{$register_captcha_error}
			</div>
		{/if}
		<br />
		<div id="recaptcha_widget" style="display:none">
			<div id="recaptcha_image"></div>
			<div style="color:red" class="recaptcha_only_if_incorrect_sol">Incorrect CAPTCHA please try again</div>
			<input style="width:300px;margin-top:5px;" class="form-control col-md-3" type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
			<br class="clearfix" />
			<br /><br />
		</div>
	</div>
</div>
{php}
	require_once(captcha_captchas_path . '/reCaptcha/libs/recaptchalib.php');
	$publickey = get_misc_data('reCaptcha_pubkey'); // you got this from the signup page
	echo recaptcha_get_html($publickey);
{/php}