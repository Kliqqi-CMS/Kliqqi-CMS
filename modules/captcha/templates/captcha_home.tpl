	<legend>Captcha Settings</legend>
   <table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">
	{if isset($msg)}
		<div class="alert fade in">
			<a data-dismiss="alert" class="close">×</a>
			{$msg}
		</div>
	{/if}
                        <tr><td width="250px"><strong>Available Captchas </strong></td><td>
			<tr><td width="250px">reCaptcha: </td><td> {if $captcha_method eq "reCaptcha"}<strong>In Use</strong>{else}<a href="module.php?module=captcha&captcha=reCaptcha&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=reCaptcha&action=configure">Configure</a></td></tr>
			<tr><td width="250px">WhiteHat Method: </td><td> {if $captcha_method eq "WhiteHat"}<strong>In Use</strong>{else}<a href="module.php?module=captcha&captcha=WhiteHat&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=WhiteHat&action=configure">Configure</a></td></tr>
			<tr><td width="250px">Math Question: </td><td> {if $captcha_method eq "math"}<strong>In Use</strong>{else}<a href="module.php?module=captcha&captcha=math&action=enable">Enable</a>{/if} | <a href="module.php?module=captcha&captcha=math&action=configure">Configure</a></td></tr>
                    	<br /><br />
                        <tr><td width="250px"><strong>Captcha Options </strong></td><td>
			<tr><td width="250px">Captcha in user registration: </td><td>{if $captcha_reg_enabled eq true}<strong>Enabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableReg&value=true">Enable</a>{/if} | {if $captcha_reg_enabled eq false}<strong>Disabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableReg&value=false">Disable</a>{/if}</td></tr>
                        <tr><td width="250px">Captcha in story submission:</td><td>{if $captcha_story_enabled eq true}<strong>Enabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableStory&value=true">Enable</a>{/if} | {if $captcha_story_enabled eq false}<strong>Disabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableStory&value=false">Disable</a>{/if}</td></tr>
			<tr><td width="250px">Captcha in comment submission:  </td><td>{if $captcha_comment_enabled eq true}<strong>Enabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableComment&value=true">Enable</a>{/if} | {if $captcha_comment_enabled eq false}<strong>Disabled</strong>{else}<a href="module.php?module=captcha&captcha=default&action=EnableComment&value=false">Disable</a>{/if}</td></tr>

	<br />




   </table>