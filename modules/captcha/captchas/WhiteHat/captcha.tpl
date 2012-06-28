{if isset($register_captcha_error)}<br /><div class="error">{$register_captcha_error}</div><br />{/if}
{#PLIGG_Visual_Register_Enter_Number#}<br />				
<img src="{$captcha_path}captchas/WhiteHat/CaptchaSecurityImages.php" /><br /><br/>
<input type="text" size="20" name="security_code" /><br /><br />
<input type="hidden" name="token" value="{$token_registration_captcha}"/>
