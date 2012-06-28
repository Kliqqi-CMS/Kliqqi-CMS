<br />
<h2>ReCaptcha Configuration</h2>
<br />

	{if isset($msg)}
		<div style="font-size:16px;background:#FFFFD2;border:1px solid #000;padding:10px;margin-right:20px;font-weight:bold;">{$msg}!</div>
		<br />
	{/if}

<form>
	A 'Public Key' and a 'Private Key' are needed. You can get your own from <a href="http://recaptcha.net/whyrecaptcha.html">reCAPTCHA.net</a>.<br />
	To change your keys enter them in the input fields below and click the Submit Keys button.<br />
	<br />
	By default, Pligg uses a "global key" for ReCaptcha which allows any Pligg site to use ReCaptcha without configuring reCaptcha.<br />
	If you have mistakenly removed the default keys and aren't able to generate your own for your domain you can use these default values:<br />
	<strong>Public:</strong> 6LfwKQQAAAAAAPFCNozXDIaf8GobTb7LCKQw54EA<br />
	<strong>Private:</strong> 6LfwKQQAAAAAALQosKUrE4MepD0_kW7dgDZLR5P1<br />
	<br />
	<input type="hidden" name="module" value="captcha">
	<input type="hidden" name="captcha" value="reCaptcha">
	<input type="hidden" name="action" value="configure">
	Public Key: <input type="text" name="pubkey" size="100" value="{$captcha_pubkey}"><br />
	Private Key: <input type="text" name="prikey" size="100" value="{$captcha_prikey}"><br /><br />
	<input type="submit" value="Submit Keys">
</form>
<br />
<a href="{$URL_captcha}">Return to the Captcha Settings Page</a>