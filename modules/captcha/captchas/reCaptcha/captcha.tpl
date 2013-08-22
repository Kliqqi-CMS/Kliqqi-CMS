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
	<label for="input01" class="control-label">CAPTCHA</label>
	<div class="controls">
		{if isset($register_captcha_error)}
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert">&times;</button>
				{$register_captcha_error}
			</div>
		{/if}
		<div id="recaptcha_widget" style="display:none">
			<div id="recaptcha_image"></div>
			<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect CAPTCHA please try again</div>
			<input class="col-md-3" style="margin-top:5px;" type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
			<p class="help-inline">
				<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a> &nbsp;&nbsp; | &nbsp;&nbsp;
				<a href="javascript:Recaptcha.showhelp()">Help</a>
			</p>
		</div>
	</div>
</div>
{php}
	require_once(captcha_captchas_path . '/reCaptcha/libs/recaptchalib.php');
	$publickey = get_misc_data('reCaptcha_pubkey'); // you got this from the signup page
	echo recaptcha_get_html($publickey);
{/php}