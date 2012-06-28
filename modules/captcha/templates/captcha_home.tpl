<fieldset>

	<legend>Captcha Settings</legend>

	{if isset($msg)}
		<div class="alert fade in">
			<a data-dismiss="alert" class="close">×</a>
			{$msg}
		</div>
	{/if}

	<p>
		<strong>Captcha Options</strong>
		<ul>
			<li>Captcha in user registration 
				| {if $captcha_reg_enabled eq true}<strong>Enabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableReg&value=true">Enable</a>{/if}
				| {if $captcha_reg_enabled eq false}<strong>Disabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableReg&value=false">Disable</a>{/if}
			</li>
			<li>Captcha in story submission
				| {if $captcha_story_enabled eq true}<strong>Enabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableStory&value=true">Enable</a>{/if}
				| {if $captcha_story_enabled eq false}<strong>Disabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableStory&value=false">Disable</a>{/if}
			</li>
			<li>Captcha in comment submission 
				| {if $captcha_comment_enabled eq true}<strong>Enabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableComment&value=true">Enable</a>{/if}
				| {if $captcha_comment_enabled eq false}<strong>Disabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableComment&value=false">Disable</a>{/if}
			</li>
		</ul>
	</p>
	<br />
	<p>
		<strong>Available Captchas</strong>
		<ul>
			<li>reCaptcha | {if $captcha_method eq "reCaptcha"}<strong>In Use</strong>{else}<a href="module.php?module=captcha&captcha=reCaptcha&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=reCaptcha&action=configure">Configure</a></li>
			<li>WhiteHat Method | {if $captcha_method eq "WhiteHat"}<strong>In Use</strong>{else}<a href="module.php?module=captcha&captcha=WhiteHat&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=WhiteHat&action=configure">Configure</a></li>
			<li>Math Question | {if $captcha_method eq "math"}<strong>In Use</strong>{else}<a href="module.php?module=captcha&captcha=math&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=math&action=configure">Configure</a></li>
		</ul>
	<p>


</fieldset>
