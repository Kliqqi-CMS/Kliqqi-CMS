{config_load file=captcha_lang_conf}
<legend>{#Pligg_Captcha_Settings#}</legend>
{if isset($msg)}
	<div class="alert fade in">
		<a data-dismiss="alert" class="close">&times;</a>
		{$msg}
	</div>
{/if}
<p>{#Pligg_Captcha_Description#}</p>
<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
	<thead>
		<tr><th colspan="2">{#Pligg_Captcha_Captchas#}</th><tr>
	</thead>
	<tbody>
		<tr><td>{#Pligg_Captcha_Solve_Media#}: </td><td> {if $captcha_method eq "solvemedia"}<strong>In Use</strong>{else}<a href="module.php?module=captcha&captcha=solvemedia&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=solvemedia&action=configure">Configure</a></td></tr>
		<tr><td>{#Pligg_Captcha_recaptcha#}: </td><td> {if $captcha_method eq "reCaptcha"}<strong>In Use</strong>{else}<a href="module.php?module=captcha&captcha=reCaptcha&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=reCaptcha&action=configure">Configure</a></td></tr>
		<tr><td>{#Pligg_Captcha_whitehat#}: </td><td> {if $captcha_method eq "WhiteHat"}<strong>In Use</strong>{else}<a href="module.php?module=captcha&captcha=WhiteHat&action=enable">Enable</a>{/if}</td></tr>
		<tr><td>{#Pligg_Captcha_math#}: </td><td> {if $captcha_method eq "math"}<strong>In Use</strong>{else}<a href="module.php?module=captcha&captcha=math&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=math&action=configure">Configure</a></td></tr>
	</tbody>
	<thead>
		<tr><th colspan="2">{#Pligg_Captcha_options#}</th><tr>
	</thead>
	<tbody>
		<tr><td>{#Pligg_Captcha_register#}: </td><td>{if $captcha_reg_enabled eq true}<strong>Enabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableReg&value=true">Enable</a>{/if} | {if $captcha_reg_enabled eq false}<strong>Disabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableReg&value=false">Disable</a>{/if}</td></tr>
		<tr><td>{#Pligg_Captcha_story#}:</td><td>{if $captcha_story_enabled eq true}<strong>Enabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableStory&value=true">Enable</a>{/if} | {if $captcha_story_enabled eq false}<strong>Disabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableStory&value=false">Disable</a>{/if}</td></tr>
		<tr><td>{#Pligg_Captcha_comment#}:  </td><td>{if $captcha_comment_enabled eq true}<strong>Enabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableComment&value=true">Enable</a>{/if} | {if $captcha_comment_enabled eq false}<strong>Disabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableComment&value=false">Disable</a>{/if}</td></tr>
	</tbody>
</table>
{config_load file=captcha_pligg_lang_conf}