{php}
	$publickey = get_misc_data('reCaptcha_pubkey'); // you got this from the signup page
{/php}
{strip}{literal}
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
{/literal}{/strip}
<div class="g-recaptcha" data-sitekey="<?= $publickey ?>"></div>
