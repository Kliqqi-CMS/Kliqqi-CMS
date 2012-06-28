{* Below, wrapped in literal tags, is code that changes the theme of ReCapthca.
   You can change the theme to one of the following values:
    - white : The Pligg default
	- blackglass : A mostly-black theme
	- red : The ReCaptcha default)
	- clean : A wider see-through (uses your CSS background) theme with a grey line border
	- custom : User-defined style. See the commented lines further below for an example.
	
	For more inforatmion on ReCaptcha themes see: http://recaptcha.net/apidocs/captcha/client.html
*}

{literal}
<script>
var RecaptchaOptions = {
   theme : 'white',
{* Delete this line and the comment brackets in the line below if you set the theme name to 'custom' *}
{*   custom_theme_widget: 'recaptcha_widget', *}
   tabindex : 16
};
</script>
{/literal}

{* Remove this line if you set the theme name to 'custom'. You should also modify the below code or corresponding CSS to fit your site.
<div id="recaptcha_widget" style="display:none">
	<div id="recaptcha_image"></div>
	<div class="recaptcha_only_if_incorrect_sol" style="color:red">Incorrect CAPTCHA please try again</div>
	
	<span class="recaptcha_only_if_image">Enter the words above:</span>

	<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />

	<br />
	<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a> &nbsp;&nbsp; | &nbsp;&nbsp;
	<a href="javascript:Recaptcha.showhelp()">Help</a>
	<br /><br />
</div>
Remove this line if you set the theme name to 'custom' *}

{if isset($register_captcha_error)}<br /><div class="error">{$register_captcha_error}</div><br />{/if}
<?php 
	require_once(captcha_captchas_path . '/reCaptcha/libs/recaptchalib.php');
	$publickey = get_misc_data('reCaptcha_pubkey'); // you got this from the signup page
	echo recaptcha_get_html($publickey);
?>
