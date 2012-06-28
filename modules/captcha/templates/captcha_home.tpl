<fieldset>
	<legend><img src="{$captcha_img_path}eye.png" align="absmiddle"/> Captcha</legend>

	<h2>Captcha Settings</h2><br />

	{if isset($msg)}
		<br />
		<p>
			<b><font color="red">{$msg}</font></b>
		<p>
		<br />
	{/if}

	<p>
		<b>Captcha Options</b>
		<ul>
			<li>Captcha in user registration 
				| {if $captcha_reg_enabled eq true}<b>Enabled</b>{else}<a href="module.php?module=captcha&captcha=default&action=EnableReg&value=true">Enable</a>{/if}
				| {if $captcha_reg_enabled eq false}<b>Disabled</b>{else}<a href="module.php?module=captcha&captcha=default&action=EnableReg&value=false">Disable</a>{/if}
			</li>
			<li>Captcha in story submission
				| {if $captcha_story_enabled eq true}<b>Enabled</b>{else}<a href="module.php?module=captcha&captcha=default&action=EnableStory&value=true">Enable</a>{/if}
				| {if $captcha_story_enabled eq false}<b>Disabled</b>{else}<a href="module.php?module=captcha&captcha=default&action=EnableStory&value=false">Disable</a>{/if}
			</li>
			<li>Captcha in comment submission 
				| {if $captcha_comment_enabled eq true}<b>Enabled</b>{else}<a href="module.php?module=captcha&captcha=default&action=EnableComment&value=true">Enable</a>{/if}
				| {if $captcha_comment_enabled eq false}<b>Disabled</b>{else}<a href="module.php?module=captcha&captcha=default&action=EnableComment&value=false">Disable</a>{/if}
			</li>
		</ul>
	</p>
	<br />
	<p>
		<b>Available Captchas</b>
		<ul>
			<li>reCaptcha | {if $captcha_method eq "reCaptcha"}<b>In Use</b>{else}<a href="module.php?module=captcha&captcha=reCaptcha&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=reCaptcha&action=configure">Configure</a></li>
			<li>WhiteHat Method | {if $captcha_method eq "WhiteHat"}<b>In Use</b>{else}<a href="module.php?module=captcha&captcha=WhiteHat&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=WhiteHat&action=configure">Configure</a></li>
			<li>Math Question | {if $captcha_method eq "math"}<b>In Use</b>{else}<a href="module.php?module=captcha&captcha=math&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=math&action=configure">Configure</a></li>
		</ul>
	<p>


</fieldset>
